<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image'];



    public function books(){
        return $this->hasMany(Book::class);
    }


    public function SetNameAttribute($value){
        $this->attributes['name'] = strtolower($value);
    }


    public function getNameAttribute($value){
        return ucfirst($value);
    }
}
