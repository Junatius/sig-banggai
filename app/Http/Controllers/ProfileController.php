<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Attraction;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $attraction = null;

        if ($user->role === 'pengelola_pariwisata' && $user->attractions_id) {
            $attraction = Attraction::find($user->attractions_id);
        }

        return view('profile.show', compact('user', 'attraction'));
    }

    public function edit()
    {
        $user = Auth::user();
        $attraction = null;

        if ($user->role === 'pengelola_pariwisata' && $user->attractions_id) {
            $attraction = Attraction::find($user->attractions_id);
        }

        return view('profile.edit', compact('user', 'attraction'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $rules = [
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
        ];

        if ($user->role === 'pengelola_pariwisata') {
            $rules['contact'] = 'required|string|max:255';
        }

        $data = $request->validate($rules);

        $user->username = $data['username'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($user->role === 'pengelola_pariwisata' && $user->attractions_id) {
            $attraction = Attraction::find($user->attractions_id);
            $attraction->contact = $data['contact'];
            $attraction->save();
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
