<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Event;
use Illuminate\Http\Request;

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

        return view('frontend.events', compact('events', 'attractions'));
    }
}
