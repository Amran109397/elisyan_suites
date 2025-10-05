<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

// Basic Authentication Routes (without email verification)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes (if needed)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Role-based routes
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/users', function () {
            return 'Admin Users Page';
        });
        
        Route::get('/admin/settings', function () {
            return 'Admin Settings Page';
        });
    });
    
    Route::middleware(['role:property_manager'])->group(function () {
        Route::get('/property/reports', function () {
            return 'Property Reports Page';
        });
    });
    
    Route::middleware(['role:receptionist'])->group(function () {
        Route::get('/reception/bookings', function () {
            return 'Reception Bookings Page';
        });
    });
});

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});