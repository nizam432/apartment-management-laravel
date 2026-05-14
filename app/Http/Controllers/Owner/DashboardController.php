<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Models\UtilityBill;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * Handles Owner dashboard statistics.
 *
 * @package App\Http\Controllers\Owner
 */
class DashboardController extends Controller
{
    /**
     * Display the Owner dashboard with stats.
     */
    public function index()
    {
        $ownerId = Auth::id();

        // Owner's flat IDs
        $flatIds = Flat::where('owner_id', $ownerId)->pluck('id');

        $stats = [
            'total_flats'    => $flatIds->count(),
            'occupied_flats' => Flat::where('owner_id', $ownerId)->where('status', 'occupied')->count(),
            'vacant_flats'   => Flat::where('owner_id', $ownerId)->where('status', 'vacant')->count(),
            'total_tenants'  => Tenant::whereIn('flat_id', $flatIds)->where('status', 'active')->count(),
            'total_received' => RentPayment::whereIn('flat_id', $flatIds)->sum('paid_amount'),
            'total_due'      => RentPayment::whereIn('flat_id', $flatIds)->sum('due_amount'),
            'pending_complaints' => Complaint::whereIn('flat_id', $flatIds)->where('status', 'pending')->count(),
            'unpaid_bills'   => UtilityBill::whereIn('flat_id', $flatIds)->where('status', 'unpaid')->count(),
        ];

        // Latest rent payments
        $latestPayments = RentPayment::whereIn('flat_id', $flatIds)
                                     ->with(['tenant', 'flat'])
                                     ->latest()
                                     ->take(5)
                                     ->get();

        return view('owner.dashboard', compact('stats', 'latestPayments'));
    }
}