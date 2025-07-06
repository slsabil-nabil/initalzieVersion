<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Login;

// Authentication Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', Login::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Password Reset Routes
Route::get('/forgot-password', \App\Livewire\ForgotPassword::class)->name('password.request');
Route::get('/reset-password/{token}', \App\Livewire\ResetPassword::class)->name('password.reset');

// Main Dashboard Redirect (Based on User Role)
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->isSuperAdmin()) {
        return redirect('/admin/dashboard');
    }

    if ($user->isAgencyAdmin()) {
        if (!$user->agency || !$user->agency->setting) {
            return redirect()->route('agency.setup');
        }
        return redirect('/agency/dashboard');
    }

    if ($user->isAgencyUser()) {
        return redirect('/agency/dashboard');
    }

    return redirect('/');
})->middleware('auth')->name('dashboard');

// Admin Routes (Highest Privilege)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // Agencies Management
    Route::get('/agencies', \App\Livewire\Admin\Agencies::class)->name('admin.agencies');
    Route::get('/agencies/add', \App\Livewire\Admin\AddAgency::class)->name('admin.add-agency');
    Route::get('/agencies/edit/{id}', \App\Livewire\Admin\EditAgency::class)->name('admin.edit-agency');
    Route::get('/agencies/delete/{id}', \App\Livewire\Admin\DeleteAgency::class)->name('admin.delete-agency');

    // System Configuration
    Route::get('/dynamic-lists', \App\Livewire\Admin\DynamicLists::class)->name('admin.dynamic-lists');
});

// Agency Setup (Must complete before accessing other agency routes)
Route::get('/agency/setup', \App\Livewire\Agency\AgencySetup::class)
    ->middleware(['auth', 'agency'])
    ->name('agency.setup');

// Agency Routes
Route::middleware(['auth', 'agency'])->prefix('agency')->group(function () {
    // Core Functionality
    Route::get('/dashboard', \App\Livewire\Agency\Dashboard::class)->name('agency.dashboard');
    Route::get('/profile', \App\Livewire\Agency\Profile::class)->name('agency.profile');
    Route::get('/show', \App\Livewire\Agency\AgencyShow::class)->name('agency.show');

    // User Management
    Route::get('/users', \App\Livewire\Agency\Users::class)->name('agency.users');
    Route::get('/roles', \App\Livewire\Agency\Roles::class)->name('agency.roles');
    Route::get('/permissions', \App\Livewire\Agency\Permissions::class)->name('agency.permissions');

    // Business Operations
    Route::get('/services', \App\Livewire\Agency\Services::class)->name('agency.services');
    Route::get('/sales', \App\Livewire\Sales\Index::class)->name('agency.sales.index');
    Route::get('/sales/create', \App\Livewire\Sales\Create::class)->name('agency.sales.create');
    Route::get('/dynamic-lists', \App\Livewire\Agency\DynamicLists::class)->name('agency.dynamic-lists');
});

// HR Routes (Shared between admin and agency)
Route::middleware(['auth'])->prefix('hr')->group(function () {
    Route::get('/employees', \App\Livewire\HR\EmployeeIndex::class)->name('hr.employees.index');
    Route::get('/employees/create', \App\Livewire\HR\EmployeeCreate::class)->name('hr.employees.create');
    Route::get('/employees/{id}/edit', \App\Livewire\HR\EmployeeEdit::class)->name('hr.employees.edit');
});
