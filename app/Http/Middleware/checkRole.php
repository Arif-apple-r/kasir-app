<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $roles = preg_split('/[|,]/', (string) $roles);

        if (!in_array(Auth::user()->role, $roles, true)) {
            abort(403, 'Akses ditolak bro!');
        }

        return $next($request);
    }
}
