<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Route;
use App\Models\Setting;
use App\Models\PageSection;
use App\Models\Faq;
use App\Models\TimelineItem;

class PageController extends Controller
{
    public function about()
    {
        // Real stats from DB
        $trips      = Lead::whereIn('status',['confirmed','completed'])->count();
        $totalTrips = max(1200, $trips + 1200);
        $dests      = Route::published()->count();
        $rating     = Setting::get('google_rating', 4.9);
        $years      = (int) Setting::get('years_in_business', 8);

        $stats = [
            ['value' => number_format($totalTrips).'+', 'label' => 'Trips Completed'],
            ['value' => $rating.'★',                    'label' => 'Google Rating'],
            ['value' => $years.'+',                     'label' => 'Years Active'],
            ['value' => $dests.'+',                     'label' => 'Destinations'],
        ];

        // All content from DB
        $hero     = PageSection::section('about', 'hero');
        $story    = PageSection::section('about', 'story');
        $owner    = PageSection::section('about', 'owner');
        $metrics  = PageSection::section('about', 'metrics');
        $cta      = PageSection::section('about', 'cta');

        // Timeline from DB
        $timeline = TimelineItem::published()->ordered()->get();

        // Values (from page sections or fallback array)
        $values = [
            ['icon'=>'🛡️','title'=>'Safety First',         'desc'=>'Every driver is police verified. Every car is regularly serviced. GPS tracking on all vehicles.'],
            ['icon'=>'💰','title'=>'Honest Pricing',        'desc'=>'No hidden charges. No surprise tolls. No surge pricing. What we quote — you pay.'],
            ['icon'=>'⏰','title'=>'Always On Time',         'desc'=>'On-time pickup is our promise. We arrive early so you never miss a flight or connection.'],
            ['icon'=>'❤️','title'=>'Customer First',        'desc'=>'Your satisfaction is our business. We go out of our way to solve problems, not create them.'],
            ['icon'=>'🚗','title'=>'Premium Fleet',         'desc'=>'All vehicles AC, GPS-tracked, and sanitized before every trip. Less than 3 years old.'],
            ['icon'=>'📞','title'=>'Direct Accountability', 'desc'=>'Every booking goes through the owner. No middlemen. No call centres. Direct responsibility.'],
        ];

         $ownerPhoto = Setting::get('owner_photo', '');
        return view('pages.about', compact(
            'stats','hero','story','owner','metrics','cta','timeline','values','ownerPhoto'
        ));
    }

    public function faq()
    {
        // Categories from DB
        $categories = Faq::grouped();

        return view('pages.faq', compact('categories'));
    }

    public function contact()
    {
        $phone   = Setting::get('business_phone',   '+91 93245 55165');
        $email   = Setting::get('business_email',   'rkshahcarrental@gmail.com');
        $address = Setting::get('business_address', 'Soniya Vihar, Delhi – 110094');
        $hours   = Setting::get('business_hours',   '6 AM – 11 PM · All Days');

        return view('pages.contact', compact('phone','email','address','hours'));
    }

    public function thankYou()
    {
        return view('pages.thank-you');
    }
}
