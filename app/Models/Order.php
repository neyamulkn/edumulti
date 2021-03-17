<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courseDetails(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function get_country(){
        return $this->hasOne(Country::class, 'id', 'billing_country');
    }

    public function get_state(){
        return $this->hasOne(State::class, 'id', 'billing_region');
    }
    public function get_city(){
        return $this->hasOne(City::class, 'id',  'billing_city');
    }
    public function get_area(){
        return $this->hasOne(Area::class, 'id','billing_area');
    }
}
