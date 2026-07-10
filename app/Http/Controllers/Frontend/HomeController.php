<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Landing page.
     *
     * The sections are fed from structured collections so the Blade view is
     * already shaped for real data. As each module lands (Destinations,
     * Packages, Testimonials) these arrays are replaced with Eloquent
     * queries without touching the view.
     */
    public function index(): View
    {
        $destinations = collect([
            ['name' => __('dubai_title'),     'tagline' => __('dubai_desc'),     'image' => 'assets/images/dubai.jpg'],
            ['name' => __('abu_dhabi_title'), 'tagline' => __('abu_dhabi_desc'), 'image' => 'assets/images/abu_dhabi.jpg'],
            ['name' => __('sharjah_title'),   'tagline' => __('sharjah_desc'),   'image' => 'assets/images/sharjah.jpg'],
            ['name' => __('rak_title'),       'tagline' => __('rak_desc'),       'image' => 'assets/images/rak.jpg'],
        ]);

        $tours = collect([
            ['name' => __('tour_1_title'), 'price_label' => __('tour_1_price'), 'image' => 'assets/images/tour_burj.jpg'],
            ['name' => __('tour_2_title'), 'price_label' => __('tour_2_price'), 'image' => 'assets/images/tour_mosque.jpg'],
            ['name' => __('tour_3_title'), 'price_label' => __('tour_3_price'), 'image' => 'assets/images/tour_jais.jpg'],
            ['name' => __('tour_4_title'), 'price_label' => __('tour_4_price'), 'image' => 'assets/images/tour_frame.jpg'],
        ]);

        $testimonials = collect([
            ['quote' => __('test_1'), 'author' => __('test_name_1')],
            ['quote' => __('test_2'), 'author' => __('test_name_2')],
        ]);

        return view('frontend.home', compact('destinations', 'tours', 'testimonials'));
    }
}
