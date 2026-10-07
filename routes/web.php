<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CatalogController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ContentController;
use App\Http\Controllers\Frontend\ServiceRequestController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Root & Webhooks
|--------------------------------------------------------------------------
*/


Route::get('/clear', function (Request $request) {
    if (!app()->environment('local') && $request->input('key') !== env('APP_MAINTENANCE_KEY', 'dubai_admin_secure_key')) {
        abort(403, 'Unauthorized maintenance request.');
    }

    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Session::flush();
    File::cleanDirectory(storage_path('framework/sessions'));

    return "All caches and sessions cleared successfully!";
});

Route::get('/set-ads', function (Request $request) {
    if (!app()->environment('local') && $request->input('key') !== env('APP_MAINTENANCE_KEY', 'dubai_admin_secure_key')) {
        abort(403, 'Unauthorized maintenance request.');
    }

    \App\Models\Setting::updateOrCreate(
        ['group' => 'ads', 'key' => 'adsense_publisher_id'],
        ['value' => 'ca-pub-8539530555121156']
    );
    \App\Models\Setting::updateOrCreate(
        ['group' => 'ads', 'key' => 'ads_txt'],
        ['value' => "google.com, pub-8539530555121156, DIRECT, f08c47fec0942fa0\n"]
    );
    \Illuminate\Support\Facades\Cache::forget('site_settings');
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');

    return "AdSense ID saved to database successfully! Now open: /ads.txt";
});

Route::get('/api/whatsapp/webhook', [WhatsAppWebhookController::class, 'verify']);
Route::post('/api/whatsapp/webhook', [WhatsAppWebhookController::class, 'handle'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);

// Modular XML Sitemaps for Google Search Console & Search Engines
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap-pages.xml', [\App\Http\Controllers\SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-tours.xml', [\App\Http\Controllers\SitemapController::class, 'tours'])->name('sitemap.tours');
Route::get('/sitemap-destinations.xml', [\App\Http\Controllers\SitemapController::class, 'destinations'])->name('sitemap.destinations');
Route::get('/sitemap-blog.xml', [\App\Http\Controllers\SitemapController::class, 'blog'])->name('sitemap.blog');
Route::get('/sitemap-hotels.xml', [\App\Http\Controllers\SitemapController::class, 'hotels'])->name('sitemap.hotels');
Route::get('/sitemap-transports.xml', [\App\Http\Controllers\SitemapController::class, 'transports'])->name('sitemap.transports');
Route::get('/sitemap-images.xml', [\App\Http\Controllers\SitemapController::class, 'images'])->name('sitemap.images');

Route::get('/ads.txt', function () {
    $adsTxtFile = public_path('ads.txt');
    if (file_exists($adsTxtFile)) {
        $fileContent = trim(file_get_contents($adsTxtFile));
        if (!empty($fileContent)) {
            return response($fileContent . "\n", 200, [
                'Content-Type' => 'text/plain; charset=UTF-8',
                'Cache-Control' => 'no-cache, private',
            ]);
        }
    }

    $pubId = config('services.adsense.id') ?: \App\Models\Setting::get('ads.adsense_publisher_id') ?: 'pub-8539530555121156';
    $cleanId = preg_replace('/^ca-/', '', (string) $pubId);
    $customAdsTxt = \App\Models\Setting::get('ads.ads_txt');

    $content = $customAdsTxt ?: "google.com, {$cleanId}, DIRECT, f08c47fec0942fa0\n";

    return response($content, 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Cache-Control' => 'no-cache, private',
    ]);
});

Route::get('/adstxt', fn () => redirect('/ads.txt'));

Route::get('/index.php', function (Request $request) {
    $supported = array_keys(config('localization.supported', ['en' => [], 'ar' => [], 'ru' => []]));
    $locale = $request->session()->get('locale')
        ?? $request->getPreferredLanguage($supported)
        ?? config('localization.default', 'en');

    if (!in_array($locale, $supported)) {
        $locale = config('localization.default', 'en');
    }

    return redirect()->to('/'.$locale, 301);
});


