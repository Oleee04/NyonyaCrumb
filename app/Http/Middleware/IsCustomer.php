<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/auth/redirect')->with('msgError', 'Silakan login terlebih dahulu untuk mengakses fitur ini');
        }

        // Allow any authenticated user (admin, superadmin, customer) to test the cart functionality
        return $next($request);
    }
}
