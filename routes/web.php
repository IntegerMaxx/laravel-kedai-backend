<?php

use App\Http\Controllers\JustUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use illuminate\Http\Request;

Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Auth::routes();

// Route::get('/dashboard', function () {
//     return view('pages.dashboard', ['type_menu' => 'dashboard']);

// });

Route::middleware(['auth'], 'roleCheck:admin')->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard', ['type_menu' => 'home']);
    })->name('home');

    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

Route::get('admin/dashboard', function() {
    return view('pages.dashboard'); // Halaman dashboard untuk admin
})->middleware('role:admin')->name('admin.dashboard');

Route::get('staff/dashboard', function() {
    return view('staff.user.index'); // Halaman dashboard untuk staff
})->middleware('role:staff')->name('staff.dashboard');

Route::get('user/index', function() {
    return view('user.user.index'); // Halaman dashboard untuk user
})->middleware('role:user')->name('user.index');
































// Route::post('/upload', [ProductController::class, 'store'])->name('upload.product');

// Tambahkan route khusus berdasarkan roles
// Route::middleware(['auth','roleCheck:user'])->group(function () {
//     Route::get('home', function () {
//         return view('pages.dashboard', ['type_menu' => 'home']);
//     })->name('home');

//     Route::get('/user/dashboard', [JustUserController::class, 'userDashboard'])->name('user.dashboard');
//     Route::resource('product', ProductController::class);
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
// });

// Route::middleware(['auth', 'roleCheck:staff'])->group(function () {
//     Route::get('home', function () {
//         return view('pages.dashboard', ['type_menu' => 'home']);
//     })->name('home');

//     Route::get('/staff/dashboard', [UserController::class, 'staffDashboard'])->name('staff.dashboard');
//     Route::resource('product', ProductController::class);
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
// });

// Route::middleware(['auth', 'roleCheck:admin'])->group(function () {
//     Route::get('home', function () {
//         return view('pages.dashboard', ['type_menu' => 'home']);
//     })->name('home');

//     Route::get('/pages/dashboard', [UserController::class, 'adminDashboard'])->name('pages.dashboard');
//     Route::resource('product', ProductController::class);
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
// });


