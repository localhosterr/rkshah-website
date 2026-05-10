<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    /* ── GET /packages ── */
    public function index()
    {
        $packages = Package::published()->ordered()->get();

        return view('packages.index', compact('packages'));
    }

    /* ── GET /packages/{slug} ── */
    public function show(string $slug)
    {
        // Custom trip is a special static page
        if ($slug === 'custom') {
            return view('packages.custom');
        }

        $package = Package::published()
                          ->where('slug', $slug)
                          ->firstOrFail();

        // Other packages for "Also consider" section
        $related = Package::published()
                          ->where('slug', '!=', $slug)
                          ->where('slug', '!=', 'custom')
                          ->ordered()
                          ->take(3)
                          ->get();

        return view('packages.show', compact('package', 'related'));
    }
}
