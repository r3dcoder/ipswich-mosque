<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dua extends Model
{
    protected $fillable = [
        'dua_category_id',
        'title',
        'arabic',
        'pronunciation',
        'translation',
        'keywords',
    ];

    public function category()
    {
        return $this->belongsTo(DuaCategory::class, 'dua_category_id');
    }
}
