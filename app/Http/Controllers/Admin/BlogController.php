<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

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
        ]);

        Blog::create([
            'title'       => $request->title,
            'sub_content' => $request->sub_content,
            'content'     => $request->input('content'), // <--- DIGANTI KE input('content')
            'date'        => $request->date,
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
        ]);

        $blog = Blog::findOrFail($id);
        $blog->update([
            'title'       => $request->title,
            'sub_content' => $request->sub_content,
            'content'     => $request->input('content'), // <--- DIGANTI KE input('content')
            'date'        => $request->date,
            'is_active'   => $request->is_active,
        ]);

        return redirect()->route('blog.index')->with('success', 'Data blog berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'Data blog berhasil dihapus!');
    }
}
