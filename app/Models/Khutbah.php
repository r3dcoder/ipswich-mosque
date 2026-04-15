<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khutbah extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'youtube_url',
        'youtube_id',
        'thumbnail_url',
        'speaker',
        'category',
        'delivered_date',
        'duration',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'delivered_date' => 'date',
        'duration' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Available categories.
     */
    public static function categories(): array
    {
        return [
            'general' => 'General',
            'family' => 'Family Life',
            'spirituality' => 'Spirituality',
            'history' => 'Islamic History',
            'youth' => 'Youth',
            'marriage' => 'Marriage',
            'quran' => 'Quran',
            'hadith' => 'Hadith',
            'character' => 'Character Development',
        ];
    }

    /**
     * Get the category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::categories()[$this->category] ?? 'General';
    }

    /**
     * Get the formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration) {
            return '';
        }
        
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        
        return "{$minutes} min";
    }

    /**
     * Get the formatted date.
     */
    public function getFormattedDateAttribute(): string
    {
        if (!$this->delivered_date) {
            return '';
        }
        
        return $this->delivered_date->format('M d, Y');
    }

    /**
     * Scope to get featured khutbahs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get active khutbahs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order and latest.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    /**
     * Scope to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        
        return $query;
    }
}