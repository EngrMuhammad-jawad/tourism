<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Keep the administration area role-agnostic: access is determined by
     * the dashboard permission, including the Super Admin Gate bypass.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->can('dashboard.view'), 403);

        return $next($request);
    }
}
