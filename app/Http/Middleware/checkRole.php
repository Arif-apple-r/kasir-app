<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Convert roles string ("admin|editor") to array ['admin', 'editor']
        $roles = explode('|', $roles);

        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Akses ditolak bro!');
        }

        return $next($request);
    }
}
