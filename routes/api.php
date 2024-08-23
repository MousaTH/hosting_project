<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::resource('/products',ProductController::class);
Route::resource('/categories',CategoryController::class);


Route::post('/register',AuthController::class . '@register');
Route::post('/login',AuthController::class .'@login')->middleware('auth:sanctum');
Route::post('/logout',AuthController::class . '@logout')->middleware('auth:sanctum');


