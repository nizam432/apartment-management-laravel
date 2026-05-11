<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Tenant;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * Handles Admin dashboard statistics.
 *
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    /**
     * Display the Admin dashboard with stats.
     */
    public function index()
    {
        $adminId = Auth::id();

        $stats = [
            'total_buildings' => Building::where('admin_id', $adminId)->count(),
            'total_tenants'   => Tenant::where('admin_id', $adminId)->count(),
            'active_tenants'  => Tenant::where('admin_id', $adminId)->where('status', 'active')->count(),
            'vacant_flats'    => \App\Models\Flat::whereHas('building', fn($q) => $q->where('admin_id', $adminId))
                                    ->where('status', 'vacant')->count(),
        ];

        // Latest tenants
        $latestTenants = Tenant::where('admin_id', $adminId)
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact('stats', 'latestTenants'));
    }
}