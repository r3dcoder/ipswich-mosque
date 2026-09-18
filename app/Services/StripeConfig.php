<?php

namespace App\Services;

use App\Models\StripeSetting;
use Stripe\Stripe;

class StripeConfig
{
    /**
     * Configure the Stripe SDK with the active secret key from admin settings
     * (falls back to .env if admin keys are empty).
     *
     * @throws \RuntimeException when no usable secret key is available
     */
    public static function configure(): void
    {
        $secret = static::secretKey();

        if (!$secret) {
            throw new \RuntimeException(static::missingSecretKeyMessage());
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

    /**
     * Whether Stripe API calls can be made at all right now.
     */
    public static function isConfigured(): bool
    {
        return static::secretKey() !== null && static::secretKey() !== '';
    }

    /**
     * Stored Stripe credentials that are encrypted but unreadable because APP_KEY
     * changed. Empty when everything decrypts cleanly.
     *
     * @return array<int, string>
     */
    public static function unreadableFields(): array
    {
        return static::settings()->unreadableEncryptedFields();
    }

    /**
     * Human readable reason why the secret key is unavailable, distinguishing a plain
     * misconfiguration from ciphertext that was lost to an APP_KEY change.
     */
    public static function missingSecretKeyMessage(): string
    {
        $settings = static::settings();
        [$secretField, ] = $settings->activeKeyFields();

        if ($settings->isFieldUnreadable($secretField)) {
            return "The stored Stripe secret key ({$secretField}) is encrypted with a previous "
                .'APP_KEY and cannot be read. Re-enter it in Admin → Stripe Settings, or restore '
                .'the previous APP_KEY in .env.';
        }

        return 'Stripe secret key is not configured. Add it in Admin → Stripe Settings '
            .'or set STRIPE_SECRET in .env.';
    }
}
