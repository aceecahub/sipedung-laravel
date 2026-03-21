<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            // Redirect to dashboard with error or abort
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        // Restriction for Admin: Cannot perform 'Absen Ronda'
        if ($user->role === 'admin' && $request->routeIs('ronda.store')) {
             return redirect('/dashboard')->with('error', 'Admin tidak diperbolehkan melakukan absen ronda.');
        }

        // Restriction for KK: Only View (GET) except for Ronda Store
        if ($user->role === 'kk' && !$request->isMethod('get')) {
             if (!$request->routeIs('ronda.store')) {
                 return back()->with('error', 'Anda hanya memiliki hak akses untuk melihat data.');
             }
        }

        return $next($request);
    }
}
