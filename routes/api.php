<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;

Route::resource('/categories',CategoryController::class);


Route::post('/register',[AuthController::class , 'register']);
Route::post('/login',[AuthController::class ,'login'])->name('login');


Route::get("/test",function (Request $request){
    return "api is working fine fuck adnan rap3";
});
Route::get("/profile",function (Request $request){
    //only authenticated user can access this api
return response()->json(['msg'=>'nice you are authinticated']);
})->middleware('auth');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/logout',[AuthController::class ,'logout'])->middleware('auth:sanctum')->name('logout');
    Route::resource('/products',ProductController::class);
    Route::post('/favorites/{product}',[FavoriteController::class,'toggleFavorite']);
    Route::get('/favorites',[FavoriteController::class,'index']);
});