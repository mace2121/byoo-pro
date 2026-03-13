<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PricingController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('price')->get();
        return view('pricing', compact('plans'));
    }
}
