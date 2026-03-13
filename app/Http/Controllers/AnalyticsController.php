<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ClickLog;
use App\Models\ViewLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Services\AnalyticsService;

class AnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        $user = auth()->user();
        $stats = $this->analyticsService->getDashboardStats($user);

        if (!$stats) {
            return redirect()->route('dashboard')->with('error', 'Lütfen önce profilinizi oluşturun.');
        }

        return view('analytics.index', $stats);
    }
}
