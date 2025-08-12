<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

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
}
