<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/sales', [SaleController::class, 'index']);

Route::post('/sale', 'SaleController@store');


