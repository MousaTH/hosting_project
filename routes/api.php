<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::resource('/products',ProductController::class);
Route::resource('/categories',CategoryController::class);


Route::post('/register',[AuthController::class , 'register']);
Route::post('/login',[AuthController::class ,'login'])->name('login');
Route::post('/logout',[AuthController::class ,'logout'])->middleware('auth:sanctum')->name('logout');

Route::get("/test",function (Request $request){
    return "api is working fine fuck adnan rap3";
});
Route::get("/profile",function (Request $request){
    //only authenticated user can access this api
return response()->json(['msg'=>'nice you are authinticated']);
})->middleware('auth:api');