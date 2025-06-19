<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Add debugging
        Log::info('CheckAdminRole middleware running', [
            'is_authenticated' => auth()->check(),
            'user_role' => auth()->check() ? auth()->user()->role : null,
        ]);

        // For now, allow all authenticated users
        if (auth()->check()) {
            return $next($request);
        }
        
        abort(403, 'Unauthorized access');
    }
}