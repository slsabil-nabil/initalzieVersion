<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'super_admin')->first();

        if (!$superAdminRole) {
            $this->command->error('Super Admin role not found. Please run RolesSeeder first.');
            return;
        }

        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@travelsystem.com',
            'password' => Hash::make('admin123'),
            'user_type' => 'super_admin',
            'role_id' => $superAdminRole->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: admin@travelsystem.com');
        $this->command->info('Password: admin123');
    }
}
