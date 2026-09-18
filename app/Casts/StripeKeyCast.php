<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Cast for the Stripe credential columns.
 *
 * Values are stored as PLAIN TEXT. Encrypting them tied every key to APP_KEY: the
 * moment APP_KEY was regenerated (or .env was replaced), the stored ciphertext could
 * no longer be decrypted and Laravel's `encrypted` cast threw "The MAC is invalid.",
 * which took down the admin Stripe settings page and every donation request.
 *
 * This cast never encrypts on write. On read it stays backwards compatible with rows
 * written by the old encrypted version:
 *
 *   - plain text ("sk_live_...")        -> returned as-is
 *   - legacy ciphertext that decrypts   -> plaintext returned (donations keep working)
 *   - legacy ciphertext that cannot be
 *     decrypted with the current APP_KEY -> null, and the field is flagged unreadable
 *
 * Flagged fields are what the admin panel highlights so they can be re-entered, and
 * what `php artisan stripe:check-keys` reports.
 */
class StripeKeyCast implements CastsAttributes
{
    /**
     * Attributes holding unreadable legacy ciphertext, keyed by model class then attribute.
     *
     * @var array<class-string<Model>, array<string, bool>>
     */
    protected static array $unreadable = [];

    /**
     * @param  Model  $model
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, $value, array $attributes): ?string
    {
        if (! is_string($value) || trim($value) === '') {
            static::forget($model, $key);

            return null;
        }

        if (! static::looksLikeCiphertext($value)) {
            // Normal case: stored in plain text.
            static::forget($model, $key);

            return trim($value);
        }

        // Legacy row written while these columns were still encrypted.
        $plaintext = static::decryptLegacy($value);

        if ($plaintext === null) {
            static::markUnreadable($model, $key);

            Log::warning('Stripe setting holds encrypted data from an older version that cannot be read.', [
                'model' => $model::class,
                'attribute' => $key,
                'hint' => 'Stripe keys are now stored as plain text. This value was encrypted with a '
                    .'different APP_KEY, so it is unreadable. Re-enter it in Admin -> Stripe Settings, '
                    .'or run "php artisan stripe:check-keys --fix" to clear it.',
            ]);

            return null;
        }

        static::forget($model, $key);

        return $plaintext;
    }

    /**
     * Store the value exactly as given - no encryption, so APP_KEY is irrelevant.
     *
     * @param  Model  $model
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        static::forget($model, $key);

        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        return trim((string) $value);
    }

    /**
     * Whether the stored string is a Laravel encrypted payload rather than a plain key.
     *
     * Laravel ciphertext is base64-encoded JSON containing iv/value/mac. A real Stripe
     * key ("sk_live_...", "whsec_...") never matches that shape, so plain text values
     * always pass through untouched.
     */
    public static function looksLikeCiphertext(string $value): bool
    {
        $decoded = base64_decode($value, true);

        if ($decoded === false) {
            return false;
        }

        $payload = json_decode($decoded, true);

        return is_array($payload)
            && isset($payload['iv'], $payload['value'], $payload['mac']);
    }

    /**
     * Decrypt legacy ciphertext, returning null instead of ever throwing.
     */
    public static function decryptLegacy(string $value): ?string
    {
        try {
            $plaintext = decrypt($value);

            return is_string($plaintext) ? $plaintext : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Inspect a raw column value without a model instance (used by the artisan command).
     *
     * @return string one of: empty|plain|legacy-readable|legacy-unreadable
     */
    public static function inspectRaw(mixed $raw): string
    {
        if ($raw === null || trim((string) $raw) === '') {
            return 'empty';
        }

        $raw = (string) $raw;

        if (! static::looksLikeCiphertext($raw)) {
            return 'plain';
        }

        return static::decryptLegacy($raw) === null ? 'legacy-unreadable' : 'legacy-readable';
    }

    /**
     * @param  Model  $model
     */
    protected static function markUnreadable($model, string $key): void
    {
        static::$unreadable[$model::class][$key] = true;
    }

    /**
     * @param  Model  $model
     */
    protected static function forget($model, string $key): void
    {
        unset(static::$unreadable[$model::class][$key]);
    }

    /**
     * @param  Model  $model
     */
    public static function isUnreadable($model, string $key): bool
    {
        return static::$unreadable[$model::class][$key] ?? false;
    }

    /**
     * Every attribute flagged unreadable for the given model class.
     *
     * @param  class-string<Model>  $modelClass
     * @return array<int, string>
     */
    public static function unreadableKeys(string $modelClass): array
    {
        return array_keys(static::$unreadable[$modelClass] ?? []);
    }

    /**
     * Clear all recorded state (between tests, and after a repair).
     */
    public static function flush(): void
    {
        static::$unreadable = [];
    }
}
