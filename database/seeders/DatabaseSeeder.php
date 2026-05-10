<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            FleetSeeder::class,
            RouteSeeder::class,
            PackageSeeder::class,
            TestimonialSeeder::class,
            BlogSeeder::class,
            PageSectionSeeder::class,
            FaqSeeder::class,
            TimelineSeeder::class,
        ]);

        $this->command->info('✅ All seeders completed successfully.');
    }
}
