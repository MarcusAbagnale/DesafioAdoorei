<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/products', [ProductController::class, 'index']);

Route::get('/sales', [SaleController::class, 'index']);

Route::get('/sales/{id}', [SaleController::class, 'show']);

Route::post('/register-sale', [SaleController::class, 'store']);

Route::prefix('sales')->group(function () {
    Route::get('/', [SaleController::class, 'index']);
    Route::get('/{id}', [SaleController::class, 'show']);
    Route::post('/', [SaleController::class, 'store']);
    Route::put('/{id}/cancel', [SaleController::class, 'cancel']); 
});




