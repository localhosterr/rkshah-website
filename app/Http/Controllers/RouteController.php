<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Fleet;

class RouteController extends Controller
{
    /* ── GET /routes ── */
    public function index(Request $request)
    {
        $filter = $request->get('tag', 'All');

        // All published routes
        $allRoutes = Route::published()->ordered()->get();

        // Unique tags for filter buttons
        $tags = $allRoutes->pluck('tag')->filter()->unique()->sort()->values()->all();

        // Apply tag filter
        $filtered = $filter !== 'All'
            ? $allRoutes->where('tag', $filter)->values()
            : $allRoutes;

        $totalCount = $allRoutes->count();

        return view('routes.index', compact('filtered', 'tags', 'filter', 'totalCount'));
    }

    /* ── GET /routes/{slug} ── */
    public function show(string $slug)
    {
        $route = Route::published()
                      ->where('slug', $slug)
                      ->firstOrFail();

        // Related routes — same tag, excluding current
        $related = Route::published()
                        ->where('slug', '!=', $slug)
                        ->where('tag', $route->tag)
                        ->ordered()
                        ->take(4)
                        ->get();

        // Fleet data for fare comparison
        $fleet = Fleet::active()->ordered()->get();

        return view('routes.show', compact('route', 'related', 'fleet'));
    }
}
