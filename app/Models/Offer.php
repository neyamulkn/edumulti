<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offer_products(){
        return $this->hasMany(OfferProduct::class)->orderBy('position', 'asc');
    }

    public function shipping_region(){
        return $this->belongsTo(State::class, 'ship_region_id');
    }

}
