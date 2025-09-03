<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'image','description','author', 'user_id', 'category_id', 'status' , 'price' , 'count' ];
}
