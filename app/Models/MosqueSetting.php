<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueSetting extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'charity_number',
        'company_number',
        'address',
        'office_monday_friday',
        'office_saturday',
        'office_sunday',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'twitter_url',
        'bank_account_name',
        'bank_name',
        'bank_account_number',
        'bank_sort_code',
        'donation_standing_order_url',
        'logo_path',
        'favicon_path',
    ];

    /**
     * Get the mosque settings. Since there's typically only one set of settings,
     * this helper method returns the first record or creates a new one with defaults.
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'name' => 'Ipswich Mosque',
            'phone' => null,
            'email' => null,
            'charity_number' => null,
            'company_number' => null,
            'address' => null,
            'facebook_url' => null,
            'instagram_url' => null,
            'youtube_url' => null,
            'twitter_url' => null,
            'bank_account_name' => null,
            'bank_name' => null,
            'bank_account_number' => null,
            'bank_sort_code' => null,
            'donation_standing_order_url' => null,
            'logo_path' => null,
            'favicon_path' => null,
        ]);
    }

    /**
     * Get the URL to the logo image.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    /**
     * Get the URL to the favicon image.
     */
    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon_path ? asset('storage/' . $this->favicon_path) : null;
    }
}