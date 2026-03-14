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
        $profile = $user->profile;
        
        $total_links = $user->links->count();
        $total_clicks = $user->links->sum('clicks');
        $profile_views = $profile?->views ?? 0;

        // Analytics data
        $linkIds = $user->links->pluck('id');
        $top_browsers = \App\Models\ClickLog::whereIn('link_id', $linkIds)
            ->selectRaw('browser, count(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $top_os = \App\Models\ClickLog::whereIn('link_id', $linkIds)
            ->selectRaw('os, count(*) as count')
            ->groupBy('os')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $top_countries = \App\Models\ClickLog::whereIn('link_id', $linkIds)
            ->selectRaw('country, count(*) as count')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'profile' => $profile,
            'links' => $user->links,
            'total_links' => $total_links,
            'total_clicks' => $total_clicks,
            'profile_views' => $profile_views,
            'top_browsers' => $top_browsers,
            'top_os' => $top_os,
            'top_countries' => $top_countries,
            'qr_code_url' => "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode(route('public.profile', $user->username)),
        ]);
    }
}
