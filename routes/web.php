<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\BeanDeliveryController;
use App\Http\Controllers\ProductionOrderController;
use App\Http\Controllers\MachineBreakdownController;
use App\Http\Controllers\ProductionLogController;
use App\Http\Controllers\QualityCheckController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LanguageController;

// Public home -> dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Auth routes (login only, no registration)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Public read-only routes (index + show)
Route::get('bean-deliveries', [BeanDeliveryController::class, 'index'])->name('bean-deliveries.index');
Route::get('bean-deliveries/{bean_delivery}', [BeanDeliveryController::class, 'show'])->name('bean-deliveries.show');

Route::get('production-orders', [ProductionOrderController::class, 'index'])->name('production-orders.index');
Route::get('production-orders/type/{type}', [ProductionOrderController::class, 'indexByType'])->name('production-orders.by-type');
Route::get('production-orders/{production_order}', [ProductionOrderController::class, 'show'])->name('production-orders.show');

Route::get('production-logs', [ProductionLogController::class, 'index'])->name('production-logs.index');
Route::get('production-logs/{production_log}', [ProductionLogController::class, 'show'])->name('production-logs.show');

Route::get('machine-breakdowns', [MachineBreakdownController::class, 'index'])->name('machine-breakdowns.index');
Route::get('machine-breakdowns/{machine_breakdown}', [MachineBreakdownController::class, 'show'])->name('machine-breakdowns.show');

Route::get('quality-checks', [QualityCheckController::class, 'index'])->name('quality-checks.index');
Route::get('quality-checks/{quality_check}', [QualityCheckController::class, 'show'])->name('quality-checks.show');

// Admin-only routes (create, edit, update, delete for all resources + machine/user management)
Route::middleware(['auth', 'admin'])->group(function () {
    // Bean Deliveries CRUD
    Route::get('bean-deliveries/create', [BeanDeliveryController::class, 'create'])->name('bean-deliveries.create');
    Route::post('bean-deliveries', [BeanDeliveryController::class, 'store'])->name('bean-deliveries.store');
    Route::get('bean-deliveries/{bean_delivery}/edit', [BeanDeliveryController::class, 'edit'])->name('bean-deliveries.edit');
    Route::put('bean-deliveries/{bean_delivery}', [BeanDeliveryController::class, 'update'])->name('bean-deliveries.update');
    Route::delete('bean-deliveries/{bean_delivery}', [BeanDeliveryController::class, 'destroy'])->name('bean-deliveries.destroy');

    // Production Orders CRUD
    Route::get('production-orders/create', [ProductionOrderController::class, 'create'])->name('production-orders.create');
    Route::post('production-orders', [ProductionOrderController::class, 'store'])->name('production-orders.store');
    Route::get('production-orders/{production_order}/edit', [ProductionOrderController::class, 'edit'])->name('production-orders.edit');
    Route::put('production-orders/{production_order}', [ProductionOrderController::class, 'update'])->name('production-orders.update');
    Route::delete('production-orders/{production_order}', [ProductionOrderController::class, 'destroy'])->name('production-orders.destroy');

    // Production Logs CRUD
    Route::get('production-logs/create', [ProductionLogController::class, 'create'])->name('production-logs.create');
    Route::post('production-logs', [ProductionLogController::class, 'store'])->name('production-logs.store');
    Route::get('production-logs/{production_log}/edit', [ProductionLogController::class, 'edit'])->name('production-logs.edit');
    Route::put('production-logs/{production_log}', [ProductionLogController::class, 'update'])->name('production-logs.update');
    Route::delete('production-logs/{production_log}', [ProductionLogController::class, 'destroy'])->name('production-logs.destroy');

    // Machine Breakdowns CRUD
    Route::get('machine-breakdowns/create', [MachineBreakdownController::class, 'create'])->name('machine-breakdowns.create');
    Route::post('machine-breakdowns', [MachineBreakdownController::class, 'store'])->name('machine-breakdowns.store');
    Route::get('machine-breakdowns/{machine_breakdown}/edit', [MachineBreakdownController::class, 'edit'])->name('machine-breakdowns.edit');
    Route::put('machine-breakdowns/{machine_breakdown}', [MachineBreakdownController::class, 'update'])->name('machine-breakdowns.update');
    Route::delete('machine-breakdowns/{machine_breakdown}', [MachineBreakdownController::class, 'destroy'])->name('machine-breakdowns.destroy');

    // Quality Checks CRUD
    Route::get('quality-checks/create', [QualityCheckController::class, 'create'])->name('quality-checks.create');
    Route::post('quality-checks', [QualityCheckController::class, 'store'])->name('quality-checks.store');
    Route::get('quality-checks/{quality_check}/edit', [QualityCheckController::class, 'edit'])->name('quality-checks.edit');
    Route::put('quality-checks/{quality_check}', [QualityCheckController::class, 'update'])->name('quality-checks.update');
    Route::delete('quality-checks/{quality_check}', [QualityCheckController::class, 'destroy'])->name('quality-checks.destroy');

    // Admin: Machine & User management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('machines', MachineController::class);
        Route::patch('machines/{machine}/restore', [MachineController::class, 'restore'])->name('machines.restore')->withTrashed();
        Route::resource('users', UserController::class);
    });
});
