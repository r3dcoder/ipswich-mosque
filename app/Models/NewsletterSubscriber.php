<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'is_subscribed',
        'subscription_token',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->subscription_token)) {
                $model->subscription_token = Str::random(40);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_subscribed', true);
    }

    public function unsubscribe()
    {
        $this->update([
            'is_subscribed' => false,
            'unsubscribed_at' => now(),
        ]);
    }

    public function resubscribe()
    {
        $this->update([
            'is_subscribed' => true,
            'unsubscribed_at' => null,
            'subscribed_at' => now(),
        ]);
    }
}