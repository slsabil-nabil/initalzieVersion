<?php

namespace App\Livewire\Agency;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Service;

class Dashboard extends Component
{
    public function render()
    {
        $agency = auth()->user()->agency;
        $user = auth()->user();
        
        // إحصائيات عامة للوكالة (لجميع المستخدمين)
        $agencyStats = [
            'totalUsers' => User::where('agency_id', $agency->id)->count(),
            'activeUsers' => User::where('agency_id', $agency->id)->where('is_active', true)->count(),
            'inactiveUsers' => User::where('agency_id', $agency->id)->where('is_active', false)->count(),
        ];
        
        // إحصائيات حسب الصلاحيات
        $permissionStats = [];
        
        // إحصائيات المستخدمين (للمديرين أو من لديهم صلاحية users.view)
        if ($user->isAgencyAdmin() || $user->hasPermission('users.view')) {
            $permissionStats['users'] = [
                'total' => $agencyStats['totalUsers'],
                'active' => $agencyStats['activeUsers'],
                'inactive' => $agencyStats['inactiveUsers'],
                'recent' => User::where('agency_id', $agency->id)
                    ->with('role')
                    ->latest()
                    ->take(5)
                    ->get()
            ];
        }
        
        // إحصائيات الأدوار (للمديرين أو من لديهم صلاحية roles.view)
        if ($user->isAgencyAdmin() || $user->hasPermission('roles.view')) {
            $permissionStats['roles'] = [
                'total' => Role::where('agency_id', $agency->id)->count(),
                'recent' => Role::where('agency_id', $agency->id)
                    ->withCount('users')
                    ->latest()
                    ->take(5)
                    ->get()
            ];
        }
        
        // إحصائيات الخدمات (للمديرين أو من لديهم صلاحية services.view)
        if ($user->isAgencyAdmin() || $user->hasPermission('services.view')) {
            $permissionStats['services'] = [
                'total' => Service::where('agency_id', $agency->id)->count(),
                'active' => Service::where('agency_id', $agency->id)->where('status', 'active')->count(),
                'inactive' => Service::where('agency_id', $agency->id)->where('status', 'inactive')->count(),
                'recent' => Service::where('agency_id', $agency->id)
                    ->latest()
                    ->take(5)
                    ->get()
            ];
        }
        
        // إحصائيات عامة للوكالة (للمديرين فقط)
        if ($user->isAgencyAdmin()) {
            $permissionStats['agency'] = [
                'name' => $agency->name,
                'status' => $agency->status,
                'maxUsers' => $agency->max_users,
                'licenseExpiry' => $agency->license_expiry_date,
                'isLicenseExpired' => $agency->license_expiry_date->isPast(),
                'daysUntilExpiry' => now()->diffInDays($agency->license_expiry_date, false)
            ];
        }

        return view('livewire.agency.dashboard', compact(
            'agency',
            'user',
            'permissionStats'
        ))->layout('layouts.agency');
    }
}
