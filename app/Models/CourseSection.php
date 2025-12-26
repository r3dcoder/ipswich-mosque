<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $fillable = [
        'page','slug','title','subtitle','is_active','sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class)->orderBy('sort_order');
    }

    public function activeCourses()
    {
        return $this->hasMany(Course::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}
