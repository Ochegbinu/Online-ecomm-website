<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', function () {
    return Inertia::render('CartPage');
});


Route::get('/check-out', function () {
    return Inertia::render('DetailedCheckoutPage');
});

Route::post('/api/cart', [CartController::class, 'addToCart'])->middleware(\App\Http\Middleware\GuestCartMiddleware::class);
Route::get('/api/cart/item-count', [CartController::class, 'getCartItemCount']);

Route::get('/api/my-cart', [CartController::class, 'getCartItems'])->middleware(\App\Http\Middleware\GuestCartMiddleware::class);
Route::delete('/api/cart/{productId}', [CartController::class, 'removeFromCart']);

Route::get('/payment-successful', function () {
    return Inertia::render('PaymentSuccessful');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', function () {
        return Inertia::render('MyOrders');
    }); 
    Route::get('/api/orders', [OrderController::class, 'apiIndex']);
    Route::put('/api/orders/{order}/cancel', [OrderController::class, 'cancelOrder']);
});
