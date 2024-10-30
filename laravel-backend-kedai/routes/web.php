<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Auth::routes();

// Route::get('/dashboard', function () {
//     return view('pages.dashboard', ['type_menu' => 'dashboard']);

// });

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');

    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

// Route::post('/upload', [ProductController::class, 'store'])->name('upload.product');


