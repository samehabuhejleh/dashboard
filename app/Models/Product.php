<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded=['id'];



    public function primaryImage(){
        return $this->morphOne(Image::class,'imageable')->where('is_main', true);
    }


    
    public function images(){
        return $this->morphMany(Image::class,'imageable')->where('is_main', false);
    }

}
