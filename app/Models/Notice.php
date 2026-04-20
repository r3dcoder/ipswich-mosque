<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'summary',
        'category',
        'is_active',
        'is_pinned',
        'send_email_notification',
        'published_at',
        'expires_at',
        'image_path',
        'view_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_pinned' => 'boolean',
        'send_email_notification' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'view_count' => 'integer',
    ];

    public const CATEGORIES = [
        'general' => 'General',
        'prayer' => 'Prayer',
        'event' => 'Event',
        'announcement' => 'Announcement',
        'urgent' => 'Urgent',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getCategoryLabelAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPublished()
    {
        return $this->published_at && $this->published_at->isPast();
    }
}