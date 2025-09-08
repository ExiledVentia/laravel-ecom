<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('products.index');
});

// route::resource('products', ProductController::class)->except('index');
route::get('products/{products}', [ProductController::class, 'show']);
Route::get('/auth/redirect/{provider}', [OAuthController::class, 'redirect']);
Route::get('/auth/callback/{provider}', [OAuthController::class, 'callback']);
route::get('auth/login', [AuthController::class, 'showLogin'])->name('login');
route::post('auth/login', [AuthController::class, 'login']);
route::get('auth/register', [AuthController::class, 'showRegister'])->name('register');
route::post('auth/register', [AuthController::class, 'register']);
