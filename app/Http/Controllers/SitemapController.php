<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Faq;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\TourPackage;
use App\Models\Transport;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $supportedLocales = array_keys(config('localization.supported', ['en' => [], 'ar' => [], 'ru' => []]));
        $urls = [];

        // Static Page Names
        $staticRoutes = ['home', 'destinations.index', 'packages.index', 'hotels.index', 'transports.index', 'posts.index', 'gallery.index', 'testimonials.index', 'faqs.index', 'contact.create'];

        foreach ($staticRoutes as $routeName) {
            foreach ($supportedLocales as $locale) {
                $urls[] = [
                    'loc' => route($routeName, ['locale' => $locale]),
                    'lastmod' => now()->toAtomString(),
                    'changefreq' => 'daily',
                    'priority' => $routeName === 'home' ? '1.0' : '0.8',
                    'alternates' => collect($supportedLocales)->map(fn ($loc) => [
                        'locale' => $loc,
                        'url' => route($routeName, ['locale' => $loc]),
                    ])->all(),
                ];
            }
        }

        // Destinations
        foreach (Destination::active()->get() as $destination) {
            $isDubai = strtolower($destination->name) === 'dubai' || str_contains(strtolower($destination->slug ?? ''), 'dubai');
            foreach ($supportedLocales as $locale) {
                $urls[] = [
                    'loc' => route('destinations.show', ['locale' => $locale, 'destination' => $destination]),
                    'lastmod' => $destination->updated_at->toAtomString(),
                    'changefreq' => $isDubai ? 'daily' : 'weekly',
                    'priority' => $isDubai ? '1.0' : '0.8',
                    'alternates' => collect($supportedLocales)->map(fn ($loc) => [
                        'locale' => $loc,
                        'url' => route('destinations.show', ['locale' => $loc, 'destination' => $destination]),
                    ])->all(),
                ];
            }
        }

        // Tour Packages
        foreach (TourPackage::active()->get() as $package) {
            foreach ($supportedLocales as $locale) {
                $urls[] = [
                    'loc' => route('packages.show', ['locale' => $locale, 'tourPackage' => $package]),
                    'lastmod' => $package->updated_at->toAtomString(),
                    'changefreq' => 'daily',
                    'priority' => '0.9',
                    'alternates' => collect($supportedLocales)->map(fn ($loc) => [
                        'locale' => $loc,
                        'url' => route('packages.show', ['locale' => $loc, 'tourPackage' => $package]),
                    ])->all(),
                ];
            }
        }

        // Hotels
        foreach (Hotel::active()->get() as $hotel) {
            foreach ($supportedLocales as $locale) {
                $urls[] = [
                    'loc' => route('hotels.show', ['locale' => $locale, 'hotel' => $hotel]),
                    'lastmod' => $hotel->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                    'alternates' => collect($supportedLocales)->map(fn ($loc) => [
                        'locale' => $loc,
                        'url' => route('hotels.show', ['locale' => $loc, 'hotel' => $hotel]),
                    ])->all(),
                ];
            }
        }

        // Transports
        foreach (Transport::active()->get() as $transport) {
            foreach ($supportedLocales as $locale) {
                $urls[] = [
                    'loc' => route('transports.show', ['locale' => $locale, 'transport' => $transport]),
                    'lastmod' => $transport->updated_at->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                    'alternates' => collect($supportedLocales)->map(fn ($loc) => [
                        'locale' => $loc,
                        'url' => route('transports.show', ['locale' => $loc, 'transport' => $transport]),
                    ])->all(),
                ];
            }
        }

        // Blog Posts
        foreach (Post::published()->get() as $post) {
            foreach ($supportedLocales as $locale) {
                $urls[] = [
                    'loc' => route('posts.show', ['locale' => $locale, 'post' => $post]),
                    'lastmod' => $post->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                    'alternates' => collect($supportedLocales)->map(fn ($loc) => [
                        'locale' => $loc,
                        'url' => route('posts.show', ['locale' => $loc, 'post' => $post]),
                    ])->all(),
                ];
            }
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml']);
    }
}
