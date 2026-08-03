<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        // FIX: Tambahkan ->query() setelah Blog::
        $blogs = Blog::query()->latest()->get();
        $title = 'Data Blog';

        return view('admin.blog.index', compact('blogs', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'sub_content' => 'nullable|string|max:255', 'content' => 'required|string', 'date' => 'required|date', 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 'is_active' => 'nullable|boolean']);
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('blogs', 'public') : null;

        Blog::create(['title' => $request->title, 'sub_content' => $request->filled('sub_content') ? $request->sub_content : Str::slug($request->title), 'content' => $request->input('content'), 'date' => $request->date, 'image' => $imagePath, 'is_active' => $request->is_active ?? 1]);

        return redirect()->back()->with('success', 'Data blog berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['title' => 'required|string|max:255', 'sub_content' => 'nullable|string|max:255', 'content' => 'required|string', 'date' => 'required|date', 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 'is_active' => 'required|boolean']);
        $blog = Blog::findOrFail($id);
        $imagePath = $blog->image;

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) { Storage::disk('public')->delete($blog->image); }
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog->update(['title' => $request->title, 'sub_content' => $request->filled('sub_content') ? $request->sub_content : Str::slug($request->title), 'content' => $request->input('content'), 'date' => $request->date, 'image' => $imagePath, 'is_active' => $request->is_active]);

        return redirect()->back()->with('success', 'Data blog berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) { Storage::disk('public')->delete($blog->image); }
        $blog->delete();

        return redirect()->back()->with('success', 'Data blog berhasil dihapus!');
    }
}
