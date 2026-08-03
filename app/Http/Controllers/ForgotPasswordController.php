<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // Step 1: Form Input Email
    public function forgotPassword()
    {
        return view('admin.forgot-password');
    }

    // Step 2: Cek Email di Database
    public function actionForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
        ]);

        // Simpan email sementara di session untuk proses reset
        session(['reset_email' => $request->email]);

        return redirect()->route('reset-password');
    }

    // Step 3: Form Input Password Baru
    public function resetPassword()
    {
        if (! session()->has('reset_email')) {
            return redirect()->route('forgot-password');
        }

        $email = session('reset_email');

        return view('admin.reset-password', compact('email'));
    }

    // Step 4: Simpan Password Baru ke Database
    public function actionResetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password_confirmation.same' => 'Konfirmasi password belum sama.',
        ]);

        $email = session('reset_email');

        if (! $email) {
            return redirect()->route('forgot-password');
        }

        // Update password pengguna
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Hapus session reset email setelah berhasil
        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
