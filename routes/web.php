<?php

use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', function () {
    return view('index');
});

// Auth Routes
Route::get('/signup', [App\Http\Controllers\Auth\AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [App\Http\Controllers\Auth\AuthController::class, 'signup']);
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/password/forgot', [App\Http\Controllers\Auth\PasswordResetController::class, 'showForgot'])->name('password.forgot');
Route::post('/password/forgot', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLink']);
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showReset'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset']);

// Transporter Routes
Route::middleware(['auth'])->prefix('transporter')->name('transporter.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Transporter\VehicleController::class, 'index'])->name('dashboard');
    Route::get('/vehicles/create', [App\Http\Controllers\Transporter\VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [App\Http\Controllers\Transporter\VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{id}/edit', [App\Http\Controllers\Transporter\VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicles/{id}', [App\Http\Controllers\Transporter\VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{id}', [App\Http\Controllers\Transporter\VehicleController::class, 'destroy'])->name('vehicles.destroy');
});

// Agent Routes
Route::middleware(['auth'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Agent\SearchController::class, 'index'])->name('dashboard');
    Route::get('/search', [App\Http\Controllers\Agent\SearchController::class, 'search'])->name('search');
    Route::get('/company-listings', [App\Http\Controllers\Agent\CompanyListController::class, 'index'])->name('company.listings');
});

// Guest Routes
Route::get('/guest/leads', [App\Http\Controllers\Guest\BookingController::class, 'showLeadsForm'])->name('guest.leads');
Route::post('/guest/leads', [App\Http\Controllers\Guest\BookingController::class, 'storeLeads']);
Route::get('/guest/vehicles', [App\Http\Controllers\Guest\BookingController::class, 'showVehicles'])->name('guest.vehicles');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\DashboardController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\DashboardController::class, 'login']);
    
    Route::middleware(['auth.admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments');
        Route::post('/payments/{id}/approve', [App\Http\Controllers\Admin\PaymentController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{id}/reject', [App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');
        
        Route::get('/transporters', [App\Http\Controllers\Admin\UserController::class, 'transporters'])->name('transporters');
        Route::get('/agents', [App\Http\Controllers\Admin\UserController::class, 'agents'])->name('agents');
        Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        
        Route::get('/vehicle-types', [App\Http\Controllers\Admin\VehicleTypeController::class, 'index'])->name('vehicle-types');
        Route::post('/vehicle-types', [App\Http\Controllers\Admin\VehicleTypeController::class, 'store'])->name('vehicle-types.store');
        Route::put('/vehicle-types/{id}', [App\Http\Controllers\Admin\VehicleTypeController::class, 'update'])->name('vehicle-types.update');
        
        Route::get('/company-listings', [App\Http\Controllers\Admin\CompanyListingController::class, 'index'])->name('company-listings');
        Route::post('/company-listings/{id}/approve', [App\Http\Controllers\Admin\CompanyListingController::class, 'approve'])->name('company-listings.approve');
        
        Route::get('/settings/email', [App\Http\Controllers\Admin\SettingsController::class, 'email'])->name('settings.email');
        Route::post('/settings/email', [App\Http\Controllers\Admin\SettingsController::class, 'updateEmail']);
    });
});