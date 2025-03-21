<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;
    protected $guarded= ['id'];

    protected $casts = [
        'status' => OrderStatus::class, 
    ];

    public function address(){
        return $this->belongsTo(Address::class,'address_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');

    }
}
