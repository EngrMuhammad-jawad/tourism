<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\TourPackage;
use App\Models\Transport;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    /**
     * Dedicated High-Intent Landing Page: Dubai Desert Safari.
     */
    public function desertSafari(): View
    {
        $packages = TourPackage::active()
            ->where(function ($query) {
                $query->where('slug', 'like', '%safari%')
                    ->orWhere('slug', 'like', '%dune%')
                    ->orWhere('slug', 'like', '%dress%');
            })
            ->with(['destination', 'media'])
            ->get();

        if ($packages->isEmpty()) {
            $packages = TourPackage::active()->with(['destination', 'media'])->take(3)->get();
        }

        $transports = Transport::active()
            ->where(function ($q) {
                $q->where('slug', 'like', '%safari%')
                  ->orWhere('slug', 'like', '%buggy%')
                  ->orWhere('slug', 'like', '%cruiser%');
            })
            ->with('media')
            ->take(2)
            ->get();

        $relatedPosts = Post::published()
            ->where(function ($q) {
                $q->where('slug', 'like', '%safari%')
                  ->orWhere('slug', 'like', '%dress%')
                  ->orWhere('slug', 'like', '%best%');
            })
            ->take(2)
            ->get();

        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.desert-safari', compact('packages', 'transports', 'relatedPosts', 'testimonials'));
    }

    /**
     * Dedicated High-Intent Landing Page: Dubai City Tour.
     */
    public function cityTour(): View
    {
        $packages = TourPackage::active()
            ->where(function ($query) {
                $query->where('slug', 'like', '%city%')
                    ->orWhere('slug', 'like', '%frame%')
                    ->orWhere('slug', 'like', '%khalifa%');
            })
            ->with(['destination', 'media'])
            ->get();

        if ($packages->isEmpty()) {
            $packages = TourPackage::active()->with(['destination', 'media'])->take(3)->get();
        }

        $relatedPosts = Post::published()->take(2)->get();
        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.city-tour', compact('packages', 'relatedPosts', 'testimonials'));
    }

    /**
     * Dedicated High-Intent Landing Page: Burj Khalifa Tickets.
     */
    public function burjKhalifa(): View
    {
        $package = TourPackage::active()->where('slug', 'like', '%burj-khalifa%')->first()
            ?? TourPackage::active()->first();

        $relatedPackages = TourPackage::active()
            ->whereKeyNot($package?->id)
            ->with(['destination', 'media'])
            ->take(3)
            ->get();

        $guidePost = Post::published()->where('slug', 'like', '%burj-khalifa%')->first();
        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.burj-khalifa', compact('package', 'relatedPackages', 'guidePost', 'testimonials'));
    }

    /**
     * Dedicated High-Intent Landing Page: Dubai Yacht Tour & Marina Cruises.
     */
    public function yachtTour(): View
    {
        $dubaiDest = Destination::active()->where('slug', 'dubai')->first();
        $relatedPackages = TourPackage::active()->with(['destination', 'media'])->take(3)->get();
        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.yacht-tour', compact('dubaiDest', 'relatedPackages', 'testimonials'));
    }

    /**
     * Dedicated High-Intent Landing Page: Dubai Airport Transfers & VIP Chauffeur.
     */
    public function airportTransfer(): View
    {
        $transports = Transport::active()->with('media')->get();
        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.airport-transfer', compact('transports', 'testimonials'));
    }

    /**
     * Dedicated High-Intent Landing Page: Abu Dhabi City Tour from Dubai.
     */
    public function abuDhabiTour(): View
    {
        $packages = TourPackage::active()
            ->where(function ($query) {
                $query->where('slug', 'like', '%abu-dhabi%')
                    ->orWhere('slug', 'like', '%mosque%');
            })
            ->with(['destination', 'media'])
            ->get();

        $guidePost = Post::published()->where('slug', 'like', '%mosque%')->first();
        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.abu-dhabi-tour', compact('packages', 'guidePost', 'testimonials'));
    }

    /**
     * Dedicated High-Intent Landing Page: Dubai Private Tours & Bespoke Luxury Itineraries.
     */
    public function privateTours(): View
    {
        $packages = TourPackage::active()->with(['destination', 'media'])->take(4)->get();
        $transports = Transport::active()->with('media')->take(2)->get();
        $testimonials = Testimonial::approved()->take(2)->get();

        return view('frontend.landings.private-tours', compact('packages', 'transports', 'testimonials'));
    }
}
