<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MosqueSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'charity_number' => 'nullable|string|max:50',
            'company_number' => 'nullable|string|max:50',
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
            'logo' => 'nullable|image|max:2048', // Max 2MB
            'favicon' => 'nullable|image|max:1024', // Max 1MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $settings = MosqueSetting::getSettings();
        
        // Get all input except files
        $data = $request->except(['logo', 'favicon', '_token', '_method']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            
            $logoPath = $request->file('logo')->store('mosque-settings/logos', 'public');
            $data['logo_path'] = $logoPath;
        }
        
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon_path && Storage::disk('public')->exists($settings->favicon_path)) {
                Storage::disk('public')->delete($settings->favicon_path);
            }
            
            $faviconPath = $request->file('favicon')->store('mosque-settings/favicons', 'public');
            $data['favicon_path'] = $faviconPath;
        }
        
        $settings->update($data);

        return redirect()->route('admin.mosque-settings.edit')
            ->with('success', 'Mosque settings updated successfully!');
    }
}