<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load(['profile', 'links' => function($query) {
            $query->orderBy('order');
        }]);
        
        $total_links = $user->links->count();
        $total_clicks = $user->links->sum('clicks');
        $profile_views = $user->profile->views ?? 0;

        return view('dashboard', [
            'user' => $user,
            'profile' => $user->profile,
            'links' => $user->links,
            'total_links' => $total_links,
            'total_clicks' => $total_clicks,
            'profile_views' => $profile_views
        ]);
    }
}
