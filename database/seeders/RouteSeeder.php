<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        Route::truncate();

        $routes = [
            [
                'from_city'    => 'Delhi', 'to_city' => 'Agra',
                'slug'         => 'delhi-to-agra',
                'distance_km'  => 240, 'duration_hrs' => 3.5,
                'highway'      => 'NH19 · Yamuna Expressway',
                'highlight'    => 'Taj Mahal',
                'tag'          => 'Weekend',
                'accent_color' => '#D4A017',
                'price_dzire'  => 2200,  'price_ertiga' => 2650,
                'price_creta'  => 2880,  'price_innova' => 3360,
                'sort_order'   => 1,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Jaipur',
                'slug'         => 'delhi-to-jaipur',
                'distance_km'  => 270, 'duration_hrs' => 4.0,
                'highway'      => 'NH48',
                'highlight'    => 'Pink City',
                'tag'          => 'Rajasthan',
                'accent_color' => '#4A90D9',
                'price_dzire'  => 2430,  'price_ertiga' => 2970,
                'price_creta'  => 3240,  'price_innova' => 3780,
                'sort_order'   => 2,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Manali',
                'slug'         => 'delhi-to-manali',
                'distance_km'  => 530, 'duration_hrs' => 10.0,
                'highway'      => 'NH3 via Chandigarh',
                'highlight'    => 'Hill Station',
                'tag'          => 'Hills',
                'accent_color' => '#8E44AD',
                'price_dzire'  => null,   'price_ertiga' => null,
                'price_creta'  => 6360,   'price_innova' => 7420,
                'sort_order'   => 3,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Shimla',
                'slug'         => 'delhi-to-shimla',
                'distance_km'  => 345, 'duration_hrs' => 6.0,
                'highway'      => 'NH5',
                'highlight'    => 'Hill Queen',
                'tag'          => 'Hills',
                'accent_color' => '#E74C3C',
                'price_dzire'  => null,   'price_ertiga' => 3795,
                'price_creta'  => 4140,   'price_innova' => 4830,
                'sort_order'   => 4,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Rishikesh',
                'slug'         => 'delhi-to-rishikesh',
                'distance_km'  => 250, 'duration_hrs' => 5.0,
                'highway'      => 'NH58',
                'highlight'    => 'Yoga Capital',
                'tag'          => 'Spiritual',
                'accent_color' => '#27AE60',
                'price_dzire'  => 2250,  'price_ertiga' => 2750,
                'price_creta'  => null,   'price_innova' => 3500,
                'sort_order'   => 5,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Haridwar',
                'slug'         => 'delhi-to-haridwar',
                'distance_km'  => 220, 'duration_hrs' => 4.0,
                'highway'      => 'NH58',
                'highlight'    => 'Ganga Aarti',
                'tag'          => 'Spiritual',
                'accent_color' => '#F39C12',
                'price_dzire'  => 1980,  'price_ertiga' => 2420,
                'price_creta'  => null,   'price_innova' => 3080,
                'sort_order'   => 6,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Chandigarh',
                'slug'         => 'delhi-to-chandigarh',
                'distance_km'  => 250, 'duration_hrs' => 4.5,
                'highway'      => 'NH44',
                'highlight'    => 'Rock Garden',
                'tag'          => 'Weekend',
                'accent_color' => '#16A085',
                'price_dzire'  => 2250,  'price_ertiga' => 2750,
                'price_creta'  => 3000,   'price_innova' => 3500,
                'sort_order'   => 7,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Jodhpur',
                'slug'         => 'delhi-to-jodhpur',
                'distance_km'  => 600, 'duration_hrs' => 9.0,
                'highway'      => 'NH62',
                'highlight'    => 'Blue City',
                'tag'          => 'Rajasthan',
                'accent_color' => '#E67E22',
                'price_dzire'  => null,   'price_ertiga' => 6600,
                'price_creta'  => 7200,   'price_innova' => 8400,
                'sort_order'   => 8,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Dehradun',
                'slug'         => 'delhi-to-dehradun',
                'distance_km'  => 290, 'duration_hrs' => 5.0,
                'highway'      => 'NH58',
                'highlight'    => 'Doon Valley',
                'tag'          => 'Hills',
                'accent_color' => '#1ABC9C',
                'price_dzire'  => 2610,  'price_ertiga' => 3190,
                'price_creta'  => 3480,   'price_innova' => 4060,
                'sort_order'   => 9,
            ],
            [
                'from_city'    => 'Delhi', 'to_city' => 'Mussoorie',
                'slug'         => 'delhi-to-mussoorie',
                'distance_km'  => 300, 'duration_hrs' => 5.5,
                'highway'      => 'NH58 via Dehradun',
                'highlight'    => 'Queen of Hills',
                'tag'          => 'Hills',
                'accent_color' => '#9B59B6',
                'price_dzire'  => 2700,  'price_ertiga' => 3300,
                'price_creta'  => 3600,   'price_innova' => 4200,
                'sort_order'   => 10,
            ],
            [
                'from_city'    => 'IGI Airport', 'to_city' => 'Delhi NCR',
                'slug'         => 'airport-transfer',
                'distance_km'  => 0, 'duration_hrs' => 0,
                'highway'      => 'T1 / T2 / T3 · 24/7',
                'highlight'    => 'All Terminals',
                'tag'          => 'Airport',
                'accent_color' => '#083C5D',
                'price_dzire'  => 800,   'price_ertiga' => null,
                'price_creta'  => 1200,   'price_innova' => 1600,
                'sort_order'   => 11,
            ],
        ];

        foreach ($routes as $route) {
            Route::create(array_merge($route, ['is_published' => true]));
        }

        $this->command->info('  ✅ Routes seeded (' . count($routes) . ' routes)');
    }
}
