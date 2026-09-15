<?php

namespace App\Services;

use App\Models\StripeSetting;
use Stripe\Stripe;

class StripeConfig
{
    /**
     * Configure the Stripe SDK with the active secret key from admin settings
     * (falls back to .env if admin keys are empty).
     */
    public static function configure(): void
    {
        $secret = static::secretKey();

        if (!$secret) {
            throw new \RuntimeException('Stripe secret key is not configured. Add it in Admin → Stripe Settings.');
        }

        Stripe::setApiKey($secret);
    }

    public static function settings(): StripeSetting
    {
        return StripeSetting::current();
    }

    public static function publicKey(): ?string
    {
        return static::settings()->activePublicKey();
    }

    public static function secretKey(): ?string
    {
        return static::settings()->activeSecretKey();
    }

    public static function webhookSecret(): ?string
    {
        return static::settings()->activeWebhookSecret();
    }

    public static function mode(): string
    {
        return static::settings()->mode === 'live' ? 'live' : 'test';
    }

    public static function isLive(): bool
    {
        return static::mode() === 'live';
    }
}
