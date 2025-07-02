<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function mount()
    {
        // التحقق من أن المستخدم سوبر أدمن
        if (!Auth::user()->isSuperAdmin()) {
            return redirect('/login');
        }
    }

    public function getTotalAgenciesProperty()
    {
        return Agency::count();
    }

    public function getActiveAgenciesProperty()
    {
        return Agency::where('status', 'active')->count();
    }

    public function getTotalUsersProperty()
    {
        return User::where('user_type', '!=', 'super_admin')->count();
    }

    public function getRecentAgenciesProperty()
    {
        return Agency::latest()->take(5)->get();
    }

    public function getRecentUsersProperty()
    {
        return User::where('user_type', '!=', 'super_admin')
            ->with('agency')
            ->latest()
            ->take(5)
            ->get();
    }

    public function getExpiringLicensesProperty()
    {
        return Agency::where('license_expiry_date', '<=', now()->addDays(30))
            ->where('status', 'active')
            ->get();
    }

    public function render()
    {
        $totalAgencies = Agency::count();
        $activeAgencies = Agency::where('status', 'active')->count();
        $pendingAgencies = Agency::where('status', 'pending')->count();
        $totalAgencyAdmins = User::where('user_type', 'agency_admin')->count();
        
        $recentAgencies = Agency::with('admin')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalAgencies',
            'activeAgencies', 
            'pendingAgencies',
            'totalAgencyAdmins',
            'recentAgencies'
        ))->layout('layouts.admin')
          ->title('لوحة تحكم مدير النظام - نظام إدارة وكالات السفر');
    }
}
