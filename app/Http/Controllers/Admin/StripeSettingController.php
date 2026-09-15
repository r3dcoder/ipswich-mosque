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

        return view('admin.stripe-settings.edit', compact('settings'));
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

        $data = [
            'mode' => $validated['mode'],
            'test_public_key' => $this->nullableTrim($validated['test_public_key'] ?? null),
            'live_public_key' => $this->nullableTrim($validated['live_public_key'] ?? null),
        ];

        // Only overwrite secrets when a new value is provided (blank = keep existing)
        foreach (['test_secret_key', 'test_webhook_secret', 'live_secret_key', 'live_webhook_secret'] as $field) {
            $value = $this->nullableTrim($validated[$field] ?? null);
            if ($value !== null) {
                $data[$field] = $value;
            }
        }

        $settings->update($data);

        return redirect()
            ->route('admin.stripe-settings.edit')
            ->with('success', 'Stripe settings saved. Active mode: ' . strtoupper($settings->fresh()->mode) . '.');
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

        return back()->with(
            'success',
            'Switched to ' . strtoupper($settings->fresh()->mode) . ' mode.'
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
