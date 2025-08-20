<?php

namespace App\Http\Controllers;

use App\Models\Tourist;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TouristController extends Controller
{
    public function index(Request $request)
    {
        $query = Tourist::query();

        // Search pakai ILIKE (PostgreSQL)
        if ($request->filled('search')) {
            $query->where('name', 'ILIKE', '%' . $request->search . '%');
        }
        if ($request->filled('nationality')) {
            $query->where('nationality', $request->nationality);
        }
        if ($request->filled('visit_purpose')) {
            $query->where('visit_purpose', $request->visit_purpose);
        }

        $tourists = $query->orderBy('created_at', 'desc')->paginate(10);

        // Chart 1: total per negara
        $chartByCountry = Tourist::select('nationality', DB::raw('COUNT(*) as total'))
            ->groupBy('nationality')
            ->get();

        // Chart 2: total per tujuan
        $chartByPurpose = Tourist::select('visit_purpose', DB::raw('COUNT(*) as total'))
            ->groupBy('visit_purpose')
            ->get();

        $countries = Tourist::select('nationality')->distinct()->pluck('nationality');
        $purposes = Tourist::select('visit_purpose')->distinct()->pluck('visit_purpose');

        return view('admin.wisatawan.index', compact(
            'tourists', 'chartByCountry', 'chartByPurpose', 'countries', 'purposes'
        ))->with('search', $request->search);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'nationality' => 'required|string',
            'visit_purpose' => 'required|string',
        ]);

        Tourist::create($request->only(['name', 'nationality', 'visit_purpose']));

        return redirect()->route('dashboard.tourists.index')->with('success', 'Wisatawan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'nationality' => 'required|string',
            'visit_purpose' => 'required|string',
        ]);

        $tourist = Tourist::findOrFail($id);
        $tourist->update($request->only(['name', 'nationality', 'visit_purpose']));

        return redirect()->route('dashboard.tourists.index')->with('success', 'Wisatawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tourist = Tourist::findOrFail($id);
        $tourist->delete();

        return redirect()->route('dashboard.tourists.index')->with('success', 'Wisatawan berhasil dihapus.');
    }
}
