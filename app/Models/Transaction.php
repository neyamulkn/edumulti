<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paymethod_name(){
        return $this->belongsTo(PaymentSetting::class, 'payment_method');
    }

    public function student(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addedBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

}
