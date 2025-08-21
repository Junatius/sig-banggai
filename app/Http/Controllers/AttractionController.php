<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    public function index(Request $request)
    {
        // Get filters from request
        $search    = $request->input('search');
        $kecamatan = $request->input('kecamatan'); // ini nanti id dari subdistrict
        $category  = $request->input('category');
        $facility  = $request->input('facility');

        // Ambil semua kecamatan & kategori unik
        $kecamatans = Subdistrict::orderBy('name')->pluck('name', 'id');
        $categories = Attraction::select('type')->distinct()->orderBy('type')->pluck('type');

        // Build query
        $query = Attraction::with('subdistrict'); // eager load relasi

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%$search%")
                  ->orWhereHas('subdistrict', function($subQ) use ($search) {
                      $subQ->where('name', 'ILIKE', "%$search%");
                  })
                  ->orWhere('type', 'ILIKE', "%$search%");
            });
        }

        if ($kecamatan) {
            $query->where('subdistrict_id', $kecamatan);
        }

        if ($category) {
            $query->where('type', $category);
        }

        if ($facility !== null && $facility !== '') {
            $query->where('has_facility', (bool)$facility);
        }

        // Paginate: 15 per page
        $attractions = $query->paginate(15);
        $attractions->appends($request->all());

        return view('attractions.index', compact('attractions', 'kecamatans', 'categories'));
    }

    /**
     * Menampilkan semua tempat wisata
     */
    public function index_dashboard(Request $request)
    {
        // Ambil semua subdistrict untuk filter dropdown
        $subdistricts = Subdistrict::all();

        // Ambil jenis wisata distinct untuk filter
        $types = Attraction::select('type')->distinct()->pluck('type');

        // Query dasar
        $query = Attraction::with('subdistrict');

        // Filter search nama
        if ($request->filled('search')) {
            $query->where('name', 'ILIKE', '%' . $request->search . '%');
        }

        // Filter kecamatan
        if ($request->filled('filter_subdistrict')) {
            $query->where('subdistrict_id', $request->filter_subdistrict);
        }

        // Filter fasilitas
        if ($request->filled('filter_facility')) {
            $query->where('has_facility', $request->filter_facility === '1');
        }

        // Filter harga tiket masuk minimal
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter harga tiket masuk maksimal
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter jenis wisata
        if ($request->filled('filter_type')) {
            $query->where('type', $request->filter_type);
        }

        $attractions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.objek-wisata.index', compact('attractions', 'subdistricts', 'types'));
    }

    /**
     * Tampilkan detail tempat wisata
     */
    public function show($id)
    {
        $attraction = Attraction::with('subdistrict')->findOrFail($id);
        return view('admin.objek-wisata.show', compact('attraction'));
    }

    /**
     * Form tambah tempat wisata
     */
    public function create()
    {
        $subdistricts = Subdistrict::all();
        return view('admin.objek-wisata.create', compact('subdistricts'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subdistrict_id' => 'required|uuid',
            'name' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'desc' => 'required|string',
            'has_facility' => 'boolean',
            'type' => 'required|string',
            'legality' => 'required|string',
            'price' => 'nullable|numeric',
        ]);

        if ($request->hasFile('photo_profile')) {
            $validated['photo_profile'] = $request->file('photo_profile')->store('uploads/attractions', 'public');
        }

        Attraction::create($validated);

        return redirect()->route('dashboard.attractions.index')->with('success', 'Tempat wisata berhasil ditambahkan!');
    }

    /**
     * Form edit tempat wisata
     */
    public function edit($id)
    {
        $attraction = Attraction::findOrFail($id);
        $subdistricts = Subdistrict::all();
        return view('admin.objek-wisata.edit', compact('attraction', 'subdistricts'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $attraction = Attraction::findOrFail($id);

        $validated = $request->validate([
            'subdistrict_id' => 'required|uuid',
            'name' => 'required|string|max:50',
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'desc' => 'required|string',
            'has_facility' => 'boolean',
            'type' => 'required|string',
            'legality' => 'required|string',
            'price' => 'nullable|numeric',
        ]);

        if ($request->hasFile('photo_profile')) {
            // Hapus file lama jika ada
            if ($attraction->photo_profile && file_exists(storage_path('app/public/' . $attraction->photo_profile))) {
                unlink(storage_path('app/public/' . $attraction->photo_profile));
            }
            $validated['photo_profile'] = $request->file('photo_profile')->store('uploads/attractions', 'public');
        }

        $attraction->update($validated);

        return redirect()->route('dashboard.attractions.index')->with('success', 'Tempat wisata berhasil diperbarui!');
    }

    /**
     * Hapus tempat wisata
     */
    public function destroy($id)
    {
        $attraction = Attraction::findOrFail($id);

        if ($attraction->photo_profile && file_exists(storage_path('app/public/' . $attraction->photo_profile))) {
            unlink(storage_path('app/public/' . $attraction->photo_profile));
        }

        $attraction->delete();

        return redirect()->route('dashboard.attractions.index')->with('success', 'Tempat wisata berhasil dihapus!');
    }

    public function show_pengelola()
    {
        $user = Auth::user();

        // Pastikan user punya relasi ke tempat wisata
        if (!$user->attractions_id) {
            abort(403, 'Anda tidak memiliki tempat wisata untuk dikelola.');
        }

        $attraction = Attraction::with('subdistrict')
            ->findOrFail($user->attractions_id);

        return view('admin.pariwisata.index', compact('attraction'));
    }

    public function edit_pengelola()
    {
        $user = Auth::user();

        if (!$user->attractions_id) {
            abort(403, 'Anda tidak memiliki tempat wisata untuk dikelola.');
        }

        $attraction = Attraction::findOrFail($user->attractions_id);

        return view('admin.pariwisata.edit', compact('attraction'));
    }

    public function update_pengelola(Request $request)
    {
        $user = Auth::user();

        if (!$user->attractions_id) {
            abort(403, 'Anda tidak memiliki tempat wisata untuk dikelola.');
        }

        $attraction = Attraction::findOrFail($user->attractions_id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'legality' => 'nullable|string|max:255',
            'price' => 'nullable|string|max:50',
            'has_facility' => 'boolean',
            'photo_profile' => 'nullable|image|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('photo_profile')) {
            if ($attraction->photo_profile) {
                Storage::disk('public')->delete($attraction->photo_profile);
            }
            $validated['photo_profile'] = $request->file('photo_profile')->store('attractions', 'public');
        }

        $attraction->update($validated);

        return redirect()->route('dashboard.attractions.show_pengelola')
            ->with('success', 'Informasi tempat wisata berhasil diperbarui.');
    }
}
