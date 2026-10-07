<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CatalogController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ContentController;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root — redirect to the visitor's preferred locale
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

Route::get('/', function (Request $request) {
    $supported = array_keys(config('localization.supported'));

    $locale = $request->session()->get('locale')
        ?? $request->getPreferredLanguage($supported)
        ?? config('localization.default');

    return redirect()->to('/'.$locale);
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

        Route::get('destinations', [CatalogController::class, 'destinations'])->name('destinations.index');
        Route::get('destinations/{destination}', [CatalogController::class, 'destination'])->name('destinations.show');
        Route::get('packages', [CatalogController::class, 'packages'])->name('packages.index');
        Route::get('packages/{tourPackage}', [CatalogController::class, 'package'])->name('packages.show');
        Route::get('hotels', [CatalogController::class, 'hotels'])->name('hotels.index');
        Route::get('hotels/{hotel}', [CatalogController::class, 'hotel'])->name('hotels.show');
        Route::get('transport', [CatalogController::class, 'transports'])->name('transports.index');
        Route::get('transport/{transport}', [CatalogController::class, 'transport'])->name('transports.show');
        Route::get('gallery', [ContentController::class, 'gallery'])->name('gallery.index');
        Route::get('gallery/{album:slug}', [ContentController::class, 'album'])->name('gallery.show');
        Route::get('testimonials', [ContentController::class, 'testimonials'])->name('testimonials.index');
        Route::get('faqs', [ContentController::class, 'faqs'])->name('faqs.index');
        Route::get('blog', [ContentController::class, 'posts'])->name('posts.index');
        Route::get('blog/{post}', [ContentController::class, 'post'])->name('posts.show');
        Route::get('contact', [ContentController::class, 'contact'])->name('contact.create');
        Route::post('contact', [ContentController::class, 'storeContact'])->middleware('throttle:6,1')->name('contact.store');
        Route::post('newsletter', [ContentController::class, 'subscribe'])->middleware('throttle:6,1')->name('newsletter.store');

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
