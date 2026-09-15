<?php

namespace App\Models;

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
     * Encrypt secret fields at rest in the database.
     * Public keys are not secret but we still allow plain storage.
     */
    protected $casts = [
        'test_secret_key'      => 'encrypted',
        'test_webhook_secret'  => 'encrypted',
        'live_secret_key'      => 'encrypted',
        'live_webhook_secret'  => 'encrypted',
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
     */
    public function activePublicKey(): ?string
    {
        $key = $this->isLive() ? $this->live_public_key : $this->test_public_key;

        return $key ?: config('services.stripe.key') ?: env('STRIPE_KEY');
    }

    /**
     * Active secret key for server-side Stripe API calls.
     */
    public function activeSecretKey(): ?string
    {
        $key = $this->isLive() ? $this->live_secret_key : $this->test_secret_key;

        return $key ?: config('services.stripe.secret') ?: env('STRIPE_SECRET');
    }

    /**
     * Active webhook signing secret.
     */
    public function activeWebhookSecret(): ?string
    {
        $key = $this->isLive() ? $this->live_webhook_secret : $this->test_webhook_secret;

        return $key ?: env('STRIPE_WEBHOOK_SECRET');
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
}
