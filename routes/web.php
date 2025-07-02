<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Login;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Agencies as AdminAgencies;
use App\Livewire\Admin\AddAgency as AdminAddAgency;
use App\Livewire\Agency\Dashboard as AgencyDashboard;
use App\Livewire\Agency\Users as AgencyUsers;
use App\Livewire\Agency\Roles as AgencyRoles;
use App\Livewire\Agency\Permissions as AgencyPermissions;
use App\Livewire\Agency\Profile as AgencyProfile;
use App\Livewire\Sales\Index;
use App\Livewire\Sales\Create;
use App\Livewire\HR\EmployeeIndex;
use App\Livewire\Agency\DynamicLists;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', Login::class)->name('login');

// Dashboard redirect route
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user(); // استخدام facade بدلاً من auth()

    if ($user->isSuperAdmin()) {
        return redirect('/admin/dashboard');
    } elseif ($user->isAgencyAdmin() || $user->isAgencyUser()) {
        return redirect('/agency/dashboard');
    }

    return redirect('/');
})->middleware('auth')->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/agencies', AdminAgencies::class)->name('admin.agencies');
    Route::get('/agencies/add', AdminAddAgency::class)->name('admin.add-agency');
    Route::get('/agencies/edit/{id}', \App\Livewire\Admin\EditAgency::class)->name('admin.edit-agency');
    Route::get('/agencies/delete/{id}', \App\Livewire\Admin\DeleteAgency::class)->name('admin.delete-agency');
});

// Agency Routes
Route::middleware(['auth', 'agency'])->prefix('agency')->group(function () {
    Route::get('/dashboard', AgencyDashboard::class)->name('agency.dashboard');
    Route::get('/users', AgencyUsers::class)->name('agency.users');
    Route::get('/roles', AgencyRoles::class)->name('agency.roles');
    Route::get('/permissions', AgencyPermissions::class)->name('agency.permissions');
    Route::get('/profile', AgencyProfile::class)->name('agency.profile');
    Route::get('/services', \App\Livewire\Agency\Services::class)->name('agency.services');

    // تم تعديل أسماء روتات المبيعات لتصبح متسقة مع باقي الروتات
    Route::get('/sales', Index::class)->name('agency.sales.index');
    Route::get('/sales/create', Create::class)->name('agency.sales.create');
});

// Logout Route
Route::post('/logout', function () {
    Auth::logout(); // استخدام facade بدلاً من auth()
    return redirect('/');
})->name('logout');

Route::get('/forgot-password', \App\Livewire\ForgotPassword::class)->name('password.request');
Route::get('/reset-password/{token}', \App\Livewire\ResetPassword::class)->name('password.reset');

// hr Routes
Route::middleware(['auth'])->group(function () {
   Route::get('/hr/employees/create', \App\Livewire\HR\EmployeeCreate::class)
    ->name('hr.employees.create');


    Route::get('/hr/employees', EmployeeIndex::class)
        ->name('hr.employees.index');

         Route::get('/hr/employees/{id}/edit', \App\Livewire\HR\EmployeeEdit::class)
        ->name('hr.employees.edit');
});


Route::middleware(['auth'])->group(function () {
   Route::get('/agency/dynamic-lists', \App\Livewire\Agency\DynamicLists::class)->name('agency.dynamic-lists');


});
