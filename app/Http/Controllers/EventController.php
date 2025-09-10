<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $attractionFilter = $request->input('attraction');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $today = now()->toDateString();

        $events = Event::with(['user.attraction'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'ILIKE', "%$search%");
            })
            ->when($attractionFilter, function ($query) use ($attractionFilter) {
                $query->whereHas('user.attraction', function ($q) use ($attractionFilter) {
                    $q->where('id', $attractionFilter);
                });
            })
            // Filter tanggal sesuai kebutuhan
            ->when($startDate && !$endDate, function ($query) use ($startDate) {
                $query->whereDate('start_date', '>=', $startDate);
            })
            ->when(!$startDate && $endDate, function ($query) use ($endDate) {
                $query->whereDate('end_date', '<=', $endDate);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereDate('start_date', '>=', $startDate)
                    ->whereDate('end_date', '<=', $endDate);
            })
            // Urutkan sesuai prioritas
            ->orderByRaw("
                CASE
                    WHEN start_date <= ? AND end_date >= ? THEN 1
                    WHEN start_date > ? THEN 2
                    ELSE 3
                END
            ", [$today, $today, $today])
            ->orderByRaw("
                CASE
                    WHEN start_date <= ? AND end_date >= ? THEN start_date
                    WHEN start_date > ? THEN start_date
                    ELSE end_date
                END ASC
            ", [$today, $today, $today])
            ->paginate(15);

        $attractions = Attraction::orderBy('name')->get();

        return view('events.index', compact('events', 'attractions'));
    }

    public function show_user(Event $event)
    {
        $event->load(['user.attraction']);
        return view('events.show', compact('event'));
    }

    /**
     * Menampilkan daftar event.
     */
    public function index_dashboard(Request $request)
    {
        $user = Auth::user();

        $query = Event::with(['user', 'user.attraction']);

        // Filtering berdasarkan role
        if ($user->role === 'pengelola') {
            $query->where(function ($q) use ($user) {
                $q->where('users_id', $user->id)
                  ->orWhereHas('user', function ($q2) use ($user) {
                      $q2->where('attractions_id', $user->attractions_id);
                  });
            });
        }

        // Filter search nama event
        if ($request->filled('search')) {
            $query->where('name', 'ILIKE', "%$request->search%");
        }

        // Filter tempat wisata (hanya untuk admin)
        if ($user->role === 'dinas_pariwisata' && $request->filled('attractions_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('attractions_id', $request->attractions_id);
            });
        }

        // Filter tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $events = $query->latest()->paginate(10);
        $attractions = Attraction::all();

        return view('admin.kegiatan.index', compact('events', 'attractions'));
    }

    /**
     * Form tambah event.
     */
    public function create()
    {
        $user = Auth::user();
        return view('admin.kegiatan.create', compact('user'));
    }

    /**
     * Simpan event baru.
     */
    public function store(Request $request)
    {
    $request->validate([
        'name'        => 'required|string|max:255',
        'photo_url'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'start_date'  => 'required|date|after_or_equal:today',
        'end_date'    => 'required|date|after_or_equal:start_date',
        'desc'        => 'required|string',
        'link'        => 'nullable|url',
        'manager'     => 'required|string',
        'contact'     => 'required|string',
    ], [
        // Pesan error custom (Bahasa Indonesia)
        'name.required'        => 'Nama event wajib diisi.',
        'name.max'             => 'Nama event tidak boleh lebih dari 255 karakter.',
        'photo_url.image'      => 'File foto harus berupa gambar.',
        'photo_url.mimes'      => 'Foto hanya boleh berformat jpeg, png, atau jpg.',
        'photo_url.max'        => 'Ukuran foto maksimal 2 MB.',
        'start_date.required'  => 'Tanggal mulai wajib diisi.',
        'start_date.date'      => 'Tanggal mulai harus berupa tanggal yang valid.',
        'start_date.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
        'end_date.required'    => 'Tanggal selesai wajib diisi.',
        'end_date.date'        => 'Tanggal selesai harus berupa tanggal yang valid.',
        'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        'desc.required'        => 'Deskripsi wajib diisi.',
        'link.url'             => 'Link pendaftaran harus berupa URL yang valid.',
        'manager.required'     => 'Penanggung jawab wajib diisi.',
        'contact.required'     => 'Kontak wajib diisi.',
    ]);


        $photoPath = null;
        if ($request->hasFile('photo_url')) {
            $photoPath = $request->file('photo_url')->store('events', 'public');
        }

        Event::create([
            'users_id'   => Auth::id(),
            'name'       => $request->name,
            'photo_url'  => $photoPath,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'desc'       => $request->desc,
            'link'       => $request->link,
            'manager'    => $request->manager,
            'contact'    => $request->contact,
        ]);

        return redirect()->route('dashboard.events.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Detail event.
     */
    public function show(Event $event)
    {
        return view('admin.kegiatan.show', compact('event'));
    }

    /**
     * Form edit event.
     */
    public function edit(Event $event)
    {
        $user = Auth::user();

        // Cek akses edit
        if ($user->role !== 'dinas_pariwisata' && $event->users_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit event ini.');
        }

        return view('admin.kegiatan.edit', compact('event', 'user'));
    }

    /**
     * Update event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'photo_url'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'desc'        => 'required|string',
            'link'        => 'nullable|url',
            'manager'     => 'required|string',
            'contact'     => 'required|string',
        ]);

        if ($request->hasFile('photo_url')) {
            if ($event->photo_url) {
                Storage::disk('public')->delete($event->photo_url);
            }
            $event->photo_url = $request->file('photo_url')->store('events', 'public');
        }

        $event->update([
            'name'       => $request->name,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'desc'       => $request->desc,
            'link'       => $request->link,
            'manager'    => $request->manager,
            'contact'    => $request->contact,
        ]);

        return redirect()->route('dashboard.events.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus event.
     */
    public function destroy(Event $event)
    {
        $user = Auth::user();

        // Hanya admin dan pemilik event yang boleh hapus
        if ($user->role !== 'dinas_pariwisata' && $event->users_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus event ini.');
        }

        if ($event->photo_url) {
            Storage::disk('public')->delete($event->photo_url);
        }

        $event->delete();

        return redirect()->route('dashboard.events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
