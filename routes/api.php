<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/filter', [ProductController::class, 'filterProducts']);
Route::get('/products/filters', [ProductController::class, 'getFilters']);


// Route::middleware(['auth:sanctum', 'web'])->group(function () {
//     Route::get('/my-cart', [CartController::class, 'getCartItems']);
// });