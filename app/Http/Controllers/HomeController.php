<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Route;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\PageSection;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $fleet        = Fleet::active()->ordered()->get();
        $routes       = Route::published()->fromDelhi()->ordered()->take(6)->get();
        $packages     = Package::published()->ordered()->get();
        $testimonials = Testimonial::published()->ordered()->get();
        $stats        = $this->getStats();

        // All page content from DB
        $hero       = PageSection::section('homepage', 'hero');
        $ticker     = PageSection::section('homepage', 'ticker');
        $whyUs      = PageSection::section('homepage', 'why_us');
        $howItWorks = PageSection::section('homepage', 'how_it_works');
        $cta        = PageSection::section('homepage', 'cta');
        $trustBar   = PageSection::section('homepage', 'trust_bar');

        return view('home.index', compact(
            'fleet','routes','packages','testimonials','stats',
            'hero','ticker','whyUs','howItWorks','cta','trustBar'
        ));
    }

    public function calculateFare(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:100',
            'car_type'    => 'required|string|in:dzire,ertiga,creta,innova',
            'trip_type'   => 'required|string|in:one_way,round_trip',
        ]);

        $dest  = strtolower(trim($request->destination));
        $round = $request->trip_type === 'round_trip';

        // Rates — single cached query
        $s = Cache::remember('fare_settings', 3600, function () {
            return \DB::table('settings')
                ->whereIn('key', [
                    'rate_dzire','rate_ertiga','rate_creta','rate_innova',
                    'da_dzire','da_ertiga','da_creta','da_innova',
                    'fare_range_percent',
                ])
                ->pluck('value', 'key')
                ->toArray();
        });

        $rates = [
            'dzire'  => (int)($s['rate_dzire']  ?? 9),
            'ertiga' => (int)($s['rate_ertiga'] ?? 11),
            'creta'  => (int)($s['rate_creta']  ?? 12),
            'innova' => (int)($s['rate_innova'] ?? 14),
        ];
        $da = [
            'dzire'  => (int)($s['da_dzire']  ?? 1500),
            'ertiga' => (int)($s['da_ertiga'] ?? 1800),
            'creta'  => (int)($s['da_creta']  ?? 2000),
            'innova' => (int)($s['da_innova'] ?? 2200),
        ];

        $km = 0; $fixedPrice = null;

        $route = Cache::remember("route_fare_{$dest}", 3600, function () use ($dest) {
            return Route::published()
                ->where('from_city', 'Delhi')
                ->whereRaw('LOWER(to_city) = ?', [$dest])
                ->select(['distance_km','price_dzire','price_ertiga','price_creta','price_innova'])
                ->first();
        });

        if ($route && $route->distance_km > 0) {
            $km         = $route->distance_km;
            $fixedPrice = $route->{'price_' . $request->car_type};
        } else {
            $fallback = [
                'agra'=>240,'mathura'=>180,'vrindavan'=>185,'jaipur'=>270,
                'jodhpur'=>600,'udaipur'=>660,'manali'=>530,'shimla'=>345,
                'chandigarh'=>250,'rishikesh'=>250,'haridwar'=>220,
                'mussoorie'=>300,'dehradun'=>290,'nainital'=>300,'amritsar'=>450,
            ];
            $km = $fallback[$dest] ?? 0;
        }

        if ($km === 0 && !$fixedPrice) {
            return response()->json(['found' => false]);
        }

        $multiplier   = $round ? 2 : 1;
        $driverDa     = $da[$request->car_type] * $multiplier;
        $total        = $fixedPrice
            ? ($fixedPrice * $multiplier) + $driverDa
            : ($km * $rates[$request->car_type] * $multiplier) + $driverDa;

        $rangePercent = (int)($s['fare_range_percent'] ?? 10);
        $margin       = $total * ($rangePercent / 100);

        return response()->json([
            'found'     => true,
            'km'        => $km,
            'total'     => round($total),
            'min'       => round($total - $margin),
            'max'       => round($total + $margin),
            'trip_type' => $request->trip_type,
        ]);
    }

    private function getStats(): array
    {
        $trips        = Cache::remember('stat_trips', 300, fn() => Lead::whereIn('status',['confirmed','completed'])->count());
        $totalTrips   = max(1200, $trips + 1200);
        $destinations = Cache::remember('stat_dest', 3600, fn() => Route::published()->count());
        $rating       = Setting::get('google_rating', 4.9);
        $years        = (int) Setting::get('years_in_business', 8);

        return [
            ['value' => number_format($totalTrips).'+', 'label' => 'Happy Trips'],
            ['value' => $rating.'★',                    'label' => 'Google Rating'],
            ['value' => $years.'+',                     'label' => 'Years Trusted'],
            ['value' => $destinations.'+',              'label' => 'Destinations'],
        ];
    }
}
