<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\Inventory\CategoryController;
use App\Http\Controllers\Admin\Inventory\ItemController;
use App\Http\Controllers\Admin\Inventory\LocationController;
use App\Http\Controllers\Admin\Inventory\TransactionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AlertController as AdminAlertController;
use App\Http\Controllers\Employee\AuthController as EmployeeAuthController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\BookingController as EmployeeBookingController;
use App\Http\Controllers\Employee\ServiceController as EmployeeServiceController;
use App\Http\Controllers\Employee\AlertController as EmployeeAlertController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::resource('locations', LocationController::class);
            Route::resource('categories', CategoryController::class);
        Route::resource('items', ItemController::class);
        Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
        });

        Route::resource('employees', EmployeeController::class);
        Route::post('employees/{employee}/reset-password', [EmployeeController::class, 'resetPassword'])
            ->name('employees.reset-password');

        Route::get('bookings/available', [BookingController::class, 'availableRooms'])
            ->name('bookings.available');
        Route::post('bookings/{booking}/checkout', [BookingController::class, 'checkout'])
            ->name('bookings.checkout');
        Route::resource('bookings', BookingController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('media', MediaController::class)->except(['show']);
        Route::resource('alerts', AdminAlertController::class)->only(['index', 'show']);
        Route::post('alerts/{alert}/acknowledge', [AdminAlertController::class, 'acknowledge'])->name('alerts.acknowledge');
        Route::post('alerts/{alert}/resolve', [AdminAlertController::class, 'resolve'])->name('alerts.resolve');
    });
});

Route::prefix('employee')->name('employee.')->group(function () {
    Route::middleware('guest:employee')->group(function () {
        Route::get('login', [EmployeeAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [EmployeeAuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth:employee')->group(function () {
        Route::get('/', [EmployeeDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [EmployeeAuthController::class, 'logout'])->name('logout');

        Route::resource('bookings', EmployeeBookingController::class)->except(['show']);
        Route::post('bookings/{booking}/transfer', [EmployeeBookingController::class, 'transfer'])->name('bookings.transfer');

        Route::resource('services', EmployeeServiceController::class)->except(['show']);

        Route::resource('alerts', EmployeeAlertController::class)->only(['index', 'create', 'store']);
    });
});
