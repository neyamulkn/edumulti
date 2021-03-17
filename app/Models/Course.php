<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function get_subcategory(){
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function course_sections(){
        return $this->hasMany(CourseSection::class, 'course_id');
    }
    public function course_lessons(){
        return $this->hasMany(CourseLesson::class, 'course_id');
    }

    public function course_enroll(){
        return $this->hasMany(Order::class, 'course_id')->where('payment_method', '!=', 'pending');
    }

    public function reviews(){
        return $this->hasMany(Review::class)->where('status', 1);
    }
    public function videos(){
        return $this->hasMany(ProductVideo::class);
    }
}
