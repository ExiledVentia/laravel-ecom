<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// --------------------
// BASE ROUTES
// --------------------
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --------------------
// PRODUCT ROUTES
// --------------------
// CRUD admin (create/edit/delete) - tanpa index & show
Route::resource('products', ProductController::class)->except(['index', 'show']);

// List produk (public)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Detail produk (public)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// --------------------
// AUTH ROUTES
// --------------------
// OAuth (Google / GitHub)
Route::get('/auth/redirect/{provider}', [OAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('/auth/callback/{provider}', [OAuthController::class, 'callback'])->name('oauth.callback');

// Manual login / register
Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

// --------------------
// ORDER & CHECKOUT (protected)
// --------------------
Route::middleware('auth')->group(function () {
    // Checkout (form & action)
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // Orders (user)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Profile & logout
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
});

// --------------------
// PAYMENT CALLBACK (public)
// --------------------
// Xendit akan POST ke endpoint ini
Route::post('/payment/callback', [OrderController::class, 'callback'])->name('payment.callback');
