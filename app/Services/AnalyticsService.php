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
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();

        // Default structure
        $defaultStats = [
            'chartData' => ['labels' => [], 'views' => [], 'clicks' => []],
            'topLinks' => collect(),
            'topCountries' => collect(),
            'topCities' => collect(),
            'topBrowsers' => collect(),
            'topOS' => collect(),
            'recentClicks' => collect(),
            'totalLinks' => $user->blocks()->count(),
        ];

        if (!$profile) return $defaultStats;

        // Daily Views
        $dailyViews = ViewLog::where('profile_id', $profile->id)
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Daily Clicks
        $blockIds = $user->blocks->pluck('id')->toArray();
        $dailyClicks = ClickLog::whereIn('block_id', $blockIds)
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill chart data
        $chartData = ['labels' => [], 'views' => [], 'clicks' => []];
        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $chartData['labels'][] = Carbon::parse($date)->format('d M');
            $chartData['views'][] = $dailyViews[$date] ?? 0;
            $chartData['clicks'][] = $dailyClicks[$date] ?? 0;
        }

        // Top Blocks
        $topLinks = $user->blocks()->where('clicks', '>', 0)->orderByDesc('clicks')->take(10)->get();

        // Top Locations (Countries)
        $topCountries = ViewLog::where('profile_id', $profile->id)
            ->whereNotNull('country')
            ->select('country', DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Top Cities
        $topCities = ViewLog::where('profile_id', $profile->id)
            ->whereNotNull('city')
            ->select('city', 'country', DB::raw('count(*) as count'))
            ->groupBy('city', 'country')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        // Browser Stats (PHP Level Merge for stability)
        $viewBrowsers = ViewLog::where('profile_id', $profile->id)
            ->select('browser', DB::raw('count(*) as count'))
            ->groupBy('browser')
            ->pluck('count', 'browser')->toArray();
        
        $clickBrowsers = ClickLog::whereIn('block_id', $blockIds)
            ->select('browser', DB::raw('count(*) as count'))
            ->groupBy('browser')
            ->pluck('count', 'browser')->toArray();

        $allBrowsers = array_keys(array_merge($viewBrowsers, $clickBrowsers));
        $topBrowsers = collect($allBrowsers)->map(fn($b) => (object)[
            'browser' => $b ?: 'Other',
            'total' => ($viewBrowsers[$b] ?? 0) + ($clickBrowsers[$b] ?? 0)
        ])->sortByDesc('total')->take(5)->values();

        // OS Stats (PHP Level Merge)
        $viewOS = ViewLog::where('profile_id', $profile->id)
            ->select('os', DB::raw('count(*) as count'))
            ->groupBy('os')
            ->pluck('count', 'os')->toArray();
        
        $clickOS = ClickLog::whereIn('block_id', $blockIds)
            ->select('os', DB::raw('count(*) as count'))
            ->groupBy('os')
            ->pluck('count', 'os')->toArray();

        $allOS = array_keys(array_merge($viewOS, $clickOS));
        $topOS = collect($allOS)->map(fn($os) => (object)[
            'os' => $os ?: 'Other',
            'total' => ($viewOS[$os] ?? 0) + ($clickOS[$os] ?? 0)
        ])->sortByDesc('total')->take(5)->values();

        // Recent Clicks
        $recentClicks = ClickLog::whereIn('block_id', $blockIds)
            ->with('block')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return [
            'chartData' => $chartData,
            'topLinks' => $topLinks,
            'topCountries' => $topCountries,
            'topCities' => $topCities,
            'topBrowsers' => $topBrowsers,
            'topOS' => $topOS,
            'recentClicks' => $recentClicks,
            'totalLinks' => $user->blocks()->count(),
        ];
    }
}