Route::get('/', function (Request $request) {
    $supported = array_keys(config('localization.supported', ['en' => [], 'ar' => [], 'ru' => []]));

    $locale = $request->session()->get('locale')
        ?? $request->getPreferredLanguage($supported)
        ?? config('localization.default', 'en');

    if (!in_array($locale, $supported)) {
        $locale = config('localization.default', 'en');
    }

    return redirect()->to('/'.$locale, 302, [
        'Vary' => 'Accept-Language',
        'Cache-Control' => 'no-cache, private',
    ]);
});

/*
|--------------------------------------------------------------------------
| Localized frontend routes (/en/..., /ar/..., /ru/...)
|--------------------------------------------------------------------------
*/

Route::prefix('{locale}')
    ->whereIn('locale', array_keys(config('localization.supported')))
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // High-Intent Commercial Landing Hubs (SEO Ranking Anchors)
        Route::get('dubai-desert-safari', [\App\Http\Controllers\Frontend\LandingController::class, 'desertSafari'])->name('landings.desert-safari');
        Route::get('dubai-city-tour', [\App\Http\Controllers\Frontend\LandingController::class, 'cityTour'])->name('landings.city-tour');
        Route::get('burj-khalifa-tickets', [\App\Http\Controllers\Frontend\LandingController::class, 'burjKhalifa'])->name('landings.burj-khalifa');
        Route::get('dubai-yacht-tour', [\App\Http\Controllers\Frontend\LandingController::class, 'yachtTour'])->name('landings.yacht-tour');
        Route::get('dubai-airport-transfer', [\App\Http\Controllers\Frontend\LandingController::class, 'airportTransfer'])->name('landings.airport-transfer');
        Route::get('abu-dhabi-city-tour', [\App\Http\Controllers\Frontend\LandingController::class, 'abuDhabiTour'])->name('landings.abu-dhabi-tour');
        Route::get('dubai-private-tours', [\App\Http\Controllers\Frontend\LandingController::class, 'privateTours'])->name('landings.private-tours');

        Route::get('destinations', [CatalogController::class, 'destinations'])->name('destinations.index');
        Route::get('destinations/{destination}', [CatalogController::class, 'destination'])->name('destinations.show');
        Route::get('packages', [CatalogController::class, 'packages'])->name('packages.index');
        Route::get('packages/{tourPackage}', [CatalogController::class, 'package'])->name('packages.show');
        Route::get('hotels', [CatalogController::class, 'hotels'])->name('hotels.index');
        Route::get('hotels/{hotel}', [CatalogController::class, 'hotel'])->name('hotels.show');
        Route::get('transport', [CatalogController::class, 'transports'])->name('transports.index');
        Route::get('transport/{transport}', [CatalogController::class, 'transport'])->name('transports.show');
        Route::redirect('transports', 'transport', 301);
        Route::redirect('transports/{any}', 'transport/{any}', 301)->where('any', '.*');

        Route::get('gallery', [ContentController::class, 'gallery'])->name('gallery.index');
        Route::get('gallery/{album:slug}', [ContentController::class, 'album'])->name('gallery.show');
        Route::get('testimonials', [ContentController::class, 'testimonials'])->name('testimonials.index');
        Route::get('faqs', [ContentController::class, 'faqs'])->name('faqs.index');
        Route::get('blog', [ContentController::class, 'posts'])->name('posts.index');
        Route::get('blog/{post}', [ContentController::class, 'post'])->name('posts.show');
        Route::redirect('journal', 'blog', 301);
        Route::redirect('journal/{any}', 'blog/{any}', 301)->where('any', '.*');
        Route::get('contact', [ContentController::class, 'contact'])->name('contact.create');
        Route::post('contact', [ContentController::class, 'storeContact'])->middleware('throttle:6,1')->name('contact.store');
        Route::post('newsletter', [ContentController::class, 'subscribe'])->middleware('throttle:6,1')->name('newsletter.store');
        Route::post('service-requests', [ServiceRequestController::class, 'store'])->middleware('throttle:10,1')->name('service-requests.store');

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
            Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
            Route::get('dashboard', [BookingController::class, 'index'])->name('dashboard');
            Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
            Route::post('testimonials', [ContentController::class, 'storeTestimonial'])->name('testimonials.store');
            Route::post('blog/{post}/comments', [ContentController::class, 'storeComment'])->name('posts.comments.store');
        });

        require __DIR__.'/auth.php';
    });

require __DIR__.'/admin.php';
