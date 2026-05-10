<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimelineItem;

class TimelineSeeder extends Seeder
{
    public function run(): void
    {
        TimelineItem::truncate();

        $items = [
            ['2015', '🚗', '#D4A017', 'The Beginning',         'RK Shah started with a single Swift Dzire and a mobile number. First trips were local Delhi pickups and IGI airport transfers. Every trip driven personally.',                       1],
            ['2017', '🗺️', '#083C5D', 'First Outstation Trip', 'The first Delhi to Agra booking came through a referral. The customer recommended RK Shah to 6 friends. Word of mouth had begun.',                                              2],
            ['2018', '🏔️', '#8E44AD', 'Hill Station Routes',   'Added Shimla, Manali, and Rishikesh to the route list. Purchased the first Innova Crysta for long mountain trips. Hired the first verified driver.',                          3],
            ['2020', '💪', '#27AE60', 'Survived the Pandemic',  'When COVID-19 shut down travel, RK Shah maintained contact with every regular customer. When travel resumed, 90% came back. Loyalty built in crisis.',                        4],
            ['2021', '🚙', '#E74C3C', 'Fleet Expansion',        'Added Kia Creta and Ertiga to the fleet. 500+ verified trips completed. First Google review — 5 stars. Team grew to 3 dedicated drivers.',                                   5],
            ['2023', '⭐', '#F39C12', '4.9 Star Rating',         'Crossed 100 Google reviews with a 4.9 star average. Rajasthan packages added — 5-night tours became the most popular offering. 800+ trips completed.',                       6],
            ['2025', '🏆', '#D4A017', 'Where We Stand Today',   '1,200+ trips, 4 premium cars, 4.9 Google rating, covering 40+ destinations across North India. Still the same owner, still the same phone number.',                          7],
        ];

        foreach ($items as [$year, $icon, $color, $title, $desc, $sort]) {
            TimelineItem::create([
                'year'         => $year,
                'icon'         => $icon,
                'color'        => $color,
                'title'        => $title,
                'description'  => $desc,
                'is_published' => true,
                'sort_order'   => $sort,
            ]);
        }

        $this->command->info('  ✅ Timeline seeded (' . count($items) . ' milestones)');
    }
}
