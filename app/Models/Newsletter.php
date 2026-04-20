<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'subject',
        'sent_count',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'sent_count' => 'integer',
    ];

    public function scopeSent($query)
    {
        return $query->whereNotNull('sent_at');
    }

    public function scopeDraft($query)
    {
        return $query->whereNull('sent_at');
    }
}