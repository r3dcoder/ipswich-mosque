<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'janazah_emergency_contacts';

    protected $fillable = [
        'name',
        'role_in_committee',
        'phone_number',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Scope to only visible contacts ordered by sort_order.
     */
    public function scopeVisibleOrdered($query)
    {
        return $query->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }
}
