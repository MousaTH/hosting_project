<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'myproduct';
    protected $fillable = [
        'name_of_product',
        'description_of_product',
        //'image_of_product',
        'categories_id',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
