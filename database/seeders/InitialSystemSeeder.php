<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InitialSystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء super admin
        $superAdminId = DB::table('users')->insertGetId([
            'name' => 'System Owner',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'super_admin',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. إنشاء وكالة
        $agencyId = DB::table('agencies')->insertGetId([
            'name' => 'Demo Travel Agency',
            'email' => 'demo@agency.com',
            'phone' => '777777777',
            'address' => 'Yemen - Sana\'a',
            'license_number' => 'LIC123456',
            'commercial_record' => 'CR123456',
            'tax_number' => 'TAX123456',
            'logo' => null,
            'description' => 'وكالة اختبارية',
            'status' => 'active',
            'license_expiry_date' => now()->addYear(),
            'max_users' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. إنشاء دور مدير وكالة
        $adminRoleId = DB::table('roles')->insertGetId([
            'agency_id' => $agencyId,
            'name' => 'admin',
            'display_name' => 'Agency Admin',
            'description' => 'مسؤول الوكالة',
            'permissions' => json_encode(['manage_users', 'view_reports', 'create_sales']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. إنشاء مستخدم مدير الوكالة
        DB::table('users')->insert([
            'name' => 'Agency Admin',
            'email' => 'admin@agency.com',
            'password' => Hash::make('password'),
            'user_type' => 'agency_admin',
            'agency_id' => $agencyId,
            'role_id' => $adminRoleId,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
