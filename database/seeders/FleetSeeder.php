<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fleet;

class FleetSeeder extends Seeder
{
    public function run(): void
    {
        Fleet::truncate();

        $cars = [
            [
                'name'             => 'Innova Crysta',
                'slug'             => 'innova-crysta',
                'type'             => 'Premium SUV',
                'fuel'             => 'Diesel',
                'model_year'       => '2022–2023',
                'seats'            => 7,
                'luggage'          => '3 large bags',
                'rate_per_km'      => 14,
                'driver_allowance' => 2200,
                'min_km'           => 250,
                'badge'            => 'Most Popular',
                'emoji'            => '🚙',
                'bg_class'         => 'fleet-innova',
                'features'         => ['AC', 'GPS', 'USB Charging', 'Music System', 'First Aid Kit', 'Sanitized'],
                'best_for'         => 'Large families, Group tours, Long outstation trips',
                'description'      => 'The Innova Crysta is our flagship vehicle — the perfect companion for large families and group tours. With 7 spacious seats, ample luggage space, and a powerful diesel engine, it handles long outstation trips with ease. Every Innova in our fleet is less than 3 years old, meticulously maintained, and driven by our most experienced drivers.',
                'is_active'        => true,
                'sort_order'       => 1,
            ],
            [
                'name'             => 'Kia Creta',
                'slug'             => 'kia-creta',
                'type'             => 'Compact SUV',
                'fuel'             => 'Petrol/Diesel',
                'model_year'       => '2023',
                'seats'            => 5,
                'luggage'          => '2 large bags',
                'rate_per_km'      => 12,
                'driver_allowance' => 2000,
                'min_km'           => 250,
                'badge'            => 'Trending',
                'emoji'            => '🚗',
                'bg_class'         => 'fleet-creta',
                'features'         => ['AC', 'GPS', 'Sunroof', 'USB Charging', 'Music System'],
                'best_for'         => 'Couples, Small families, Corporate travel',
                'description'      => 'The Kia Creta brings SUV comfort at a mid-range price. Its premium cabin, sunroof, and smooth petrol/diesel options make it ideal for couples and small families who want a stylish, comfortable ride.',
                'is_active'        => true,
                'sort_order'       => 2,
            ],
            [
                'name'             => 'Ertiga',
                'slug'             => 'ertiga',
                'type'             => 'MPV · 7 Seats',
                'fuel'             => 'CNG/Petrol',
                'model_year'       => '2022–2023',
                'seats'            => 7,
                'luggage'          => '2 medium bags',
                'rate_per_km'      => 11,
                'driver_allowance' => 1800,
                'min_km'           => 250,
                'badge'            => null,
                'emoji'            => '🚐',
                'bg_class'         => 'fleet-ertiga',
                'features'         => ['AC', 'GPS', 'USB Charging', 'Economical', 'CNG Option'],
                'best_for'         => 'Budget families, Group pilgrimage, Weekend getaways',
                'description'      => 'The Ertiga is our best value for 7-passenger groups. CNG-powered for excellent fuel efficiency, it makes group travel affordable without sacrificing comfort.',
                'is_active'        => true,
                'sort_order'       => 3,
            ],
            [
                'name'             => 'Swift Dzire',
                'slug'             => 'swift-dzire',
                'type'             => 'Sedan · 4 Seats',
                'fuel'             => 'CNG/Petrol',
                'model_year'       => '2022–2024',
                'seats'            => 4,
                'luggage'          => '1–2 bags',
                'rate_per_km'      => 9,
                'driver_allowance' => 1500,
                'min_km'           => 250,
                'badge'            => 'Budget Pick',
                'emoji'            => '🚕',
                'bg_class'         => 'fleet-dzire',
                'features'         => ['AC', 'GPS', 'Fuel Efficient', 'Compact & Agile'],
                'best_for'         => 'Solo travellers, Couples, Airport transfers',
                'description'      => 'The Swift Dzire is our most economical option. Perfect for solo travellers, couples, and airport transfers, it offers excellent mileage at the lowest per-km rate in our fleet.',
                'is_active'        => true,
                'sort_order'       => 4,
            ],
        ];

        foreach ($cars as $car) {
            Fleet::create($car);
        }

        $this->command->info('  ✅ Fleet seeded (4 vehicles)');
    }
}
