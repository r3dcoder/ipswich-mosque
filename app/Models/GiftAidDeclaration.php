<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftAidDeclaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_address',
        'donor_postcode',
        'donor_phone',
        'declaration_text',
        'status',
        'declared_at',
        'expires_at',
        'cancelled_at',
        'cancellation_reason',
        'total_donated',
        'total_gift_aid_claimed',
        'hmrc_reference',
        'notes',
    ];

    protected $casts = [
        'declared_at' => 'date',
        'expires_at' => 'date',
        'cancelled_at' => 'date',
        'total_donated' => 'decimal:2',
        'total_gift_aid_claimed' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeByDonor($query, $email)
    {
        return $query->where('donor_email', $email);
    }

    public function getGiftAidPercentageAttribute()
    {
        // UK Gift Aid rate is 25% (for every £1 donated, charity gets £1.25)
        return 0.25;
    }

    public function getGiftAidValueAttribute()
    {
        return $this->total_donated * $this->gift_aid_percentage;
    }

    public function updateTotals()
    {
        $donations = Donation::where('donor_email', $this->donor_email)
            ->where('gift_aid', true)
            ->where('status', 'completed')
            ->sum('amount');

        $this->total_donated = $donations;
        $this->total_gift_aid_claimed = $this->getGiftAidValueAttribute();
        $this->save();
    }

    public function canClaimGiftAid()
    {
        return $this->status === 'active' && $this->total_donated > 0;
    }
}