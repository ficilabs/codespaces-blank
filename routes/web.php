<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AttendanceController;


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

    // 📷 Attendance Scanner
    Route::get('/attendance/scanner', [AttendanceController::class, 'scanner'])->name('attendance.scanner');
    Route::post('/attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');

    // 📅 Today Reports
    Route::get('/attendance/today-report', [AttendanceController::class, 'todayReport'])->name('attendance.todayReport');

    // 🛡️ Admin Only Routes
    Route::middleware(['role:Administrator'])->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::resource('grades', GradeController::class)->names('grades');
    });

});

require __DIR__ . '/auth.php';
