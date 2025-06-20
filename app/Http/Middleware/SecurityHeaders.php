<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add security headers to prevent information leakage
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Prevent caching of sensitive pages
        if ($this->isSensitivePage($request)) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }

    /**
     * Check if the current page contains sensitive information
     */
    private function isSensitivePage(Request $request): bool
    {
        $sensitiveRoutes = [
            'cargo.info',
            'tickets.receipt',
            'passenger-report.show',
            'users.show',
            'users.edit',
        ];

        $routeName = $request->route()?->getName();
        
        return in_array($routeName, $sensitiveRoutes) || 
               str_contains($request->path(), 'admin') ||
               str_contains($request->path(), 'cash-report');
    }
}