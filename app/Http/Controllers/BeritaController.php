<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Berita;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['user', 'user.attraction'])->latest();

        // Filter: search by title
        if ($request->filled('search')) {
            $query->where('title', 'ILIKE', '%' . $request->search . '%');
        }

        // Filter: by uploader (dinas pariwisata / attractions)
        if ($request->filled('uploader')) {
            if ($request->uploader === 'Dinas Pariwisata') {
                $query->whereHas('user', function ($q) {
                    $q->where('role', 'dinas_pariwisata');
                });
            } else {
                // uploader value = attraction name
                $query->whereHas('user.attraction', function ($q) use ($request) {
                    $q->where('name', $request->uploader);
                });
            }
        }

        $news = $query->paginate(15);

        // for dropdown filter
        $attractions = Attraction::select('id', 'name')->get();

        return view('frontend.berita', compact('news', 'attractions'));
    }

    public function index_dashboard(Request $request)
    {
        $query = News::with(['user.attraction']);

        // Jika role pengelola -> hanya berita miliknya
        if (Auth::user()->role === 'pengelola') {
            $query->where('users_id', Auth::id());
        }

        // Search title
        if ($request->filled('search')) {
            $query->where('title', 'ILIKE', '%' . $request->search . '%');
        }

        // Filter role pembuat (hanya untuk admin)
        if (Auth::user()->role === 'dinas_pariwisata' && $request->filled('filter_role')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->filter_role);
            });
        }

        // Filter attraction (opsional, hanya untuk admin jika filter role = pengelola)
        if (Auth::user()->role === 'dinas_pariwisata' && $request->filled('filter_attraction')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('attractions_id', $request->filter_attraction);
            });
        }

        // Filter tanggal dari
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // Filter tanggal sampai
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(10);

        $attractions = Attraction::orderBy('name')->get();

        return view('admin.berita.index', compact('news', 'attractions'));;
    }

    public function show($id)
    {
        $news = News::with(['user', 'attraction'])->findOrFail($id);

        // Akses pengelola hanya bisa lihat miliknya
        if (Auth::user()->role === 'pengelola' && $news->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dashboard.news.show', compact('news'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:50',
            'desc'      => 'required|string',
            'photo_url' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['title', 'desc']);
        $data['users_id'] = Auth::id();
        $data['status'] = 'pending';

        if ($request->hasFile('photo_url')) {
            $data['photo_url'] = $request->file('photo_url')->store('uploads/news', 'public');
        }

        News::create($data);

        return redirect()->route('dashboard.news.index')->with('success', 'Berita berhasil dibuat dan menunggu persetujuan.');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);

        // Hanya pembuat atau admin yang bisa edit
        if (Auth::id() !== $news->users_id) {
            abort(403);
        }

        return view('admin.berita.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        // Hanya pembuat atau admin yang bisa update
        if (Auth::id() !== $news->users_id) {
            abort(403);
        }

        $request->validate([
            'title'     => 'required|string|max:50',
            'desc'      => 'required|string',
            'photo_url' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $news->title = $request->title;
        $news->desc = $request->desc;
        $news->status = 'pending'; // reset status ke pending saat diupdate

        if ($request->hasFile('photo_url')) {
            $news->photo_url = $request->file('photo_url')->store('uploads/news', 'public');
        }

        $news->save();

        return redirect()->route('dashboard.news.index')->with('success', 'Berita berhasil diupdate dan menunggu persetujuan.');
    }

}
