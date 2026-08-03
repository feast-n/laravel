<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap input per_page (default: 50) dan search
        $perPage = $request->input('per_page', 50);
        $search = $request->input('search');

        // Query dengan pencarian nama pelajaran dan paginasi
        $mataPelajaran = MataPelajaran::when($search, function ($query) use ($search) {
            return $query->where('nama_pelajaran', 'like', '%' . $search . '%');
        })->paginate($perPage)->appends($request->all());

        return view('admin.mapel.index', compact('mataPelajaran'));
    }

    public function create()
    {
        return redirect()->route('mapel.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
        ]);

        MataPelajaran::create([
            'nama_pelajaran' => $request->nama_pelajaran,
        ]);

        return redirect()->route('mapel.index')
                         ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        return redirect()->route('mapel.index');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return redirect()->route('mapel.index');
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255',
        ]);

        $mataPelajaran->update([
            'nama_pelajaran' => $request->nama_pelajaran,
        ]);

        return redirect()->route('mapel.index')
                         ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return redirect()->route('mapel.index')
                         ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
