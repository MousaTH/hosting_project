<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';  // this will override the default 'categories' table name in the database.
    protected $fillable = ['category_name','category_icon'];
    public function myproduct()
    {
        return $this->hasMany(Product::class);
    }
}
