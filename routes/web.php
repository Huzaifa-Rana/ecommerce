<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', [ProductController::class, 'publicIndex'])->name('home');


// Admin-only Product CRUD
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::resource('products', ProductController::class);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});


Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('cart/{product}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout Routes
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');