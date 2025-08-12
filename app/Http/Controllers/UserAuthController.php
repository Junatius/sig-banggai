<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.login'); // form login user
    }

    public function loginProses(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::guard('user')->attempt($credentials)) {
            return redirect()->route('user.dashboard');
        }

        return back()->with('failed', 'Login user gagal!');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('login.user');
    }
}