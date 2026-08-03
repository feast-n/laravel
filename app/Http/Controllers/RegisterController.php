<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        return view('admin.register');
    }

    public function actionRegister(Request $request)
    {
        $request->validate(['fname' => 'required', 'lname' => 'required', 'email' => 'required|email|unique:users,email', 'password' => 'required|min:6']);
        User::create(['name' => trim($request->fname.' '.$request->lname), 'email' => $request->email, 'password' => bcrypt($request->password), 'role' => 'user']);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
}
