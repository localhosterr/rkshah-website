<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $activeCategory = $request->get('category', '');

        $allPosts = BlogPost::published()->latest()->get();

        // Categories for filter chips
        $categories = $allPosts->pluck('category')
                               ->filter()
                               ->unique()
                               ->sort()
                               ->values();

        // Filter by category if selected
        $posts = $activeCategory
            ? $allPosts->where('category', $activeCategory)->values()
            : $allPosts;

        return view('blog.index', compact('posts', 'categories', 'activeCategory'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()
                        ->where('slug', $slug)
                        ->firstOrFail();

        $post->incrementViews();

        $recent = BlogPost::published()
                          ->where('slug', '!=', $slug)
                          ->latest()
                          ->take(4)
                          ->get();

        $related = BlogPost::published()
                           ->where('slug', '!=', $slug)
                           ->where('category', $post->category)
                           ->latest()
                           ->take(2)
                           ->get();

        return view('blog.show', compact('post', 'recent', 'related'));
    }
}
