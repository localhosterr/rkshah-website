<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::truncate();

        $packages = [
            [
                'name'         => 'Royal Rajasthan Tour',
                'slug'         => 'royal-rajasthan',
                'nights'       => 5, 'days' => 6,
                'price'        => 18000,
                'badge'        => 'Best Seller',
                'emoji'        => '🏯',
                'bg_class'     => 'pkg-rajasthan',
                'destinations' => ['Jaipur','Jodhpur','Udaipur','Pushkar'],
                'includes'     => ['AC Cab','Expert Driver','Fuel & Tolls','Flexible Itinerary'],
                'description'  => 'Explore the royal heritage of Rajasthan in 6 days. Visit the Pink City of Jaipur, the Blue City of Jodhpur, the romantic lakes of Udaipur, and the sacred town of Pushkar.',
                'itinerary'    => [
                    ['day'=>1,'title'=>'Delhi → Jaipur',        'desc'=>'Depart from Delhi, arrive Jaipur. Visit Amber Fort, Hawa Mahal, City Palace.'],
                    ['day'=>2,'title'=>'Jaipur → Jodhpur',      'desc'=>'Drive to Jodhpur (340 km). Visit Mehrangarh Fort, Jaswant Thada.'],
                    ['day'=>3,'title'=>'Jodhpur → Udaipur',     'desc'=>'Drive to Udaipur (250 km). Visit Lake Pichola, City Palace, Jagdish Temple.'],
                    ['day'=>4,'title'=>'Udaipur → Pushkar',     'desc'=>'Drive to Pushkar (280 km). Visit Brahma Temple, Pushkar Lake.'],
                    ['day'=>5,'title'=>'Pushkar → Delhi',       'desc'=>'Return to Delhi via Jaipur with a brief shopping stop at Johari Bazaar.'],
                ],
                'sort_order' => 1,
            ],
            [
                'name'         => 'Himachal Hill Escape',
                'slug'         => 'himachal-hill-escape',
                'nights'       => 4, 'days' => 5,
                'price'        => 15000,
                'badge'        => 'Trending',
                'emoji'        => '🏔️',
                'bg_class'     => 'pkg-himachal',
                'destinations' => ['Shimla','Kufri','Manali','Solang Valley'],
                'includes'     => ['AC Cab','Expert Hill Driver','Fuel & Tolls'],
                'description'  => 'Escape to the mountains with this 5-day Himachal tour. Start with colonial Shimla, then drive through the scenic Kullu Valley to Manali. Visit Rohtang Pass and Solang Valley.',
                'itinerary'    => [
                    ['day'=>1,'title'=>'Delhi → Shimla',        'desc'=>'Drive to Shimla (345 km). Evening walk on the Mall Road and Ridge.'],
                    ['day'=>2,'title'=>'Shimla → Manali',       'desc'=>'Visit Kufri, then drive through Kullu Valley to Manali (270 km).'],
                    ['day'=>3,'title'=>'Manali Local',          'desc'=>'Solang Valley, Hadimba Temple, Old Manali, Vashisht hot springs.'],
                    ['day'=>4,'title'=>'Rohtang Pass Day Trip', 'desc'=>'Day trip to Rohtang Pass (subject to permit and weather).'],
                    ['day'=>5,'title'=>'Manali → Delhi',        'desc'=>'Return drive to Delhi. Overnight journey or early morning departure.'],
                ],
                'sort_order' => 2,
            ],
            [
                'name'         => 'Char Dham Yatra',
                'slug'         => 'char-dham-yatra',
                'nights'       => 3, 'days' => 4,
                'price'        => 12000,
                'badge'        => 'Spiritual',
                'emoji'        => '🕉️',
                'bg_class'     => 'pkg-uttarakhand',
                'destinations' => ['Haridwar','Rishikesh','Kedarnath','Badrinath'],
                'includes'     => ['AC Cab','Experienced Driver','Fuel & Tolls'],
                'description'  => 'A sacred pilgrimage through Uttarakhand — the Land of Gods. Visit the Ganga Aarti at Haridwar, experience the spiritual energy of Rishikesh, and seek blessings at Kedarnath and Badrinath.',
                'itinerary'    => [
                    ['day'=>1,'title'=>'Delhi → Haridwar → Rishikesh','desc'=>'Arrive Haridwar, attend Ganga Aarti at Har Ki Pauri. Proceed to Rishikesh.'],
                    ['day'=>2,'title'=>'Rishikesh → Kedarnath',       'desc'=>'Drive to Gaurikund, trek to Kedarnath temple (8 km trek). Evening darshan.'],
                    ['day'=>3,'title'=>'Kedarnath → Badrinath',       'desc'=>'Return from Kedarnath, drive to Badrinath. Evening darshan.'],
                    ['day'=>4,'title'=>'Badrinath → Delhi',           'desc'=>'Morning darshan at Badrinath temple, return drive to Delhi.'],
                ],
                'sort_order' => 3,
            ],
            [
                'name'         => 'Agra Taj Mahal Weekend',
                'slug'         => 'agra-weekend',
                'nights'       => 1, 'days' => 2,
                'price'        => 5500,
                'badge'        => 'Weekend',
                'emoji'        => '🕌',
                'bg_class'     => 'pkg-agra',
                'destinations' => ['Taj Mahal','Agra Fort','Fatehpur Sikri','Mathura'],
                'includes'     => ['AC Cab','Driver','Fuel & Tolls'],
                'description'  => 'The perfect 2-day escape from Delhi. Experience the Taj Mahal at sunrise, explore Agra Fort, and visit the abandoned Mughal city of Fatehpur Sikri.',
                'itinerary'    => [
                    ['day'=>1,'title'=>'Delhi → Agra',              'desc'=>'Early morning departure. Taj Mahal at sunrise. Agra Fort in the afternoon.'],
                    ['day'=>2,'title'=>'Fatehpur Sikri → Delhi',    'desc'=>'Visit Fatehpur Sikri, brief stop at Mathura/Vrindavan, return to Delhi.'],
                ],
                'sort_order' => 4,
            ],
            [
                'name'         => 'Rishikesh Adventure Tour',
                'slug'         => 'rishikesh-adventure',
                'nights'       => 2, 'days' => 3,
                'price'        => 8500,
                'badge'        => 'Adventure',
                'emoji'        => '🌊',
                'bg_class'     => 'pkg-rishikesh',
                'destinations' => ['River Rafting','Bungee Jumping','Camping','Haridwar'],
                'includes'     => ['AC Cab','Activities Coordination','Driver'],
                'description'  => 'For the thrill-seeker. White water rafting on the Ganga, bungee jumping from an 83-metre cliff, riverside camping under the stars.',
                'itinerary'    => [
                    ['day'=>1,'title'=>'Delhi → Rishikesh → Rafting','desc'=>'Arrive Rishikesh. Afternoon river rafting session (16 km stretch).'],
                    ['day'=>2,'title'=>'Bungee + Camping',           'desc'=>'Morning bungee jumping. Afternoon trek. Riverside camping overnight.'],
                    ['day'=>3,'title'=>'Yoga → Haridwar → Delhi',    'desc'=>'Morning yoga session, Ganga Aarti at Haridwar, return to Delhi.'],
                ],
                'sort_order' => 5,
            ],
            [
                'name'         => 'Custom Trip',
                'slug'         => 'custom',
                'nights'       => 0, 'days' => 0,
                'price'        => 0,
                'badge'        => 'Customise',
                'emoji'        => '✨',
                'bg_class'     => 'pkg-custom',
                'destinations' => ['Any Destination','Any Duration','Your Budget'],
                'includes'     => ['Fully Customisable','Any Car','Your Itinerary'],
                'description'  => 'Want something unique? Tell us your destination, duration, and budget — we will build the perfect trip for you.',
                'itinerary'    => [],
                'sort_order' => 6,
            ],
        ];

        foreach ($packages as $package) {
            Package::create(array_merge($package, ['is_published' => true]));
        }

        $this->command->info('  ✅ Packages seeded (' . count($packages) . ' packages)');
    }
}
