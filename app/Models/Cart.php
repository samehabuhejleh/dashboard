<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['items'];

    public function items(){
        return $this->belongsToMany(Product::class,'cart_items')->withPivot([
            'quantity',
            'price',
            'id'
        ]);
    }

}
