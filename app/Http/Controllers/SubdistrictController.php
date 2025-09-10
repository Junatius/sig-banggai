<?php

namespace App\Http\Controllers;

use App\Models\Subdistrict;
use Illuminate\Http\Request;

class SubdistrictController extends Controller
{
    public function homepage()
    {
        $subdistricts = Subdistrict::all(); // or paginate if needed
        return view('frontend.index', compact('subdistricts'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $subdistricts = Subdistrict::when($search, function ($query, $search) {
                $query->where('name', 'ILIKE', "%$search%");
            })
            ->orderBy('name')
            ->paginate(20);

        return view('admin.kecamatan.index', compact('subdistricts', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:subdistricts,name',
        ]);

        Subdistrict::create([
            'name' => $request->nama,
        ]);

        return redirect()->route('dashboard.subdistricts.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function update(Request $request, Subdistrict $subdistrict)
    {
        $request->validate([
            'nama' => 'required|string|max:50|unique:subdistricts,name,' . $subdistrict->id,
        ]);

        $subdistrict->update([
            'name' => $request->nama,
        ]);

        return redirect()->route('dashboard.subdistricts.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Subdistrict $subdistrict)
    {
        $subdistrict->delete();

        return redirect()->route('dashboard.subdistricts.index')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
