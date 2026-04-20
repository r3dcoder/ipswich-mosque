<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    /**
     * Donation categories
     */
    const CATEGORIES = [
        'general' => 'General',
        'zakat' => 'Zakat',
        'sadaqah' => 'Sadaqah',
        'fitra' => 'Fitra (Fitrana)',
        'qurbani' => 'Qurbani',
        'lillah' => 'Lillah',
        'mosque' => 'Mosque Maintenance',
        'education' => 'Education',
        'emergency' => 'Emergency Relief',
    ];

    protected $fillable = [
        'donor_name',
        'donor_email',
        'amount',
        'type',
        'category',
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

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeZakat($query)
    {
        return $query->where('category', 'zakat');
    }

    public function scopeFitra($query)
    {
        return $query->where('category', 'fitra');
    }

    public function scopeQurbani($query)
    {
        return $query->where('category', 'qurbani');
    }

    public function scopeLillah($query)
    {
        return $query->where('category', 'lillah');
    }

    public function scopeSadaqah($query)
    {
        return $query->where('category', 'sadaqah');
    }

    public function getCategoryLabelAttribute()
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }
}
