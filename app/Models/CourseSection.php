<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    public function courseLessons(){
        return $this->hasMany(CourseLesson::class, 'section_id');
    }
}
