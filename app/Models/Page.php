<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title','slug','excerpt','meta_title','meta_description',
        'is_published','published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function blocks()
    {
        return $this->hasMany(PageBlock::class)->orderBy('sort_order');
    }
}
