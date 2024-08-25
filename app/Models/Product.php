<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'my_product';
    protected $fillable = [
        'name_of_product',
        'description_of_product',
        //'image_of_product',
        'categories_id',
    ];
    public function categories(){
        return $this->belongsTo(Category::class);
    }
}
