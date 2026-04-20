<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MosqueSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MosqueSettingController extends Controller
{
    /**
     * Display the mosque settings page.
     */
    public function edit()
    {
        $settings = MosqueSetting::getSettings();
        return view('admin.mosque-settings.edit', compact('settings'));
    }

    /**
     * Update the mosque settings.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:20',
            'bank_sort_code' => 'nullable|string|max:10',
            'donation_standing_order_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $settings = MosqueSetting::getSettings();
        $settings->update($request->all());

        return redirect()->route('admin.mosque-settings.edit')
            ->with('success', 'Mosque settings updated successfully!');
    }
}