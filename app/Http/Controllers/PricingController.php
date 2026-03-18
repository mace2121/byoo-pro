<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PricingController extends Controller
{
    public function index()
    {
        $plans = Plan::query()
            ->whereIn('slug', ['free', 'pro'])
            ->get()
            ->sortBy(fn (Plan $plan) => array_search($plan->slug, ['free', 'pro'], true))
            ->values();

        return view('pricing', compact('plans'));
    }
}
