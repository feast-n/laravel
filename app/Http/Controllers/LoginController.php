<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function actionLogin(Request $request)
    {
        // Validasi disamakan min:6 agar tidak mental saat password 6-7 karakter
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'role' => $user->role,
            ]);

            // Redirect according to role:
            // Admin gets redirected to admin dashboard
            // Non-admin (User) gets redirected to blog page
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/blog');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!!',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
