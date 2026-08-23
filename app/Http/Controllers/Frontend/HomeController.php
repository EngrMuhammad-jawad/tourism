<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\TourPackage;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $dbDestinations = Destination::active()->orderBy('sort_order')->take(4)->get();
        $destinations = $dbDestinations->isNotEmpty()
            ? $dbDestinations->map(fn ($d) => [
                'name' => $d->name,
                'tagline' => $d->description ? \Illuminate\Support\Str::limit(strip_tags((string) $d->description), 80) : 'Experience luxury travel',
                'image' => $d->getFirstMediaUrl('featured') ?: 'assets/images/'.($d->slug === 'dubai' ? 'dubai.jpg' : ($d->slug === 'abu-dhabi' ? 'abu_dhabi.jpg' : ($d->slug === 'sharjah' ? 'sharjah.jpg' : 'rak.jpg'))),
                'url' => route('destinations.show', $d),
            ])
            : collect([
                ['name' => __('dubai_title'),     'tagline' => __('dubai_desc'),     'image' => 'assets/images/dubai.jpg',     'url' => route('destinations.index')],
                ['name' => __('abu_dhabi_title'), 'tagline' => __('abu_dhabi_desc'), 'image' => 'assets/images/abu_dhabi.jpg', 'url' => route('destinations.index')],
                ['name' => __('sharjah_title'),   'tagline' => __('sharjah_desc'),   'image' => 'assets/images/sharjah.jpg',   'url' => route('destinations.index')],
                ['name' => __('rak_title'),       'tagline' => __('rak_desc'),       'image' => 'assets/images/rak.jpg',       'url' => route('destinations.index')],
            ]);

        $dbTours = TourPackage::active()->with('destination')->latest()->take(4)->get();
        $tours = $dbTours->isNotEmpty()
            ? $dbTours->map(fn ($t) => [
                'name' => $t->name,
                'price_label' => '$'.number_format((float) $t->effectivePrice(), 2).' / person',
                'image' => $t->getFirstMediaUrl('featured') ?: 'assets/images/tour_burj.jpg',
                'url' => route('packages.show', $t),
            ])
            : collect([
                ['name' => __('tour_1_title'), 'price_label' => __('tour_1_price'), 'image' => 'assets/images/tour_burj.jpg',   'url' => route('packages.index')],
                ['name' => __('tour_2_title'), 'price_label' => __('tour_2_price'), 'image' => 'assets/images/tour_mosque.jpg', 'url' => route('packages.index')],
                ['name' => __('tour_3_title'), 'price_label' => __('tour_3_price'), 'image' => 'assets/images/tour_jais.jpg',   'url' => route('packages.index')],
                ['name' => __('tour_4_title'), 'price_label' => __('tour_4_price'), 'image' => 'assets/images/tour_frame.jpg',  'url' => route('packages.index')],
            ]);

        $dbTestimonials = Testimonial::approved()->latest()->take(3)->get();
        $testimonials = $dbTestimonials->isNotEmpty()
            ? $dbTestimonials->map(fn ($t) => [
                'quote' => $t->content,
                'author' => $t->name.($t->country ? ' ('.$t->country.')' : ''),
            ])
            : collect([
                ['quote' => __('test_1'), 'author' => __('test_name_1')],
                ['quote' => __('test_2'), 'author' => __('test_name_2')],
            ]);

        return view('frontend.home', compact('destinations', 'tours', 'testimonials'));
    }
}
