<?php

use App\Http\Controllers\AccessTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::post('/token', [AccessTokenController::class, 'generateToken']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/products', [ProductController::class, 'index']);

    Route::prefix('sales')->group(function () {
        Route::get('/', [SaleController::class, 'index']);
        Route::get('/{id}', [SaleController::class, 'show']);
        Route::post('/register', [SaleController::class, 'store']);
        Route::put('/{id}/cancel', [SaleController::class, 'cancel']);
        Route::put('/{id}/add-products', [SaleController::class, 'addProductsToSale']); 
    });
});