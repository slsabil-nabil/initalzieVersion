<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['تذاكر', 'فنادق', 'سيارات', 'تأشيرات', 'باقات سياحية'];

        foreach ($types as $type) {
            ServiceType::create([
                'name' => $type,
            ]);
        }
    }
}
