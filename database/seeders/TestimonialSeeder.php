<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::truncate();

        $reviews = [
            [
                'customer_name' => 'Suresh Kumar',
                'initials'      => 'SK',
                'rating'        => 5,
                'review_text'   => 'Booked Innova Crysta for Rajasthan trip. Driver Ramesh bhai was fantastic — knew all the best spots, very professional. Price was exactly as quoted. Highly recommended!',
                'trip_route'    => 'Delhi → Jaipur',
                'car_used'      => 'Innova Crysta',
                'source'        => 'Google Review',
                'sort_order'    => 1,
            ],
            [
                'customer_name' => 'Priya Mehta',
                'initials'      => 'PM',
                'rating'        => 5,
                'review_text'   => 'Airport pickup at 4 AM, driver was already waiting. Car was clean, AC perfect. RK Shah ji is always reachable on phone — that\'s rare these days. Will book again.',
                'trip_route'    => 'IGI Airport Drop',
                'car_used'      => 'Swift Dzire',
                'source'        => 'WhatsApp Review',
                'sort_order'    => 2,
            ],
            [
                'customer_name' => 'Rahul Verma',
                'initials'      => 'RV',
                'rating'        => 5,
                'review_text'   => 'Family trip to Manali — 7 of us, Innova was perfect. Driver was patient with kids, stopped at all viewpoints. No extra charges. Truly stress-free travel.',
                'trip_route'    => 'Delhi → Manali',
                'car_used'      => 'Innova Crysta',
                'source'        => 'Google Review',
                'sort_order'    => 3,
            ],
        ];

        foreach ($reviews as $review) {
            Testimonial::create(array_merge($review, ['is_published' => true]));
        }

        $this->command->info('  ✅ Testimonials seeded (' . count($reviews) . ' reviews)');
    }
}
