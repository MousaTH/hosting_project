<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {

    return view('welcome');
});
Route::get('/test1', function () {
    return 'hello';
});
//test data base

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Successfully connected to the database!";
    } catch (\Exception $e) {
        return "Could not connect to the database. Error: " . $e->getMessage();

    }
});
Route::get('/table-info/{table}', function ($table) {
    $columns = DB::select("SELECT column_name, data_type 
                           FROM information_schema.columns 
                           WHERE table_name = ?", [$table]);
    return response()->json($columns);
});