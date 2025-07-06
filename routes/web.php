<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\{
    Login,
    ForgotPassword,
    ResetPassword
};
use App\Livewire\Admin\{
    Dashboard as AdminDashboard,
    Agencies as AdminAgencies,
    AddAgency as AdminAddAgency,
    EditAgency as AdminEditAgency,
    DeleteAgency as AdminDeleteAgency,
    DynamicLists as AdminDynamicLists
};
use App\Livewire\Agency\{
    Dashboard as AgencyDashboard,
    Users as AgencyUsers,
    Roles as AgencyRoles,
    Permissions as AgencyPermissions,
    Profile as AgencyProfile,
    Services as AgencyServices,
    DynamicLists as AgencyDynamicLists,
    AgencySetup,
    AgencyShow
};
use App\Livewire\Sales\{
    Index as SalesIndex,
    Create as SalesCreate
};
use App\Livewire\HR\{
    EmployeeIndex,
    EmployeeCreate,
    EmployeeEdit
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', Login::class)
    ->middleware('guest')
    ->name('login');

Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');

Route::get('/reset-password/{token}', ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard Redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match (true) {
            $user->isSuperAdmin() => redirect()->route('admin.dashboard'),
            $user->isAgencyAdmin() && (!$user->agency || !$user->agency->setting)
                => redirect()->route('agency.setup'),
            default => redirect()->route('agency.dashboard')
        };
    })->name('dashboard');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('home');
    })->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

        // Agency Management
        Route::prefix('agencies')->name('agencies.')->group(function () {
            Route::get('/', AdminAgencies::class)->name('index');
            Route::get('/add', AdminAddAgency::class)->name('create');
            Route::get('/edit/{id}', AdminEditAgency::class)->name('edit');
            Route::get('/delete/{id}', AdminDeleteAgency::class)->name('delete');
        });

        // Dynamic Lists
        Route::get('/dynamic-lists', AdminDynamicLists::class)->name('dynamic-lists');
    });

    /*
    |--------------------------------------------------------------------------
    | Agency Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['agency'])->prefix('agency')->name('agency.')->group(function () {
        // Dashboard
        Route::get('/dashboard', AgencyDashboard::class)->name('dashboard');

        // Setup (for new agencies)
        Route::get('/setup', AgencySetup::class)
            ->middleware('can:setup,App\Models\User')
            ->name('setup');

        // Agency Profile
        Route::get('/show', AgencyShow::class)->name('show');
        Route::get('/profile', AgencyProfile::class)->name('profile');

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', AgencyUsers::class)->name('index');
        });

        // Role Management
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', AgencyRoles::class)->name('index');
        });

        // Permission Management
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', AgencyPermissions::class)->name('index');
        });

        // Services
        Route::get('/services', AgencyServices::class)->name('services');

        // Dynamic Lists
        Route::get('/dynamic-lists', AgencyDynamicLists::class)->name('dynamic-lists');

        // Sales
        Route::prefix('sales')->name('sales.')->group(function () {
            Route::get('/', SalesIndex::class)->name('index');
            Route::get('/create', SalesCreate::class)->name('create');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | HR Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('hr')->name('hr.')->group(function () {
        Route::prefix('employees')->name('employees.')->group(function () {
            Route::get('/', EmployeeIndex::class)->name('index');
            Route::get('/create', EmployeeCreate::class)->name('create');
            Route::get('/{id}/edit', EmployeeEdit::class)->name('edit');
        });
    });
});
