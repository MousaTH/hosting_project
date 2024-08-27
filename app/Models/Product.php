<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'myproduct';
    protected $fillable = [
        'user_id',
        'name_of_product',
        'description_of_product',
        'categories_id',
    ];
   public function category(){
       return $this->belongsTo(Category::class);
   }
   public function user(){
       return $this->belongsTo(User::class);
   }
   public function favoritedBy(){
    return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
   }
}
