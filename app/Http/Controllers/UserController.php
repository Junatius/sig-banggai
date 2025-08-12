<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('username', 'ILIKE', "%$search%")
                    ->orWhere('email', 'ILIKE', "%$search%");
            })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('username')
            ->paginate(30)
            ->appends(['search' => $search, 'role' => $role]); // supaya query tetap saat paginasi

        $currentUserId = Auth::id();
        return view('admin.akun.index', compact('users', 'currentUserId', 'search', 'role'));
    }

    public function create()
    {
        $attractions = Attraction::orderBy('name')->get();
        return view('admin.akun.create', compact('attractions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role'          => 'required|in:dinas_pariwisata,pengelola',
            'name'          => 'required|string|max:255',
            'attraction_id' => 'required_if:role,pengelola|nullable|exists:attractions,id',
            'email'         => 'required|email|unique:users,email'
        ]);

        // Password random 16 karakter
        $password = Str::random(16);

        // Buat user baru
        $user = User::create([
            'username'      => $request->name, // langsung ambil dari input
            'email'         => $request->email,
            'password'      => Hash::make($password),
            'role'          => $request->role,
            'attraction_id' => $request->role === 'pengelola' ? $request->attraction_id : null
        ]);

        // Simpan password ke session agar bisa ditampilkan di halaman sukses
        session()->flash('generated_password', $password);

        return redirect()->route('dashboard.users.created.success', $user->id);
    }

    public function createdSuccess($id)
    {
        $user = User::findOrFail($id);
        $password = session('generated_password');

        if (!$password) {
            return redirect()->route('dashboard.users.index');
        }

        return view('admin.akun.success', compact('user', 'password'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }
}
