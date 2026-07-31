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
        $blogs = Blog::latest()->get();
        $title = 'Data Blog';

        return view('admin.blog.index', compact('blogs', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'date'    => 'required|date',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'title'       => $request->title,
            'sub_content' => Str::slug($request->title),
            'content'     => $request->input('content'),
            'date'        => $request->date,
            'image'       => $imagePath,
            'is_active'   => $request->is_active ?? 1,
        ]);

        return redirect()->route('blog.index')->with('success', 'Data blog berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'date'    => 'required|date',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $blog = Blog::findOrFail($id);
        $imagePath = $blog->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog->update([
            'title'       => $request->title,
            'sub_content' => Str::slug($request->sub_content),
            'content'     => $request->input('content'),
            'date'        => $request->date,
            'image'       => $imagePath,
            'is_active'   => $request->is_active,
        ]);

        return redirect()->route('blog.index')->with('success', 'Data blog berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'Data blog berhasil dihapus!');
    }
}
