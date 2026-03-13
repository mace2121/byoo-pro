<?php

namespace App\Services;

use App\Models\User;
use App\Models\ClickLog;
use App\Models\ViewLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get aggregated analytics data for a user's profile.
     */
    public function getDashboardStats(User $user, int $days = 30)
    {
        $profile = $user->profile;
        if (!$profile) return null;

        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        // Daily Views
        $dailyViews = ViewLog::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Daily Clicks
        $linkIds = $user->links->pluck('id')->toArray();
        $dailyClicks = ClickLog::whereIn('link_id', $linkIds)
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates for charts
        $chartData = [
            'labels' => [],
            'views' => [],
            'clicks' => [],
        ];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $chartData['labels'][] = Carbon::parse($date)->format('d M');
            $chartData['views'][] = $dailyViews[$date] ?? 0;
            $chartData['clicks'][] = $dailyClicks[$date] ?? 0;
        }

        // Top Links
        $topLinks = $user->links()
            ->orderByDesc('clicks')
            ->take(5)
            ->get();

        // Top Locations
        $topCountries = ViewLog::where('profile_id', $profile->id)
            ->whereNotNull('country')
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Combined Browser Stats
        $viewBrowsers = ViewLog::where('profile_id', $profile->id)
            ->select('browser', DB::raw('count(*) as count'));
        
        $topBrowsers = ClickLog::whereIn('link_id', $linkIds)
            ->select('browser', DB::raw('count(*) as count'))
            ->unionAll($viewBrowsers)
            ->select('browser', DB::raw('SUM(count) as total'))
            ->groupBy('browser')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Combined OS Stats
        $viewOS = ViewLog::where('profile_id', $profile->id)
            ->select('os', DB::raw('count(*) as count'));
        
        $topOS = ClickLog::whereIn('link_id', $linkIds)
            ->select('os', DB::raw('count(*) as count'))
            ->unionAll($viewOS)
            ->select('os', DB::raw('SUM(count) as total'))
            ->groupBy('os')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return [
            'chartData' => $chartData,
            'topLinks' => $topLinks,
            'topCountries' => $topCountries,
            'topBrowsers' => $topBrowsers,
            'topOS' => $topOS,
        ];
    }
}
