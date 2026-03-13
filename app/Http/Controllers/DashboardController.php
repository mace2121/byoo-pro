<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $total_links = $user->links()->count();
        $total_clicks = $user->links()->sum('clicks');
        $profile_views = $user->profile->views ?? 0;

        return view('dashboard', compact('total_links', 'total_clicks', 'profile_views'));
    }
}
