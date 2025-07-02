<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'مدير النظام',
                'description' => 'مدير النظام مع جميع الصلاحيات',
                'permissions' => [
                    'manage_agencies',
                    'manage_users',
                    'manage_roles',
                    'view_reports',
                    'manage_system_settings',
                    'manage_bookings',
                    'manage_customers',
                    'manage_packages',
                    'manage_flights',
                    'manage_hotels',
                ]
            ],
            [
                'name' => 'agency_admin',
                'display_name' => 'مدير الوكالة',
                'description' => 'مدير وكالة السفر مع صلاحيات إدارة الوكالة',
                'permissions' => [
                    'manage_agency_users',
                    'manage_agency_settings',
                    'view_agency_reports',
                    'manage_bookings',
                    'manage_customers',
                    'manage_packages',
                    'manage_flights',
                    'manage_hotels',
                ]
            ],
            [
                'name' => 'booking_manager',
                'display_name' => 'مدير الحجوزات',
                'description' => 'مدير الحجوزات في الوكالة',
                'permissions' => [
                    'manage_bookings',
                    'view_customers',
                    'view_packages',
                    'view_flights',
                    'view_hotels',
                ]
            ],
            [
                'name' => 'customer_service',
                'display_name' => 'خدمة العملاء',
                'description' => 'موظف خدمة العملاء',
                'permissions' => [
                    'view_bookings',
                    'manage_customers',
                    'view_packages',
                    'view_flights',
                    'view_hotels',
                ]
            ],
            [
                'name' => 'sales_agent',
                'display_name' => 'مندوب المبيعات',
                'description' => 'مندوب مبيعات في الوكالة',
                'permissions' => [
                    'create_bookings',
                    'view_customers',
                    'view_packages',
                    'view_flights',
                    'view_hotels',
                ]
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
