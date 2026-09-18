<?php

namespace App\Models;

use App\Casts\StripeKeyCast;
use Illuminate\Database\Eloquent\Model;

class StripeSetting extends Model
{
    protected $fillable = [
        'mode',
        'test_public_key',
        'test_secret_key',
        'test_webhook_secret',
        'live_public_key',
        'live_secret_key',
        'live_webhook_secret',
    ];

    /**
     * Secret fields are stored as PLAIN TEXT (see StripeKeyCast).
     *
     * They used to be encrypted, which tied every key to APP_KEY: regenerating APP_KEY
     * made the stored ciphertext undecryptable and threw "The MAC is invalid." on every
     * page touching these columns. Storing them in plain text removes that failure mode
     * entirely - APP_KEY changes can no longer break donations.
     *
     * The cast stays backwards compatible: it transparently decrypts any value written
     * by the old encrypted version, and returns null (flagging the field) only for
     * legacy ciphertext that genuinely cannot be read.
     */
    protected $casts = [
        'test_secret_key'      => StripeKeyCast::class,
        'test_webhook_secret'  => StripeKeyCast::class,
        'live_secret_key'      => StripeKeyCast::class,
        'live_webhook_secret'  => StripeKeyCast::class,
    ];

    /**
     * Every secret field managed by the admin panel.
     *
     * @var array<int, string>
     */
    public const SECRET_FIELDS = [
        'test_secret_key',
        'test_webhook_secret',
        'live_secret_key',
        'live_webhook_secret',
    ];

    /**
     * Singleton settings row.
     */
    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'mode' => 'test',
        ]);
    }

    public function isLive(): bool
    {
        return $this->mode === 'live';
    }

    public function isTest(): bool
    {
        return !$this->isLive();
    }

    /**
     * Active publishable key for the frontend.
     *
     * Returns null when nothing usable is configured, so callers can rely on the
     * nullable return type instead of also checking for an empty string.
     */
    public function activePublicKey(): ?string
    {
        $key = $this->isLive() ? $this->live_public_key : $this->test_public_key;

        return self::normalise($key)
            ?? self::normalise(config('services.stripe.key'))
            ?? self::normalise(env('STRIPE_KEY'));
    }

    /**
     * Active secret key for server-side Stripe API calls.
     *
     * Returns null when nothing usable is configured, so callers can rely on the
     * nullable return type instead of also checking for an empty string.
     */
    public function activeSecretKey(): ?string
    {
        $key = $this->isLive() ? $this->live_secret_key : $this->test_secret_key;

        return self::normalise($key)
            ?? self::normalise(config('services.stripe.secret'))
            ?? self::normalise(env('STRIPE_SECRET'));
    }

    /**
     * Active webhook signing secret.
     *
     * Returns null when nothing usable is configured, so callers can rely on the
     * nullable return type instead of also checking for an empty string.
     */
    public function activeWebhookSecret(): ?string
    {
        $key = $this->isLive() ? $this->live_webhook_secret : $this->test_webhook_secret;

        return self::normalise($key)
            ?? self::normalise(env('STRIPE_WEBHOOK_SECRET'));
    }

    /**
     * Treat blank values as "not set" so a missing key is always reported as null.
     *
     * An unreadable encrypted value arrives from the cast as null, and an unset .env
     * entry can arrive as '' - both mean "no usable credential".
     */
    protected static function normalise(mixed $value): ?string
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    /**
     * The [secret, webhook] field names used by the currently active mode.
     *
     * Useful for diagnostics, so an error can name the exact column that is missing
     * or unreadable.
     *
     * @return array{0: string, 1: string}
     */
    public function activeKeyFields(): array
    {
        return $this->isLive()
            ? ['live_secret_key', 'live_webhook_secret']
            : ['test_secret_key', 'test_webhook_secret'];
    }

    /**
     * Mask a secret for display in admin (never show full value).
     */
    public static function mask(?string $value): string
    {
        if (!$value) {
            return '';
        }

        $len = strlen($value);
        if ($len <= 8) {
            return str_repeat('•', $len);
        }

        return substr($value, 0, 7) . str_repeat('•', max(6, $len - 11)) . substr($value, -4);
    }

    public function maskedTestSecret(): string
    {
        return self::mask($this->test_secret_key);
    }

    public function maskedLiveSecret(): string
    {
        return self::mask($this->live_secret_key);
    }

    public function maskedTestWebhook(): string
    {
        return self::mask($this->test_webhook_secret);
    }

    public function maskedLiveWebhook(): string
    {
        return self::mask($this->live_webhook_secret);
    }

    /**
     * Encrypted fields that hold a value which cannot be decrypted with the current
     * APP_KEY (typically because APP_KEY was regenerated or the .env was replaced).
     *
     * Reading each attribute triggers the safe cast, which records every field that
     * failed to decrypt.
     *
     * @return array<int, string>
     */
    public function unreadableEncryptedFields(): array
    {
        foreach (self::SECRET_FIELDS as $field) {
            $this->getAttributeValue($field);
        }

        return array_values(array_intersect(
            StripeKeyCast::unreadableKeys(static::class),
            self::SECRET_FIELDS
        ));
    }

    /**
     * Whether any stored encrypted value is unreadable and must be re-entered.
     */
    public function hasUnreadableEncryptedValues(): bool
    {
        return $this->unreadableEncryptedFields() !== [];
    }

    /**
     * Whether a specific encrypted field is stored but unreadable.
     */
    public function isFieldUnreadable(string $field): bool
    {
        return in_array($field, $this->unreadableEncryptedFields(), true);
    }

    /**
     * Whether the active mode has a usable secret key (admin setting or .env fallback).
     */
    public function hasUsableSecretKey(): bool
    {
        return (bool) $this->activeSecretKey();
    }

    /**
     * Whether the active mode has a usable webhook signing secret.
     */
    public function hasUsableWebhookSecret(): bool
    {
        return (bool) $this->activeWebhookSecret();
    }
}
