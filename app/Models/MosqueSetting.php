<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MosqueSetting extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'twitter_url',
        'bank_account_name',
        'bank_name',
        'bank_account_number',
        'bank_sort_code',
        'donation_standing_order_url',
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
        ]);
    }
}