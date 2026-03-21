<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPlan
{
    public function handle(Request $request, Closure $next, string $plan): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->plan !== $plan) {
            return redirect()->route('dashboard')->with('error', 'Bu işlem için ' . strtoupper($plan) . ' planına geçmenizi öneririz.');
        }

        return $next($request);
    }
}
