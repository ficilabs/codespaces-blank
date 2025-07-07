<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🌐 Public Routes
Route::view('/', 'frontend.welcome')->name('/');

// 🔐 Protected Routes (Authenticated + Verified)
Route::middleware(['auth', 'verified'])->group(function () {

    // 🏠 Home
    Route::prefix('home')->name('home.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
    });

    // 🛡️ Admin Only Routes
    Route::middleware(['role:Administrator'])->group(function () {
        Route::resource('users', UserController::class)->names('users');
    });

});

require __DIR__ . '/auth.php';
