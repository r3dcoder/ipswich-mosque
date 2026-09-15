<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    protected $fillable = ['page_id','type','sort_order','data'];

    protected $casts = [
        'data' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Allowed column counts for the "columns" block.
     */
    public static function columnCounts(): array
    {
        return [2, 3, 4];
    }

    /**
     * Width presets (as percent strings) available for a given column count.
     * Key = layout id stored in block data, value = list of column widths.
     */
    public static function columnLayouts(int $count = 2): array
    {
        return match ($count) {
            3 => [
                '33-33-33' => ['33.333%', '33.333%', '33.334%'],
                '50-25-25' => ['50%', '25%', '25%'],
                '25-50-25' => ['25%', '50%', '25%'],
                '25-25-50' => ['25%', '25%', '50%'],
            ],
            4 => [
                '25-25-25-25' => ['25%', '25%', '25%', '25%'],
                '40-20-20-20' => ['40%', '20%', '20%', '20%'],
                '20-20-20-40' => ['20%', '20%', '20%', '40%'],
            ],
            default => [
                '50-50' => ['50%', '50%'],
                '60-40' => ['60%', '40%'],
                '40-60' => ['40%', '60%'],
                '70-30' => ['70%', '30%'],
                '30-70' => ['30%', '70%'],
            ],
        };
    }

    /**
     * Resolve the width list for a stored layout, falling back to equal columns.
     */
    public static function widthsFor(int $count, ?string $layout): array
    {
        $layouts = static::columnLayouts($count);

        if ($layout && isset($layouts[$layout])) {
            return $layouts[$layout];
        }

        $each = round(100 / max(1, $count), 3);

        return array_fill(0, $count, $each . '%');
    }

    /**
     * Human readable label for a layout preset.
     */
    public static function layoutLabel(string $layout): string
    {
        return str_replace('-', ' / ', $layout) . '%';
    }

    /**
     * Gap presets for column layouts.
     */
    public static function gapOptions(): array
    {
        return [
            'none' => '0rem',
            'sm' => '0.75rem',
            'md' => '1.5rem',
            'lg' => '2.5rem',
        ];
    }

    /**
     * Resolve a gap preset to a CSS value.
     */
    public static function gapValue(?string $gap): string
    {
        $options = static::gapOptions();

        return $options[$gap] ?? $options['md'];
    }

    /**
     * Vertical alignment presets for columns.
     */
    public static function alignOptions(): array
    {
        return [
            'top' => 'flex-start',
            'center' => 'center',
            'bottom' => 'flex-end',
            'stretch' => 'stretch',
        ];
    }

    /**
     * Resolve a vertical alignment preset to a CSS value.
     */
    public static function alignValue(?string $align): string
    {
        $options = static::alignOptions();

        return $options[$align] ?? $options['top'];
    }
}

