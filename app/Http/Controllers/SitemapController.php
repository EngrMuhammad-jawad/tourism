<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Setting;
use App\Models\TourPackage;
use App\Models\Transport;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Get the production canonical base URL (https://dubaitourbook.com).
     */
    protected function getBaseUrl(): string
    {
        $siteUrl = Setting::get('general.site_url');
        if (!empty($siteUrl) && !str_contains($siteUrl, 'localhost') && !str_contains($siteUrl, '127.0.0.1')) {
            return rtrim($siteUrl, '/');
        }

        $appUrl = config('app.url', 'https://dubaitourbook.com');
        if (str_contains($appUrl, 'localhost') || str_contains($appUrl, '127.0.0.1')) {
            return 'https://dubaitourbook.com';
        }

        return rtrim($appUrl, '/');
    }

    /**
     * Generate canonical absolute URL.
     */
    protected function makeUrl(string $path = ''): string
    {
        $base = $this->getBaseUrl();
        $path = ltrim($path, '/');

        return $path ? "{$base}/{$path}" : $base;
    }

    /**
     * Build clean Google Search Central-compliant multilingual alternates (en, ar, ru, x-default).
     */
    protected function buildAlternates(string $pathWithoutLocale = ''): array
    {
        $cleanPath = ltrim($pathWithoutLocale, '/');
        $suffix = $cleanPath ? "/{$cleanPath}" : '';

        return [
            ['locale' => 'en',        'url' => $this->makeUrl("en{$suffix}")],
            ['locale' => 'ar',        'url' => $this->makeUrl("ar{$suffix}")],
            ['locale' => 'ru',        'url' => $this->makeUrl("ru{$suffix}")],
            ['locale' => 'x-default', 'url' => $this->makeUrl("en{$suffix}")],
        ];
    }

    /**
     * Master XML Sitemap Index (/sitemap.xml).
     */
    public function index(): Response
    {
        $now = now()->toAtomString();
        $latestTour = TourPackage::active()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? $now;
        $latestPost = Post::published()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? $now;
        $latestDest = Destination::active()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? $now;
        $latestHotel = Hotel::active()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? $now;
        $latestTransport = Transport::active()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? $now;

        $sitemaps = [
            ['loc' => $this->makeUrl('sitemap-pages.xml'),        'lastmod' => $now],
            ['loc' => $this->makeUrl('sitemap-tours.xml'),        'lastmod' => $latestTour],
            ['loc' => $this->makeUrl('sitemap-destinations.xml'), 'lastmod' => $latestDest],
            ['loc' => $this->makeUrl('sitemap-blog.xml'),         'lastmod' => $latestPost],
            ['loc' => $this->makeUrl('sitemap-hotels.xml'),       'lastmod' => $latestHotel],
            ['loc' => $this->makeUrl('sitemap-transports.xml'),   'lastmod' => $latestTransport],
            ['loc' => $this->makeUrl('sitemap-images.xml'),       'lastmod' => $now],
        ];

        $xml = view('sitemaps.index', compact('sitemaps'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Pages & High-Intent Landing Pages XML Sitemap (/sitemap-pages.xml).
     */
    public function pages(): Response
    {
        $locales = ['en', 'ar', 'ru'];
        $urls = [];

        $staticPages = [
            ''                        => ['priority' => '1.0', 'changefreq' => 'daily'],
            'destinations'            => ['priority' => '0.9', 'changefreq' => 'daily'],
            'packages'                => ['priority' => '0.9', 'changefreq' => 'daily'],
            'hotels'                  => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'transport'               => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'blog'                    => ['priority' => '0.8', 'changefreq' => 'daily'],
            'gallery'                 => ['priority' => '0.6', 'changefreq' => 'weekly'],
            'testimonials'            => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'faqs'                    => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'contact'                 => ['priority' => '0.7', 'changefreq' => 'monthly'],
            // High-Intent Commercial Landing Hubs
            'dubai-desert-safari'     => ['priority' => '1.0', 'changefreq' => 'daily'],
            'dubai-city-tour'         => ['priority' => '1.0', 'changefreq' => 'daily'],
            'burj-khalifa-tickets'    => ['priority' => '1.0', 'changefreq' => 'daily'],
            'dubai-yacht-tour'        => ['priority' => '0.9', 'changefreq' => 'daily'],
            'dubai-airport-transfer'  => ['priority' => '0.9', 'changefreq' => 'weekly'],
            'abu-dhabi-city-tour'     => ['priority' => '0.9', 'changefreq' => 'daily'],
            'dubai-private-tours'     => ['priority' => '0.9', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $path => $meta) {
            foreach ($locales as $locale) {
                $subPath = $path ? "{$locale}/{$path}" : $locale;
                $urls[] = [
                    'loc'        => $this->makeUrl($subPath),
                    'lastmod'    => now()->toAtomString(),
                    'changefreq' => $meta['changefreq'],
                    'priority'   => $meta['priority'],
                    'alternates' => $this->buildAlternates($path),
                    'image'      => [
                        'loc'          => $this->makeUrl('assets/images/hero.jpg'),
                        'title'        => 'Dubai Tour Book - Luxury Tours & Desert Safaris',
                        'caption'      => 'Experience luxury Dubai tours and VIP desert safaris with Dubai Tour Book',
                        'geo_location' => 'Dubai, United Arab Emirates',
                    ],
                ];
            }
        }

        $xml = view('sitemaps.urlset', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Tour Packages XML Sitemap (/sitemap-tours.xml).
     */
    public function tours(): Response
    {
        $locales = ['en', 'ar', 'ru'];
        $urls = [];

        $packages = TourPackage::active()->with(['destination', 'media'])->get();

        foreach ($packages as $package) {
            $isDubai = ($package->destination?->slug === 'dubai')
                || str_contains(strtolower($package->slug), 'dubai')
                || str_contains(strtolower($package->name), 'dubai');

            $featuredImage = $package->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/tour_burj.jpg');
            $packageName = is_array($package->getRawOriginal('name'))
                ? ($package->getRawOriginal('name')['en'] ?? $package->slug)
                : (string) $package->name;

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc'        => $this->makeUrl("{$locale}/packages/{$package->slug}"),
                    'lastmod'    => $package->updated_at->toAtomString(),
                    'changefreq' => 'daily',
                    'priority'   => $isDubai ? '1.0' : '0.9',
                    'alternates' => $this->buildAlternates("packages/{$package->slug}"),
                    'image'      => [
                        'loc'          => $featuredImage,
                        'title'        => "{$packageName} - Dubai Luxury Tour",
                        'caption'      => "Book {$packageName} in Dubai with VIP hotel transfers and expert guide.",
                        'geo_location' => 'Dubai, United Arab Emirates',
                    ],
                ];
            }
        }

        $xml = view('sitemaps.urlset', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Destinations XML Sitemap (/sitemap-destinations.xml).
     */
    public function destinations(): Response
    {
        $locales = ['en', 'ar', 'ru'];
        $urls = [];

        $destinations = Destination::active()->with('media')->get();

        foreach ($destinations as $destination) {
            $isDubai = strtolower($destination->name) === 'dubai' || str_contains(strtolower($destination->slug ?? ''), 'dubai');
            $featuredImage = $destination->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/dubai.jpg');
            $destName = is_array($destination->getRawOriginal('name'))
                ? ($destination->getRawOriginal('name')['en'] ?? $destination->slug)
                : (string) $destination->name;

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc'        => $this->makeUrl("{$locale}/destinations/{$destination->slug}"),
                    'lastmod'    => $destination->updated_at->toAtomString(),
                    'changefreq' => $isDubai ? 'daily' : 'weekly',
                    'priority'   => $isDubai ? '1.0' : '0.8',
                    'alternates' => $this->buildAlternates("destinations/{$destination->slug}"),
                    'image'      => [
                        'loc'          => $featuredImage,
                        'title'        => "{$destName} Luxury UAE Travel & Sightseeing",
                        'caption'      => "Discover luxury tours, iconic attractions, and hotels in {$destName}, UAE.",
                        'geo_location' => "{$destName}, United Arab Emirates",
                    ],
                ];
            }
        }

        $xml = view('sitemaps.urlset', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Blog Posts XML Sitemap (/sitemap-blog.xml).
     */
    public function blog(): Response
    {
        $locales = ['en', 'ar', 'ru'];
        $urls = [];

        $posts = Post::published()->with(['media', 'author'])->get();

        foreach ($posts as $post) {
            $featuredImage = $post->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/tour_burj.jpg');
            $title = is_array($post->getRawOriginal('title'))
                ? ($post->getRawOriginal('title')['en'] ?? $post->slug)
                : (string) $post->title;

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc'        => $this->makeUrl("{$locale}/blog/{$post->slug}"),
                    'lastmod'    => $post->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.8',
                    'alternates' => $this->buildAlternates("blog/{$post->slug}"),
                    'image'      => [
                        'loc'          => $featuredImage,
                        'title'        => "{$title} - Dubai Travel Journal",
                        'caption'      => "Read expert Dubai travel advice and insights: {$title}",
                        'geo_location' => 'Dubai, United Arab Emirates',
                    ],
                ];
            }
        }

        $xml = view('sitemaps.urlset', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Hotels XML Sitemap (/sitemap-hotels.xml).
     */
    public function hotels(): Response
    {
        $locales = ['en', 'ar', 'ru'];
        $urls = [];

        $hotels = Hotel::active()->with(['destination', 'media'])->get();

        foreach ($hotels as $hotel) {
            $featuredImage = $hotel->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/hero.jpg');
            $hotelName = is_array($hotel->getRawOriginal('name'))
                ? ($hotel->getRawOriginal('name')['en'] ?? $hotel->slug)
                : (string) $hotel->name;

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc'        => $this->makeUrl("{$locale}/hotels/{$hotel->slug}"),
                    'lastmod'    => $hotel->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.8',
                    'alternates' => $this->buildAlternates("hotels/{$hotel->slug}"),
                    'image'      => [
                        'loc'          => $featuredImage,
                        'title'        => "{$hotelName} - 5-Star Luxury Stay Dubai",
                        'caption'      => "Experience world-class hospitality at {$hotelName} in Dubai.",
                        'geo_location' => 'Dubai, United Arab Emirates',
                    ],
                ];
            }
        }

        $xml = view('sitemaps.urlset', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Transports XML Sitemap (/sitemap-transports.xml).
     */
    public function transports(): Response
    {
        $locales = ['en', 'ar', 'ru'];
        $urls = [];

        $transports = Transport::active()->with('media')->get();

        foreach ($transports as $transport) {
            $featuredImage = $transport->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/hero.jpg');
            $transportName = is_array($transport->getRawOriginal('name'))
                ? ($transport->getRawOriginal('name')['en'] ?? $transport->slug)
                : (string) $transport->name;

            foreach ($locales as $locale) {
                $urls[] = [
                    'loc'        => $this->makeUrl("{$locale}/transport/{$transport->slug}"),
                    'lastmod'    => $transport->updated_at->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority'   => '0.7',
                    'alternates' => $this->buildAlternates("transport/{$transport->slug}"),
                    'image'      => [
                        'loc'          => $featuredImage,
                        'title'        => "{$transportName} - Luxury Chauffeur Dubai",
                        'caption'      => "VIP Airport Transfers and Chauffeur Services in Dubai: {$transportName}",
                        'geo_location' => 'Dubai, United Arab Emirates',
                    ],
                ];
            }
        }

        $xml = view('sitemaps.urlset', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }

    /**
     * Dedicated Google Images XML Sitemap (/sitemap-images.xml).
     */
    public function images(): Response
    {
        $urls = [];

        // Homepage & Core Images
        $urls[] = [
            'loc'    => $this->makeUrl('en'),
            'images' => [
                [
                    'loc'          => $this->makeUrl('assets/images/hero.jpg'),
                    'title'        => 'Dubai Skyline Burj Khalifa Sunset & Luxury Tourism',
                    'caption'      => 'Dubai skyline with Burj Khalifa and luxury travel experience in the UAE.',
                    'geo_location' => 'Downtown Dubai, United Arab Emirates',
                ],
                [
                    'loc'          => $this->makeUrl('assets/images/dubai.jpg'),
                    'title'        => 'Dubai City Center & Sheikh Zayed Road Highlights',
                    'caption'      => 'Iconic architecture and futuristic towers in Dubai.',
                    'geo_location' => 'Dubai, United Arab Emirates',
                ],
                [
                    'loc'          => $this->makeUrl('assets/images/tour_desert_safari.jpg'),
                    'title'        => 'Dubai Desert Safari Red Dunes Dune Bashing & Quad Biking',
                    'caption'      => 'Thrilling red dunes safari in Lahbab desert Dubai at golden sunset.',
                    'geo_location' => 'Lahbab Desert, Dubai, United Arab Emirates',
                ],
                [
                    'loc'          => $this->makeUrl('assets/images/tour_burj.jpg'),
                    'title'        => 'Burj Khalifa Observation Deck At The Top Views',
                    'caption'      => 'Panoramic observation deck view from Burj Khalifa over Downtown Dubai.',
                    'geo_location' => 'Downtown Dubai, United Arab Emirates',
                ],
            ],
        ];

        // Tour Images
        foreach (TourPackage::active()->with('media')->get() as $p) {
            $img = $p->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/tour_burj.jpg');
            $pName = is_array($p->getRawOriginal('name')) ? ($p->getRawOriginal('name')['en'] ?? $p->slug) : (string) $p->name;
            $urls[] = [
                'loc'    => $this->makeUrl("en/packages/{$p->slug}"),
                'images' => [
                    [
                        'loc'          => $img,
                        'title'        => "{$pName} - Dubai Tour Book",
                        'caption'      => "Official booking photography for {$pName} in Dubai, UAE.",
                        'geo_location' => 'Dubai, United Arab Emirates',
                    ],
                ],
            ];
        }

        // Destination Images
        foreach (Destination::active()->with('media')->get() as $d) {
            $img = $d->getFirstMediaUrl('featured') ?: $this->makeUrl('assets/images/dubai.jpg');
            $dName = is_array($d->getRawOriginal('name')) ? ($d->getRawOriginal('name')['en'] ?? $d->slug) : (string) $d->name;
            $urls[] = [
                'loc'    => $this->makeUrl("en/destinations/{$d->slug}"),
                'images' => [
                    [
                        'loc'          => $img,
                        'title'        => "{$dName} UAE Sightseeing & Holiday Destination",
                        'caption'      => "Explore attractions and luxury tours in {$dName}, UAE.",
                        'geo_location' => "{$dName}, United Arab Emirates",
                    ],
                ],
            ];
        }

        $xml = view('sitemaps.images', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'text/xml; charset=UTF-8']);
    }
}
