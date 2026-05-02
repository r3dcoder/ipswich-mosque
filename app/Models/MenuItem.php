<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = [
        'title',
        'url',
        'parent_id',
        'menu_group',
        'sort_order',
        'is_active',
        'open_in_new_tab',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Scope to get only parent items (no parent_id).
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by menu group.
     */
    public function scopeGroup($query, $group)
    {
        return $query->where('menu_group', $group);
    }

    /**
     * Get menu items grouped by their group type.
     */
    public static function getMenuByGroup(string $group): array
    {
        $menuItems = self::with('children')
            ->where('menu_group', $group)
            ->where('is_active', true)
            ->parents()
            ->orderBy('sort_order')
            ->get();

        return $menuItems->toArray();
    }

    /**
     * Check if this menu item has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }
}