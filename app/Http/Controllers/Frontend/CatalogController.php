<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\TourPackage;
use App\Models\Transport;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function destinations()
    {
        return view('frontend.catalog.destinations', [
            'destinations' => Destination::active()->orderBy('sort_order')->paginate(12),
        ]);
    }

    public function destination(Destination $destination)
    {
        abort_unless($destination->status, 404);

        return view('frontend.catalog.destination', [
            'destination' => $destination->load([
                'packages' => fn ($query) => $query->active()->latest()->take(6),
                'hotels' => fn ($query) => $query->active()->latest()->take(6),
            ]),
        ]);
    }

    public function packages(Request $request)
    {
        $packages = TourPackage::query()->active()->with('destination');

        $packages->when($request->integer('destination'), fn ($query, int $id) => $query->where('destination_id', $id));
        $packages->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', $request->input('min_price')));
        $packages->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->input('max_price')));
        $packages->when($request->integer('duration'), fn ($query, int $days) => $query->where('duration_days', $days));

        return view('frontend.catalog.packages', [
            'packages' => $packages->latest()->paginate(12)->withQueryString(),
            'destinations' => Destination::active()->orderBy('sort_order')->get(['id', 'name']),
        ]);
    }

    public function package(TourPackage $tourPackage)
    {
        abort_unless($tourPackage->status, 404);

        return view('frontend.catalog.package', [
            'tourPackage' => $tourPackage->load(['destination', 'itineraries']),
            'relatedPackages' => TourPackage::active()
                ->where('destination_id', $tourPackage->destination_id)
                ->whereKeyNot($tourPackage->getKey())
                ->take(3)
                ->get(),
        ]);
    }

    public function hotels(Request $request)
    {
        $hotels = Hotel::query()->active()->with(['destination', 'amenities']);

        $hotels->when($request->integer('destination'), fn ($query, int $id) => $query->where('destination_id', $id));
        $hotels->when($request->integer('rating'), fn ($query, int $rating) => $query->where('star_rating', '>=', $rating));

        return view('frontend.catalog.hotels', [
            'hotels' => $hotels->orderByDesc('star_rating')->paginate(12)->withQueryString(),
            'destinations' => Destination::active()->orderBy('sort_order')->get(['id', 'name']),
        ]);
    }

    public function hotel(Hotel $hotel)
    {
        abort_unless($hotel->status, 404);

        return view('frontend.catalog.hotel', [
            'hotel' => $hotel->load(['destination', 'amenities', 'rooms' => fn ($query) => $query->where('status', true)]),
        ]);
    }

    public function transports(Request $request)
    {
        $transports = Transport::query()->active();
        $transports->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')));
        $transports->when($request->filled('capacity'), fn ($query) => $query->where('capacity', '>=', $request->integer('capacity')));

        return view('frontend.catalog.transports', [
            'transports' => $transports->orderBy('type')->paginate(12)->withQueryString(),
        ]);
    }

    public function transport(Transport $transport)
    {
        abort_unless($transport->status, 404);

        return view('frontend.catalog.transport', compact('transport'));
    }
}
