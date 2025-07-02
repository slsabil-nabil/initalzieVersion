<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Agency;

class AgencyRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = Agency::all();

        foreach ($agencies as $agency) {
            $agencyRoles = [
                [
                    'name' => 'agency_manager',
                    'display_name' => 'مدير الوكالة',
                    'description' => 'مدير الوكالة مع جميع الصلاحيات',
                    'agency_id' => $agency->id,
                    'permissions' => [
                        'users.view',
                        'users.create',
                        'users.edit',
                        'users.delete',
                        'roles.view',
                        'roles.create',
                        'roles.edit',
                        'roles.delete',
                        'permissions.view',
                        'permissions.manage',
                    ]
                ],
                [
                    'name' => 'booking_manager',
                    'display_name' => 'مدير الحجوزات',
                    'description' => 'مدير الحجوزات في الوكالة',
                    'agency_id' => $agency->id,
                    'permissions' => [
                        'users.view',
                        'bookings.manage',
                        'customers.manage',
                        'packages.view',
                        'flights.view',
                        'hotels.view',
                    ]
                ],
                [
                    'name' => 'customer_service',
                    'display_name' => 'خدمة العملاء',
                    'description' => 'موظف خدمة العملاء',
                    'agency_id' => $agency->id,
                    'permissions' => [
                        'bookings.view',
                        'customers.manage',
                        'packages.view',
                        'flights.view',
                        'hotels.view',
                    ]
                ],
                [
                    'name' => 'sales_agent',
                    'display_name' => 'مندوب المبيعات',
                    'description' => 'مندوب مبيعات في الوكالة',
                    'agency_id' => $agency->id,
                    'permissions' => [
                        'bookings.create',
                        'customers.view',
                        'packages.view',
                        'flights.view',
                        'hotels.view',
                    ]
                ],
            ];

            foreach ($agencyRoles as $role) {
                Role::create($role);
            }
        }
    }
}
