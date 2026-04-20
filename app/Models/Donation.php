<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_email',
        'amount',
        'type',
        'frequency',
        'status',
        'gift_aid',
        'stripe_customer_id',
        'stripe_subscription_id',
        'stripe_payment_intent_id',
        'stripe_price_id',
        'next_payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gift_aid' => 'boolean',
        'next_payment_date' => 'datetime',
    ];

    public function scopeRegular($query)
    {
        return $query->where('type', 'regular');
    }

    public function scopeOneOff($query)
    {
        return $query->where('type', 'one-off');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}