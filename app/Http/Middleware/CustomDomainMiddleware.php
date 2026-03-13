<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $systemDomains = ['byoo.pro', 'www.byoo.pro', 'localhost', '127.0.0.1'];

        if (!in_array($host, $systemDomains)) {
            $profile = \App\Models\Profile::where('custom_domain', $host)
                ->where('custom_domain_verified', true)
                ->where('is_active', true)
                ->first();

            if ($profile) {
                // Store the profile in the request so the controller can use it
                $request->attributes->set('custom_domain_profile', $profile);
            }
        }

        return $next($request);
    }
}
