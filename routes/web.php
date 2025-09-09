<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// PUT THESE IN GROUPS LATER

// Base Routes
Route::get('/', function () {
    return view('products.index');
});
route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Product Routes
route::get('products/{products}', [ProductController::class, 'show'])->name('products.show');

// Auth Routes
Route::get('/auth/redirect/{provider}', [OAuthController::class, 'redirect']);
Route::get('/auth/callback/{provider}', [OAuthController::class, 'callback']);
route::get('auth/login', [AuthController::class, 'showLogin']);
route::post('auth/login', [AuthController::class, 'login'])->name('login');
route::get('auth/register', [AuthController::class, 'showRegister']);
route::post('auth/register', [AuthController::class, 'register'])->name('register');
route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes
route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');



