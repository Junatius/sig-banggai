<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Galery;
use App\Models\News;
use App\Models\ObjekWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WisataController extends Controller
{
    public function index(Request $request)
    {
        $attractions = Attraction::orderBy('name')->get();

        $galeries = Galery::with('attraction')
            ->where('status', 'approved')
            ->when($request->attraction_id, fn($query) =>
                $query->where('attractions_id', $request->attraction_id)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('frontend.gallery', compact('attractions', 'galeries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'attractions_id' => 'required|exists:attractions,id',
        ]);

        // Simpan foto
        $path = $request->file('photo_url')->store('galeries', 'public');

        Galery::create([
            'attractions_id' => $request->attractions_id,
            'users_id' => auth()->id(),
            'photo_url' => $path,
        ]);

        return redirect()->route('galleries')->with('success', 'Foto berhasil diunggah dan menunggu persetujuan.');
    }

    public function destroy($id)
{
    $gallery = Galery::findOrFail($id);

    // Check if the logged-in user is the uploader
    if ($gallery->users_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki izin untuk menghapus foto ini.');
    }

    // Delete image file from storage
    if ($gallery->photo_url && Storage::disk('public')->exists($gallery->photo_url)) {
        Storage::disk('public')->delete($gallery->photo_url);
    }

    // Delete database record
    $gallery->delete();

    return redirect()->route('galleries')->with('success', 'Foto berhasil dihapus.');
}

    public function index_dashboard(Request $request)
    {
        $search = $request->get('search');
        $filterAttraction = $request->get('attraction');
        $filterStatus = $request->get('status'); // Tambahan filter status

        $attractions = Attraction::orderBy('name')->get();

        $query = Galery::with(['attraction', 'user']);

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('username', 'ILIKE', "%$search%");
            });
        }

        if ($filterAttraction) {
            $query->where('attractions_id', $filterAttraction);
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
            // Jika filter status dipilih, urut berdasarkan created_at desc saja
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderByRaw("
                CASE status
                    WHEN 'pending' THEN 1
                    WHEN 'approved' THEN 2
                    WHEN 'rejected' THEN 3
                    ELSE 4
                END
            ")->orderBy('created_at', 'desc');
        }

        $galeries = $query->paginate(10);

        return view('admin.gallery.index', compact('galeries', 'search', 'attractions', 'filterAttraction', 'filterStatus'));
    }

    public function approve($id)
    {
        $galery = Galery::findOrFail($id);
        $galery->status = 'approved';
        $galery->save();

        return redirect()->route('dashboard.galleries.index')->with('success', 'Foto berhasil disetujui.');
    }

    public function reject($id)
    {
        $galery = Galery::findOrFail($id);
        $galery->status = 'rejected';
        $galery->save();

        return redirect()->route('dashboard.galleries.index')->with('success', 'Foto berhasil ditolak.');
    }
}
