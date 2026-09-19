<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Platform user statistics (No financial data!)
        $totalUsers = User::where('role', 'user')->count();
        $activeUsers = User::where('role', 'user')->where('status', 'active')->count();
        $newUsersThisMonth = User::where('role', 'user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $suspendedUsers = User::where('role', 'user')->where('status', 'suspended')->count();

        // Registration Growth Chart (Last 6 Months)
        $chartMonths = [];
        $userGrowthSeries = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartMonths[] = $date->translatedFormat('M Y');

            $count = User::where('role', 'user')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $userGrowthSeries[] = $count;
        }

        // Recent Security Logs
        $recentSecurityLogs = SecurityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // System Health Status
        $systemStatus = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_status' => 'Connected (MySQL)',
            'queue_status' => 'Idle / Operational',
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'newUsersThisMonth',
            'suspendedUsers',
            'chartMonths',
            'userGrowthSeries',
            'recentSecurityLogs',
            'systemStatus'
        ));
    }
}
