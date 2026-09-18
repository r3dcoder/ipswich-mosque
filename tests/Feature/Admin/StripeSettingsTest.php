<?php

namespace Tests\Feature\Admin;

use App\Casts\StripeKeyCast;
use App\Models\StripeSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Guards the admin Stripe settings screen.
 *
 * These columns used to be encrypted, which broke whenever APP_KEY changed. They are
 * now plain text (see StripeKeyCast), but the page still has to report any legacy
 * ciphertext left behind by the old version. The model reads its field list from
 * StripeSetting::SECRET_FIELDS - referencing the removed ENCRYPTED_FIELDS constant
 * used to fatal this page with "Undefined constant".
 */
class StripeSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        StripeKeyCast::flush();
    }

    protected function tearDown(): void
    {
        StripeKeyCast::flush();

        parent::tearDown();
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function fakeLegacyCiphertext(): string
    {
        return base64_encode(json_encode([
            'iv' => base64_encode(random_bytes(16)),
            'value' => base64_encode('sk_test_lost'),
            'mac' => hash_hmac('sha256', 'iv-value', 'not-the-real-key'),
        ]));
    }

    public function test_secret_fields_constant_covers_every_cast_field(): void
    {
        // getCasts() also returns framework defaults (id, timestamps); only the
        // secret columns declared on the model must be listed in SECRET_FIELDS.
        $this->assertSame(
            [
                'test_secret_key',
                'test_webhook_secret',
                'live_secret_key',
                'live_webhook_secret',
            ],
            StripeSetting::SECRET_FIELDS
        );

        foreach (StripeSetting::SECRET_FIELDS as $field) {
            $this->assertSame(
                StripeKeyCast::class,
                (new StripeSetting)->getCasts()[$field] ?? null,
                "SECRET_FIELDS entry [{$field}] must use StripeKeyCast."
            );
        }
    }

    public function test_stripe_settings_page_is_displayed(): void
    {
        StripeSetting::current()->update([
            'mode' => 'test',
            'test_public_key' => 'pk_test_123',
            'test_secret_key' => 'sk_test_1234567890abcdef',
        ]);

        $response = $this->actingAs($this->admin())->get('/admin/stripe-settings');

        $response->assertOk();
        $response->assertSee('Stripe Payment Settings');
        $response->assertSee('sk_te');
    }

    public function test_plain_text_secrets_are_not_flagged_unreadable(): void
    {
        $settings = StripeSetting::current();

        $settings->update([
            'test_secret_key' => 'sk_test_1234567890abcdef',
            'live_webhook_secret' => 'whsec_abcdef123456',
        ]);

        $settings = $settings->fresh();

        $this->assertSame('sk_test_1234567890abcdef', $settings->test_secret_key);
        $this->assertSame([], $settings->unreadableEncryptedFields());
        $this->assertFalse($settings->hasUnreadableEncryptedValues());
    }

    public function test_legacy_ciphertext_that_still_decrypts_is_readable(): void
    {
        DB::table('stripe_settings')->insert([
            'mode' => 'test',
            'test_secret_key' => encrypt('sk_test_decrypted_fine'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $settings = StripeSetting::current();

        $this->assertSame('sk_test_decrypted_fine', $settings->test_secret_key);
        $this->assertSame([], $settings->unreadableEncryptedFields());
    }

    public function test_legacy_ciphertext_from_another_app_key_is_flagged_unreadable(): void
    {
        DB::table('stripe_settings')->insert([
            'mode' => 'live',
            'live_secret_key' => $this->fakeLegacyCiphertext(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $settings = StripeSetting::current();

        $this->assertNull($settings->live_secret_key);
        $this->assertSame(['live_secret_key'], $settings->unreadableEncryptedFields());
        $this->assertTrue($settings->hasUnreadableEncryptedValues());
        $this->assertTrue($settings->isFieldUnreadable('live_secret_key'));
        $this->assertFalse($settings->isFieldUnreadable('test_secret_key'));

        $response = $this->actingAs($this->admin())->get('/admin/stripe-settings');

        $response->assertOk();
        $response->assertSee('could not be read');
        $response->assertSee('live_secret_key');
    }

    public function test_saving_a_new_value_clears_the_unreadable_flag(): void
    {
        DB::table('stripe_settings')->insert([
            'mode' => 'test',
            'test_secret_key' => $this->fakeLegacyCiphertext(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($this->admin())->put('/admin/stripe-settings', [
            'mode' => 'test',
            'test_public_key' => 'pk_test_new',
            'test_secret_key' => 'sk_test_fresh_value',
        ])->assertRedirect(route('admin.stripe-settings.edit'));

        StripeKeyCast::flush();

        $settings = StripeSetting::current()->fresh();

        $this->assertSame('sk_test_fresh_value', $settings->test_secret_key);
        $this->assertSame([], $settings->unreadableEncryptedFields());
    }

    public function test_blank_secret_on_save_keeps_the_existing_value(): void
    {
        StripeSetting::current()->update([
            'mode' => 'test',
            'test_secret_key' => 'sk_test_keep_me_1234',
        ]);

        $this->actingAs($this->admin())->put('/admin/stripe-settings', [
            'mode' => 'live',
            'test_public_key' => '',
            'test_secret_key' => '',
        ])->assertRedirect(route('admin.stripe-settings.edit'));

        $settings = StripeSetting::current()->fresh();

        $this->assertSame('live', $settings->mode);
        $this->assertSame('sk_test_keep_me_1234', $settings->test_secret_key);
    }

    public function test_unreadable_value_is_cleared_when_no_replacement_is_given(): void
    {
        DB::table('stripe_settings')->insert([
            'mode' => 'test',
            'live_secret_key' => $this->fakeLegacyCiphertext(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($this->admin())->put('/admin/stripe-settings', [
            'mode' => 'test',
            'live_secret_key' => '',
        ])->assertRedirect(route('admin.stripe-settings.edit'))
            ->assertSessionHas('success');

        StripeKeyCast::flush();

        $this->assertNull(StripeSetting::current()->fresh()->live_secret_key);
        $this->assertSame([], StripeSetting::current()->unreadableEncryptedFields());
    }

    public function test_mode_toggle_reports_unreadable_keys(): void
    {
        DB::table('stripe_settings')->insert([
            'mode' => 'test',
            'live_secret_key' => $this->fakeLegacyCiphertext(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($this->admin())
            ->post('/admin/stripe-settings/toggle-mode')
            ->assertRedirect()
            ->assertSessionHas('warning');

        $this->assertSame('live', StripeSetting::current()->fresh()->mode);
    }

    public function test_non_admin_cannot_open_the_page(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/admin/stripe-settings');

        $response->assertForbidden();
    }
}
