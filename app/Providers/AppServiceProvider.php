<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ini_set('memory_limit', '512M');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Surface missing eager loads during development instead of
        // silently running N+1 queries.
        Model::preventLazyLoading(! $this->app->isProduction());

        // Super Admin passes every permission check.
        Gate::before(function (User $user, string $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Strip index.php from base URL and force clean URLs
        if (isset($_SERVER['SCRIPT_NAME']) && str_ends_with($_SERVER['SCRIPT_NAME'], 'index.php')) {
            $_SERVER['SCRIPT_NAME'] = preg_replace('#/index\.php$#i', '', $_SERVER['SCRIPT_NAME']) ?: '';
        }
        if (config('app.url') && !app()->runningInConsole()) {
            \Illuminate\Support\Facades\URL::forceRootUrl(rtrim(config('app.url'), '/'));
        }
    }
}

