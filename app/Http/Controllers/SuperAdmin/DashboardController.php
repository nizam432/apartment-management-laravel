<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Building;
use App\Models\Tenant;

/**
 * Class DashboardController
 *
 * Handles Super Admin dashboard statistics.
 *
 * @package App\Http\Controllers\SuperAdmin
 */
class DashboardController extends Controller
{
    /**
     * Display the Super Admin dashboard with system stats.
     */
    public function index()
    {
        $stats = [
            'total_admins'    => User::role('admin')->count(),
            'active_admins'   => User::role('admin')->where('is_active', true)->count(),
            'inactive_admins' => User::role('admin')->where('is_active', false)->count(),
            'total_buildings' => Building::count(),
            'total_tenants'   => Tenant::count(),
            'active_tenants'  => Tenant::where('status', 'active')->count(),
        ];

        // Latest 5 admins
        $latestAdmins = User::role('admin')->latest()->take(5)->get();

        return view('super-admin.dashboard', compact('stats', 'latestAdmins'));
    }
}