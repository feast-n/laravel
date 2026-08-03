<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }
        $perPage = $request->input('per_page', 50);
        $students = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.student', ['title' => 'Student Management', 'students' => $students]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email', 'phone' => 'required', 'address' => 'required']);
        Student::create(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'address' => $request->address]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email', 'phone' => 'required', 'address' => 'required']);
        $student = Student::findOrFail($id);
        $student->update(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'address' => $request->address]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function hapus(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
