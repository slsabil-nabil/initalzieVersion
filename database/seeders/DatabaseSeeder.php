<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            InitialSystemSeeder::class,
            RolesSeeder::class,
            SuperAdminSeeder::class,
            AgencyRolesSeeder::class,
            InitialAgencySeeder::class,
            CustomerSeeder::class,
            ServiceTypeSeeder::class,
            ProviderSeeder::class,
            IntermediarySeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,

        ]);
    }
}
