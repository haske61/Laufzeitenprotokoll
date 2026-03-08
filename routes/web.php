<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\BeanDeliveryController;
use App\Http\Controllers\ProductionOrderController;
use App\Http\Controllers\MachineBreakdownController;
use App\Http\Controllers\ProductionLogController;
use App\Http\Controllers\QualityCheckController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LanguageController;

// Auth routes
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bean Deliveries
    Route::resource('bean-deliveries', BeanDeliveryController::class);

    // Production Orders (both nibs and mass)
    Route::resource('production-orders', ProductionOrderController::class);
    Route::get('/production-orders/type/{type}', [ProductionOrderController::class, 'indexByType'])->name('production-orders.by-type');

    // Production Logs
    Route::resource('production-logs', ProductionLogController::class);

    // Machine Breakdowns
    Route::resource('machine-breakdowns', MachineBreakdownController::class);

    // Quality Checks
    Route::resource('quality-checks', QualityCheckController::class);

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('machines', MachineController::class);
        Route::patch('machines/{machine}/restore', [MachineController::class, 'restore'])->name('machines.restore')->withTrashed();
        Route::resource('users', UserController::class);
    });
});
