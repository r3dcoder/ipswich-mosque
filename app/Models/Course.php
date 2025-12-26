<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_section_id','title','image_path','sort_order','is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function features()
    {
        return $this->hasMany(CourseFeature::class)->orderBy('sort_order');
    }
}
