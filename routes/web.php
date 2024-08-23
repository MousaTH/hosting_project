<?php

use Illuminate\Support\Facades\Route;

Route::get('/sada', function () {

    return view('welcome');
});
Route::get('/test1', function () {
    return 'hello';
});
