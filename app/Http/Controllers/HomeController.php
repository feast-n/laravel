<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource for home page.
     */
    public function index()
    {
        // Fetch active blogs sorted by latest
        $blogs = Blog::where('is_active', 1)->latest()->get();

        return view('home.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        return view('home.detail', compatct('blog'));

    }
}
