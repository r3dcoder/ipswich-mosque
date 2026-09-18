<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StripeSetting;
use Illuminate\Http\Request;

class StripeSettingController extends Controller
{
    public function edit()
    {
        $settings = StripeSetting::current();

        // Fields whose stored ciphertext cannot be decrypted with the current APP_KEY.
        // The page still renders (the safe cast returns null), but the admin is told
        // these values are lost and must be re-entered.
        $unreadableFields = $settings->unreadableEncryptedFields();

        return view('admin.stripe-settings.edit', compact('settings', 'unreadableFields'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:test,live',
            'test_public_key' => 'nullable|string|max:255',
            'test_secret_key' => 'nullable|string|max:255',
            'test_webhook_secret' => 'nullable|string|max:255',
            'live_public_key' => 'nullable|string|max:255',
            'live_secret_key' => 'nullable|string|max:255',
            'live_webhook_secret' => 'nullable|string|max:255',
        ]);

        $settings = StripeSetting::current();

        // Values that cannot be decrypted are useless: they will be overwritten by a new
        // entry, or cleared so the admin is not left with an unreadable placeholder.
        $unreadableFields = $settings->unreadableEncryptedFields();

        $data = [
            'mode' => $validated['mode'],
            'test_public_key' => $this->nullableTrim($validated['test_public_key'] ?? null),
            'live_public_key' => $this->nullableTrim($validated['live_public_key'] ?? null),
        ];

        $cleared = [];

        // Only overwrite secrets when a new value is provided (blank = keep existing)
        foreach (StripeSetting::SECRET_FIELDS as $field) {
            $value = $this->nullableTrim($validated[$field] ?? null);

            if ($value !== null) {
                $data[$field] = $value;
            } elseif (in_array($field, $unreadableFields, true)) {
                // Unreadable ciphertext with no replacement: drop it.
                $data[$field] = null;
                $cleared[] = $field;
            }
        }

        $settings->update($data);

        $settings = $settings->fresh();

        $message = 'Stripe settings saved. Active mode: ' . strtoupper($settings->mode) . '.';

        if ($cleared !== []) {
            $message .= ' Unreadable values were cleared: '
                . implode(', ', $cleared) . '. Please re-enter them.';
        }

        if ($settings->hasUnreadableEncryptedValues()) {
            return redirect()
                ->route('admin.stripe-settings.edit')
                ->with('warning', $message . ' Some stored values are still unreadable.');
        }

        return redirect()
            ->route('admin.stripe-settings.edit')
            ->with('success', $message);
    }

    /**
     * Quick toggle between test and live without full form submit.
     */
    public function toggleMode(Request $request)
    {
        $settings = StripeSetting::current();
        $settings->update([
            'mode' => $settings->isLive() ? 'test' : 'live',
        ]);

        $settings = $settings->fresh();

        if ($settings->hasUnreadableEncryptedValues()) {
            return back()->with(
                'warning',
                'Switched to ' . strtoupper($settings->mode) . ' mode, but some stored keys are '
                . 'unreadable (APP_KEY changed). Re-enter them to resume payments.'
            );
        }

        return back()->with(
            'success',
            'Switched to ' . strtoupper($settings->mode) . ' mode.'
        );
    }

    private function nullableTrim(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }
}
