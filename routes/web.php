<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Public Routes (accessible to all visitors)
Route::get('/tours', \App\Livewire\Public\BrowseTours::class)->name('public.tours');
Route::get('/vehicles', \App\Livewire\Public\BrowseVehicles::class)->name('public.vehicles');

// Static Pages (Dynamic Content)
Route::get('/about', \App\Livewire\Public\ShowPage::class)->name('pages.about');
Route::get('/contact', \App\Livewire\Public\ShowPage::class)->name('pages.contact');
Route::get('/privacy-policy', \App\Livewire\Public\ShowPage::class)->name('pages.privacy');
Route::get('/terms-of-service', \App\Livewire\Public\ShowPage::class)->name('pages.terms');
Route::get('/disclaimer', \App\Livewire\Public\ShowPage::class)->name('pages.disclaimer');
Route::get('/sitemap', \App\Livewire\Public\ShowPage::class)->name('pages.sitemap');
Route::get('/cookie-policy', \App\Livewire\Public\ShowPage::class)->name('pages.cookie');
Route::get('/author', \App\Livewire\Public\ShowPage::class)->name('pages.author');
Route::get('/dmca', \App\Livewire\Public\ShowPage::class)->name('pages.dmca');

// Dashboard Redirection Logic
Route::get('dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'transporter' => redirect()->route('transporter.dashboard'),
        'agent' => redirect()->route('agent.dashboard'),
        'admin', 'operator' => redirect()->route('admin.dashboard'),
        default => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Fallback for serving storage files when symlink fails
Route::get('/uploads/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*')->name('storage.serve');

// Admin Authentication Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login']);

    // Super Admin Login (Alias)
    Route::get('ss/admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('super.admin.login');
    Route::post('ss/admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('super.admin.login.post');
});

// Admin Logout (Authenticated)
Route::post('admin/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('admin.logout');

// Generic Logout (All Users)
Route::post('logout', function (\App\Livewire\Actions\Logout $logout) {
    $logout();
    return redirect('/');
})->name('logout');

// Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::get('admin/approvals', \App\Livewire\Admin\PendingApprovals::class)->middleware('permission:manage_approvals')->name('admin.approvals');
    Route::get('admin/vehicle-types', \App\Livewire\Admin\VehicleTypes::class)->middleware('permission:manage_vehicle_types')->name('admin.vehicle-types');
    Route::get('admin/users', \App\Livewire\Admin\ManageUsers::class)->middleware('permission:view_users')->name('admin.users');
    Route::get('admin/users/create-staff', \App\Livewire\Admin\CreateStaff::class)->middleware('permission:edit_users')->name('admin.users.create-staff');
    Route::get('admin/users/{user}/edit', \App\Livewire\Admin\EditUser::class)->middleware('permission:edit_users')->name('admin.users.edit');
    Route::get('admin/users/{user}/permissions', \App\Livewire\Admin\ManageStaffPermissions::class)->middleware('permission:edit_users')->name('admin.users.permissions');
    Route::get('admin/packages', \App\Livewire\Admin\ManagePackages::class)->middleware('permission:manage_packages_edit')->name('admin.packages');
    Route::get('admin/users/{user}/assign-package', \App\Livewire\Admin\AssignPackage::class)->middleware('permission:manage_packages_assign')->name('admin.users.assign-package');
    Route::get('admin/settings', \App\Livewire\Admin\ManageSettings::class)->name('admin.settings');

    // Page Management
    Route::get('admin/pages', \App\Livewire\Admin\ManagePages::class)->name('admin.pages');
    Route::get('admin/pages/create', \App\Livewire\Admin\PageForm::class)->name('admin.pages.create');
    Route::get('admin/pages/{page}/edit', \App\Livewire\Admin\PageForm::class)->name('admin.pages.edit');

    // Public Fleet Management
    Route::get('admin/vehicles', \App\Livewire\Admin\PublicVehicleList::class)->middleware('permission:manage_vehicles')->name('admin.vehicles');
    Route::get('admin/vehicles/create', \App\Livewire\Admin\PublicVehicleForm::class)->middleware('permission:manage_vehicles')->name('admin.vehicles.create');
    Route::get('admin/vehicles/{vehicle}/edit', \App\Livewire\Admin\PublicVehicleForm::class)->middleware('permission:manage_vehicles')->name('admin.vehicles.edit');
});

// Transporter Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('transporter/dashboard', 'transporter.dashboard')->name('transporter.dashboard');
    Route::get('transporter/vehicles', \App\Livewire\Transporter\VehicleList::class)->name('transporter.vehicles');
    Route::get('transporter/vehicles/create', \App\Livewire\Transporter\VehicleForm::class)->name('transporter.vehicles.create');
    Route::get('transporter/vehicles/{vehicle}/edit', \App\Livewire\Transporter\VehicleForm::class)->name('transporter.vehicles.edit');
    Route::get('transporter/buy-packages', \App\Livewire\Transporter\BuyPackages::class)->name('transporter.buy-packages');
});

// Agent Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('agent/dashboard', 'agent.dashboard')->name('agent.dashboard');
    Route::get('agent/tours', \App\Livewire\Agent\TourList::class)->name('agent.tours');
    Route::get('agent/tours/create', \App\Livewire\Agent\TourForm::class)->name('agent.tours.create');
    Route::get('agent/tours/{tour}/edit', \App\Livewire\Agent\TourForm::class)->name('agent.tours.edit');
    Route::get('agent/search-vehicles', \App\Livewire\Agent\SearchVehicles::class)->name('agent.search-vehicles');
    Route::get('agent/buy-packages', \App\Livewire\Transporter\BuyPackages::class)->name('agent.buy-packages');
});

require __DIR__ . '/auth.php';
