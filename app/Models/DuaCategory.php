<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuaCategory extends Model
{
    protected $fillable = ['name'];

    public function duas()
    {
        return $this->hasMany(Dua::class, 'dua_category_id');
    }
}
