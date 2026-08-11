<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectResidentRequests
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || Auth::user()->rol !== 'residente') {
            return $next($request);
        }

        $allowed = [
            'dashboard',
            'logout',
            'login',
            'livewire/*',
            'storage/*',
            'assets/*',
            'auth/*',
        ];

        foreach ($allowed as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            abort(403);
        }

        return redirect('/dashboard');
    }
}
