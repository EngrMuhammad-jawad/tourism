<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Read the {locale} URL segment, activate it application-wide and
     * remember it in the session so the root URL can redirect back to
     * the visitor's last language.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        abort_unless(
            is_string($locale) && array_key_exists($locale, config('localization.supported')),
            404
        );

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        // Make route() calls resolve {locale} automatically so controllers
        // and views never have to pass it explicitly.
        URL::defaults(['locale' => $locale]);
        $request->route()->forgetParameter('locale');

        return $next($request);
    }
}
