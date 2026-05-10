<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::truncate();

        $faqs = [
            // Booking & Payment
            ['Booking & Payment', '📋', 'How do I book a cab with RK Shah?', 'Call or WhatsApp us at +91 93245 55165, or fill the booking form on our website. We respond within 5 minutes with a confirmed quote.', 1],
            ['Booking & Payment', '📋', 'Is advance payment required?', 'We require a small token advance (Rs 500 to Rs 1,000) to confirm your booking. The remaining balance is paid on the day of your journey directly to the driver via cash or UPI.', 2],
            ['Booking & Payment', '📋', 'What payment methods do you accept?', 'We accept UPI (PhonePe, GPay, Paytm), NEFT/IMPS bank transfer, and cash. We do not currently accept credit cards.', 3],
            ['Booking & Payment', '📋', 'Can I cancel my booking?', 'Yes, you can cancel for free up to 24 hours before the trip. Cancellations within 24 hours may incur a nominal fee of Rs 200 to Rs 500 depending on the trip. Full advance refund for timely cancellations.', 4],

            // Pricing & Charges
            ['Pricing & Charges', '💰', 'Are there any hidden charges?', 'Absolutely not. The price we quote includes driver allowance, fuel, and state taxes. Tolls are included or clearly disclosed upfront. What we quote is what you pay.', 5],
            ['Pricing & Charges', '💰', 'Do you charge extra for night travel?', 'No extra night charges on most routes. For very long trips requiring overnight stays for the driver, a nominal driver accommodation allowance may apply — always disclosed upfront.', 6],
            ['Pricing & Charges', '💰', 'What is the minimum booking distance?', 'For outstation trips, the minimum chargeable distance is 250 km one way. For local city trips, hourly packages start from 4 hours.', 7],
            ['Pricing & Charges', '💰', 'What is driver allowance and why is it charged?', 'Driver allowance is a daily charge covering the driver food and accommodation when they travel outstation. It ranges from Rs 1,500 to Rs 2,200 per day and is always disclosed upfront. This is standard across all outstation cab services.', 8],

            // Cars & Drivers
            ['Cars & Drivers', '🚗', 'Are the drivers verified?', 'Yes. All our drivers are police verified, hold valid commercial driving licenses, and are trained in professional conduct. We do not work with random or unverified drivers.', 9],
            ['Cars & Drivers', '🚗', 'Is AC guaranteed in all vehicles?', 'Yes. All our vehicles are fully air-conditioned and the AC is checked and maintained before every trip.', 10],
            ['Cars & Drivers', '🚗', 'Can I request a specific driver?', 'Yes. If you have had a good experience with one of our drivers, you can request them. We try our best to accommodate such requests subject to availability.', 11],
            ['Cars & Drivers', '🚗', 'How old are the cars in your fleet?', 'All vehicles in our fleet are 2022 model or newer. We do not operate cars older than 3 years to ensure reliability and safety on long outstation trips.', 12],

            // Trips & Routes
            ['Trips & Routes', '🗺️', 'Do you cover all of India or only North India?', 'We specialise in North India outstation trips from Delhi, covering Rajasthan, Himachal Pradesh, Uttarakhand, UP, Punjab, and Haryana. For other destinations, please call us.', 13],
            ['Trips & Routes', '🗺️', 'Can I add stops or change the route mid-trip?', 'Yes. Additional stops can be added during the journey. Extra distance will be charged at the per-km rate agreed at booking. Just inform the driver or call us.', 14],
            ['Trips & Routes', '🗺️', 'What happens if the car breaks down?', 'In the rare event of a breakdown, we immediately arrange a replacement vehicle. RK Shah personally monitors all ongoing trips and responds to any emergency within the hour.', 15],
            ['Trips & Routes', '🗺️', 'Do you provide cabs for airport transfers?', 'Yes. We cover all three terminals of IGI Airport (T1, T2, T3) for both pickup and drop. Available 24 hours, 7 days a week. The driver tracks your flight and adjusts for delays.', 16],
        ];

        foreach ($faqs as $i => [$category, $icon, $question, $answer, $sort]) {
            Faq::create([
                'category'      => $category,
                'category_icon' => $icon,
                'question'      => $question,
                'answer'        => $answer,
                'is_published'  => true,
                'sort_order'    => $sort,
            ]);
        }

        $this->command->info('  ✅ FAQs seeded (' . count($faqs) . ' questions)');
    }
}
