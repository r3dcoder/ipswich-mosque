<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanazahContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'content',
        'sort_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Available section keys used across the Janazah page.
     */
    public static function sections(): array
    {
        return [
            'hero'           => 'Hero / Intro',
            'rite_heading'   => 'Funeral Rites (Section Title)',
            'rite'           => 'Funeral Rite Step',
            'prayer_heading' => 'Janazah Prayer (Section Title)',
            'prayer'         => 'Janazah Prayer Step',
            'terms'          => 'Terms & Conditions (Main)',
            'terms_point'    => 'Terms & Conditions (Point)',
        ];
    }

    /**
     * Multi-item sections that support bulk editing together.
     */
    public static function bulkSections(): array
    {
        return [
            'rites' => [
                'label'            => 'Funeral Rites in Islam',
                'description'      => 'Section title and all funeral rite steps shown as cards on the public page.',
                'heading_section'  => 'rite_heading',
                'item_section'     => 'rite',
                'item_label'       => 'Rite step',
                'default_title'    => 'Funeral Rites in Islam',
                'default_subtitle' => 'A brief overview of the key steps observed in Islamic funeral practice.',
            ],
            'prayers' => [
                'label'            => 'How to Pray Janazah Prayer',
                'description'      => 'Section title and all prayer steps (Hanafi Madhhab) on the public page.',
                'heading_section'  => 'prayer_heading',
                'item_section'     => 'prayer',
                'item_label'       => 'Prayer step',
                'default_title'    => 'How to Pray Janazah Prayer',
                'default_subtitle' => '(Hanafi Madhhab)',
            ],
            'terms' => [
                'label'            => 'Terms & Conditions',
                'description'      => 'Main terms text and all condition points on the public page.',
                'heading_section'  => 'terms',
                'item_section'     => 'terms_point',
                'item_label'       => 'Terms point',
                'default_title'    => 'Body Wash Facility Terms & Conditions',
                'default_subtitle' => '',
                'heading_is_main'  => true,
            ],
        ];
    }

    /**
     * Human readable label for the section.
     */
    public function getSectionLabelAttribute(): string
    {
        return self::sections()[$this->section] ?? ucfirst($this->section);
    }

    /**
     * Scope to only visible items ordered by sort_order.
     */
    public function scopeVisibleOrdered($query)
    {
        return $query->where('is_visible', true)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Scope to filter by a specific section.
     */
    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }
}
