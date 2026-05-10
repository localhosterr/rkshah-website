<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        BlogPost::truncate();

        $posts = [
            [
                'title'        => 'Delhi to Agra Road Trip: The Ultimate 2025 Guide',
                'slug'         => 'delhi-to-agra-guide',
                'category'     => 'Route Guide',
                'emoji'        => '🏯',
                'bg_class'     => 'blog-b1',
                'excerpt'      => 'Everything you need — best time to travel, must-stop dhabas, Yamuna Expressway tips, and how to save money on your cab booking.',
                'content'      => $this->agraContent(),
                'seo_title'    => 'Delhi to Agra Road Trip Guide 2025 — Cab, Routes & Tips | RK Shah',
                'seo_description' => 'Complete guide for Delhi to Agra road trip. Best time, Yamuna Expressway tips, places to visit, sample itinerary. Book your cab from Rs 2,200.',
                'status'       => 'published',
                'published_at' => now()->subDays(22),
                'views'        => 642,
            ],
            [
                'title'        => 'Manali in Summer vs Winter: When Should You Go?',
                'slug'         => 'manali-summer-vs-winter',
                'category'     => 'Travel Tips',
                'emoji'        => '🏔️',
                'bg_class'     => 'blog-b2',
                'excerpt'      => 'Summer means adventure and open mountain roads. Winter means snow and romance. We break down what each season offers so you can plan better.',
                'content'      => $this->manaliContent(),
                'seo_title'    => 'Manali Summer vs Winter — Best Time to Visit | RK Shah Car Rental',
                'seo_description' => 'When to visit Manali? Complete comparison of summer, monsoon, autumn, and winter. Road conditions, weather, and cab booking tips from Delhi.',
                'status'       => 'published',
                'published_at' => now()->subDays(39),
                'views'        => 431,
            ],
            [
                'title'        => 'How to Budget Your Outstation Cab Trip from Delhi',
                'slug'         => 'budget-cab-trip',
                'category'     => 'Budget Guide',
                'emoji'        => '💰',
                'bg_class'     => 'blog-b3',
                'excerpt'      => 'A practical breakdown of how outstation cab pricing works, what driver allowance means, and how to avoid getting overcharged.',
                'content'      => $this->budgetContent(),
                'seo_title'    => 'Outstation Cab Pricing from Delhi — Driver Allowance & Fare Formula | RK Shah',
                'seo_description' => 'How outstation cab fares are calculated from Delhi. Rate per km, driver allowance, minimum km, and tips to avoid overcharging.',
                'status'       => 'published',
                'published_at' => now()->subDays(57),
                'views'        => 318,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }

        $this->command->info('  ✅ Blog posts seeded (' . count($posts) . ' posts)');
    }

    private function agraContent(): string
    {
        return '<p>The Delhi to Agra route is one of the most travelled corridors in India, and for good reason — at the end of it sits the Taj Mahal, one of the seven wonders of the world. Here is everything you need to plan a smooth, memorable trip.</p>

<h2>Best time to travel</h2>
<p>Early morning departures (5 to 6 AM) are ideal. You beat the traffic on the Yamuna Expressway and arrive at the Taj Mahal just as it opens, when the white marble glows in the soft morning light. Avoid weekends and public holidays when the expressway gets congested near the Agra entry point.</p>
<p>The best season is October to March when the weather is pleasant. Avoid May and June — the heat in Agra is extreme and the Taj Mahal is less enjoyable in peak summer.</p>

<h2>Route and road conditions</h2>
<p>The NH19 via Yamuna Expressway is a 6-lane toll road in excellent condition — 100 km/h speed limit, well-lit at night, service areas every 50 km. Total distance from South Delhi is about 230 to 250 km depending on your starting point. Typical drive time is 3 to 3.5 hours.</p>
<p>The toll from Delhi to Agra is approximately Rs 450 to Rs 550 for a car, which is typically included in your cab fare if booked through a reliable operator.</p>

<h2>Must-stop places on the way</h2>
<p>Mathura (160 km from Delhi) is a worthy breakfast stop. The city of Lord Krishna has excellent pure-veg dhabas near the highway. Brijwasi Mithai on the main road is famous for its peda and kachori. On the return trip, a stop at Vrindavan — just 15 km from Mathura — adds a spiritual dimension to the journey.</p>

<h2>Places to visit in Agra</h2>
<p>Most people only visit the Taj Mahal, but Agra has much more to offer. Agra Fort, a UNESCO World Heritage Site, is just 2 km from the Taj and can be covered in 2 hours. Mehtab Bagh across the river offers a stunning Taj view without the crowd. On the way back, Fatehpur Sikri — the abandoned Mughal capital 40 km from Agra — is a fascinating half-day stop.</p>

<h2>Cab booking tips</h2>
<p>Book a cab with an outstation specialist rather than Ola or Uber. App-based cabs charge surge pricing and do not include waiting time charges — you will end up paying much more. A dedicated outstation cab from RK Shah includes the driver for the full day, no waiting charges, and a fixed all-inclusive fare discussed upfront.</p>

<h2>Sample itinerary for one day</h2>
<p><strong>5:30 AM</strong> — Depart Delhi<br>
<strong>8:30 AM</strong> — Arrive Agra, Taj Mahal entry (opens 6 AM, best light at 8 to 9 AM)<br>
<strong>11:00 AM</strong> — Agra Fort<br>
<strong>1:00 PM</strong> — Lunch at Dasaprakash or Pinch of Spice<br>
<strong>3:00 PM</strong> — Mehtab Bagh viewpoint<br>
<strong>4:30 PM</strong> — Depart for Delhi<br>
<strong>8:00 PM</strong> — Arrive Delhi (traffic permitting)</p>';
    }

    private function manaliContent(): string
    {
        return '<p>Manali is one of the most popular hill station destinations from Delhi, and it draws visitors year-round. But your experience changes dramatically depending on when you visit. Here is a complete comparison to help you decide.</p>

<h2>Summer (May to September)</h2>
<p>This is peak season. Roads to Rohtang Pass (3,978 m) and Spiti Valley open up after the snow clears — usually by late May. You can do river rafting on the Beas, adventure sports at Solang Valley, and trek to Beas Kund. Weather is 10 to 25 degrees C — pleasant during the day, cool at night.</p>
<p>The downside: Manali is very crowded in June and July. Accommodation prices are at their highest and you need to book well in advance. Rohtang Pass also gets congested and requires a permit (Rs 500 per car, booked online the day before).</p>

<h2>Monsoon (July to August)</h2>
<p>Avoid if possible. Landslides are frequent on mountain roads, Rohtang Pass often closes for days, and the views are hidden behind clouds. If you must travel, stick to lower Manali (Old Manali, Hadimba Temple) and avoid the high altitude passes.</p>

<h2>Autumn (September to October)</h2>
<p>The sweet spot that most people miss. Crowds thin out after September, weather is still pleasant (5 to 20 degrees C), and the mountains are clear after the monsoon. Rohtang is usually open in September. Apple orchards in the Kullu Valley are in full harvest — a beautiful sight.</p>

<h2>Winter (November to February)</h2>
<p>Manali in winter is magical for those who can handle the cold. The town itself is accessible (unlike Rohtang and Spiti which close). Solang Valley becomes a skiing destination. Temperature drops to -5 to 5 degrees C — carry heavy woolens, thermals, and waterproof boots. New Year brings crowds; February is the quietest and most atmospheric time.</p>

<h2>Road condition tips from Delhi</h2>
<p>The Delhi to Manali drive (530 km) takes 10 to 12 hours with stops. The Chandigarh to Manali stretch (300 km) on NH3 through Kullu Valley is the scenic but slow section. Road quality is generally good up to Bhuntar; beyond that it narrows and winds through the mountains. An Innova Crysta or similar sturdy car is recommended for this trip — avoid small sedans for Manali.</p>';
    }

    private function budgetContent(): string
    {
        return '<p>Planning an outstation trip from Delhi? Understanding how cab pricing works will help you budget accurately and avoid unpleasant surprises. Here is a complete breakdown.</p>

<h2>How outstation cab fare is calculated</h2>
<p>Outstation cab fare = (Distance in km x Rate per km) + Driver allowance. That is the basic formula. Let us break each component down.</p>

<p><strong>Rate per km</strong> varies by car type. In 2025, typical Delhi outstation rates are:</p>
<ul>
<li>Swift Dzire: Rs 9 to Rs 10 per km</li>
<li>Ertiga: Rs 11 to Rs 12 per km</li>
<li>Kia Creta: Rs 12 to Rs 13 per km</li>
<li>Innova Crysta: Rs 14 to Rs 16 per km</li>
</ul>

<p><strong>Driver allowance (DA)</strong> is a daily charge for the driver food and accommodation when travelling outstation. It typically ranges from Rs 1,500 to Rs 2,200 per day depending on the car. This is completely legitimate and not a hidden charge — it covers the driver expenses since they are away from home. Always confirm this upfront.</p>

<h2>Minimum km rule</h2>
<p>Most outstation operators charge a minimum of 250 to 300 km per trip, even if the actual distance is less. So a Delhi to Mathura trip (180 km one way) would be billed as 300 km one way. Always ask about the minimum km policy before booking.</p>

<h2>Round trip vs one way</h2>
<p>For round trips, the km are charged both ways and the driver DA doubles (since the driver stays overnight). So a Delhi to Agra round trip in a Dzire at Rs 9 per km would be: (240 km x 2) x Rs 9 = Rs 4,320 + Rs 1,500 DA x 2 = Rs 7,320 total. One way is just: 240 x Rs 9 + Rs 1,500 = Rs 3,660.</p>

<h2>What should be included in the quoted price</h2>
<p>A transparent outstation cab quote should include fuel, driver allowance, and state taxes. Tolls may or may not be included — always ask specifically. Night halting charges (when the driver stays outside) should be disclosed. Parking charges at tourist spots are usually extra and paid directly.</p>

<h2>Red flags to watch for</h2>
<p>Be cautious if a cab operator gives you a very low per-km rate but does not mention driver allowance separately — they often add it at the end as a surprise charge. Also watch for operators who charge for the return journey even on a one-way trip.</p>

<h2>How to get the best deal</h2>
<p>Book directly with an outstation specialist rather than aggregator apps. Discuss all charges upfront on a phone call. Get the total fare including DA and tolls confirmed before departing. Pay a small advance via UPI to confirm, and keep the balance for the end of the journey. A good operator will have nothing to hide.</p>';
    }
}
