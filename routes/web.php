<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===============================
// Base Routes
// ===============================
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ===============================
// Product Routes (CRUD)
// ===============================
// Bisa pakai resource biar ringkas:
Route::resource('products', ProductController::class);

// Kalau mau manual (lebih jelas):
/*
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
*/

// ===============================
// Auth Routes
// ===============================
Route::get('/auth/redirect/{provider}', [OAuthController::class, 'redirect']);
Route::get('/auth/callback/{provider}', [OAuthController::class, 'callback']);

Route::get('auth/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('auth/login', [AuthController::class, 'login'])->name('login');

Route::get('auth/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('auth/register', [AuthController::class, 'register'])->name('register');

Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

// ===============================
// Profile Routes
// ===============================
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
