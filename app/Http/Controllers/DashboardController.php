<?php

namespace App\Http\Controllers;

use App\Services\BlockService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected \App\Services\BlockService $blockService,
        protected \App\Services\AnalyticsService $analyticsService
    ) {
    }

    public function index()
    {
        $user = Auth::user();
        $user->load(['profile', 'links' => function($query) {
            $query->orderBy('order');
        }]);
        $profile = $user->profile;
        $blocks = $this->blockService->getDashboardBlocks($user);
        
        /** @var \App\Models\User $user */
        $stats = $this->analyticsService->getDashboardStats($user);

        $marketplace_themes = \App\Models\Theme::where('is_active', true)
            ->where('is_approved', true)
            ->with('creator')
            ->latest()
            ->get();

        return view('dashboard', [
            'marketplace_themes' => $marketplace_themes,
            'user' => $user,
            'profile' => $profile,
            'links' => $user->links,
            'blocks' => $blocks,
            'blocks_ready' => $this->blockService->blocksTableExists(),
            'total_links' => $stats['totalLinks'] ?? 0,
            'total_clicks' => array_sum($stats['chartData']['clicks'] ?? [0]),
            'profile_views' => array_sum($stats['chartData']['views'] ?? [0]),
            'top_browsers' => $stats['topBrowsers'] ?? collect(),
            'top_os' => $stats['topOS'] ?? collect(),
            'top_countries' => $stats['topCountries'] ?? collect(),
            'top_cities' => $stats['topCities'] ?? collect(),
            'top_links' => $stats['topLinks'] ?? collect(),
            'qr_code_url' => "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode(route('public.profile', $user->username)),
        ]);
    }
}
