<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Services\SeoService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function destinations()
    {
        SeoService::setDestinationsIndex();

        return view('frontend.catalog.destinations', [
            'destinations' => Destination::active()->with('media')->orderBy('sort_order')->paginate(12),
        ]);
    }

    public function destination(Destination $destination)
    {
        abort_unless($destination->status, 404);

        SeoService::setDestination($destination);

        return view('frontend.catalog.destination', [
            'destination' => $destination->load([
                'media',
                'packages' => fn ($query) => $query->active()->with('media')->latest()->take(6),
                'hotels' => fn ($query) => $query->active()->with('media')->latest()->take(6),
            ]),
        ]);
    }

    public function packages(Request $request)
    {
        $searchTerm = $request->input('q', $request->input('search', $request->input('keyword')));

        SeoService::setPackagesIndex($searchTerm);

        $packages = TourPackage::query()
            ->active()
            ->filter($request->all())
            ->with(['destination', 'media'])
            ->orderByDubaiFirst($searchTerm);

        return view('frontend.catalog.packages', [
            'packages' => $packages->paginate(12)->withQueryString(),
            'destinations' => Destination::active()->orderBy('sort_order')->get(['id', 'name', 'slug']),
        ]);
    }

    public function package(TourPackage $tourPackage)
    {
        abort_unless($tourPackage->status, 404);

        SeoService::setTourPackage($tourPackage);

        return view('frontend.catalog.package', [
            'tourPackage' => $tourPackage->load(['destination', 'itineraries', 'media']),
            'relatedPackages' => TourPackage::active()
                ->where('destination_id', $tourPackage->destination_id)
                ->whereKeyNot($tourPackage->getKey())
                ->with('media')
                ->take(3)
                ->get(),
        ]);
    }

    public function hotels(Request $request)
    {
        SeoService::setHotelsIndex();

        $hotels = Hotel::query()
            ->active()
            ->filter($request->all())
            ->with(['destination', 'amenities', 'media']);

        return view('frontend.catalog.hotels', [
            'hotels' => $hotels->orderByDesc('star_rating')->paginate(12)->withQueryString(),
            'destinations' => Destination::active()->orderBy('sort_order')->get(['id', 'name']),
        ]);
    }

    public function hotel(Hotel $hotel)
    {
        abort_unless($hotel->status, 404);

        SeoService::setHotel($hotel);

        return view('frontend.catalog.hotel', [
            'hotel' => $hotel->load([
                'media',
                'destination',
                'amenities',
                'rooms' => fn ($query) => $query->where('status', true)->with('media'),
            ]),
        ]);
    }

    public function transports(Request $request)
    {
        SeoService::setTransportsIndex();

        $transports = Transport::query()->active()->with('media');
        $transports->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')));
        $transports->when($request->filled('capacity'), fn ($query) => $query->where('capacity', '>=', $request->integer('capacity')));

        return view('frontend.catalog.transports', [
            'transports' => $transports->orderBy('type')->paginate(12)->withQueryString(),
        ]);
    }

    public function transport(Transport $transport)
    {
        abort_unless($transport->status, 404);

        SeoService::setTransport($transport);

        $transport->load('media');

        $relatedTransports = Transport::query()
            ->active()
            ->with('media')
            ->where('id', '!=', $transport->id)
            ->take(3)
            ->get();

        return view('frontend.catalog.transport', compact('transport', 'relatedTransports'));
    }
}
