<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InitialAgencySeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء وكالة
        $agencyId = DB::table('agencies')->insertGetId([
            'name' => 'وكالة المستقبل',
            'email' => 'future@agency.com',
            'phone' => '777777777',
            'address' => 'صنعاء - شارع حدة',
            'license_number' => 'LIC-001',
            'commercial_record' => 'CR-001',
            'tax_number' => 'TAX-001',
            'logo' => null,
            'description' => 'وكالة تجريبية',
            'status' => 'active',
            'license_expiry_date' => now()->addYear(),
            'max_users' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. إنشاء دور مبيعات
        $roleId = DB::table('roles')->insertGetId([
            'name' => 'sales_agent',
            'display_name' => 'موظف مبيعات',
            'agency_id' => $agencyId,
            'permissions' => json_encode(['create_sales', 'view_sales']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. إنشاء مستخدم مبيعات
        DB::table('users')->insert([
            'name' => 'مستخدم مبيعات',
            'email' => 'sales@agency.com',
            'password' => Hash::make('password'), // كلمة المرور: password
            'agency_id' => $agencyId,
            'role_id' => $roleId,
            'user_type' => 'agency_user',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
