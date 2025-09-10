<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Tampilan login
    public function index()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // Proses login untuk admin dan user
    public function login_proses(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'dinas_pariwisata') {
                return redirect()->route('dashboard.users.index');
            } else if ($user->role === 'pengelola') {
                return redirect()->route('dashboard.attractions.show.pengelola');
            } else {
                return redirect()->route('home');
            }
        }

        return redirect()->back()->with('failed', 'Email atau Password salah.');
    }

    // Logout untuk admin dan user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Kamu berhasil logout.');
    }

    // Tampilan form registrasi
    public function register()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // Proses registrasi user
    public function register_proses(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        try {
            // Create the user
            $user = User::create([
                'username' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Automatically login after register (optional)
            Auth::login($user);

            // Redirect to home with success message
            return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
        } catch (\Exception $e) {
            // Log error or handle if needed
            Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }
}
