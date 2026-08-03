<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        // FIX: Tambahkan ->query() setelah Blog::
        $blogs = Blog::query()->where('is_active', 1)->latest()->get();

        return view('home.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        return view('home.detail', compact('blog'));
    }
}
