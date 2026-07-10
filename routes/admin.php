<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModuleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Administration
|--------------------------------------------------------------------------
| Admin URLs deliberately have no locale prefix: operational links remain
| stable, while the public site retains its localized URL structure.
*/
Route::middleware(['auth', 'admin.access'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');

        $modules = [
            'destinations' => ['destinations', 'destinations.view'],
            'packages' => ['packages', 'packages.view'],
            'hotels' => ['hotels', 'hotels.view'],
            'transports' => ['transports', 'transports.view'],
            'bookings' => ['bookings', 'bookings.view'],
            'albums' => ['albums', 'gallery.view'],
            'testimonials' => ['testimonials', 'testimonials.view'],
            'blog-categories' => ['blog-categories', 'blog.view'],
            'posts' => ['posts', 'blog.view'],
            'tags' => ['tags', 'blog.view'],
            'comments' => ['comments', 'comments.moderate'],
            'faqs' => ['faqs', 'faqs.view'],
            'contact-messages' => ['contact-messages', 'contacts.view'],
            'newsletter' => ['newsletter', 'newsletter.view'],
            'reports' => ['reports', 'reports.view'],
            'users' => ['users', 'users.view'],
            'roles' => ['roles', 'roles.manage'],
            'menus' => ['menus', 'menus.manage'],
            'settings' => ['settings', 'settings.manage'],
        ];

        foreach ($modules as $name => [$uri, $permission]) {
            Route::get($uri, [ModuleController::class, 'index'])->defaults('module', $name)->middleware("can:{$permission}")->name("{$name}.index");
            Route::get("{$uri}/create", [ModuleController::class, 'create'])->defaults('module', $name)->middleware("can:{$permission}")->name("{$name}.create");
            Route::post($uri, [ModuleController::class, 'store'])->defaults('module', $name)->middleware("can:{$permission}")->name("{$name}.store");
            Route::get("{$uri}/{record}/edit", [ModuleController::class, 'edit'])->defaults('module', $name)->middleware("can:{$permission}")->name("{$name}.edit");
            Route::put("{$uri}/{record}", [ModuleController::class, 'update'])->defaults('module', $name)->middleware("can:{$permission}")->name("{$name}.update");
            Route::delete("{$uri}/{record}", [ModuleController::class, 'destroy'])->defaults('module', $name)->middleware("can:{$permission}")->name("{$name}.destroy");
        }
    });
