<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = ['name', 'image', 'price', 'description', 'additional_info', 'category_id', 'subcategory_id'];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
