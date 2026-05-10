<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Route;
use App\Models\Setting;

class FleetController extends Controller
{
    /* ── GET /fleet ── */
    public function index()
    {
        $cars = Fleet::active()->ordered()->get();

        // Page meta from settings
        $rateFrom = Setting::get('rate_dzire', 9);

        return view('fleet.index', compact('cars', 'rateFrom'));
    }

    /* ── GET /fleet/{slug} ── */
    public function show(string $slug)
    {
        $car = Fleet::where('slug', $slug)
                    ->where('is_active', true)
                    ->firstOrFail();

        // Other cars for "Also consider" section
        $otherCars = Fleet::active()
                          ->where('slug', '!=', $slug)
                          ->ordered()
                          ->get();

        // Popular routes available for this car type
        $priceColumn = 'price_' . $car->fare_key; // fare_key accessor on Fleet model
        $routes = Route::published()
                       ->fromDelhi()
                       ->whereNotNull($priceColumn)
                       ->ordered()
                       ->take(6)
                       ->get();

        return view('fleet.show', compact('car', 'otherCars', 'routes'));
    }
}
