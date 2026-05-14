<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Notice;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Models\UtilityBill;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * Handles Tenant dashboard statistics.
 *
 * @package App\Http\Controllers\Tenant
 */
class DashboardController extends Controller
{
    /**
     * Display the Tenant dashboard with stats.
     */
    public function index()
    {
        $tenant = Tenant::where('user_id', Auth::id())
                        ->where('status', 'active')
                        ->with(['building', 'flat', 'floor'])
                        ->first();

        if (!$tenant) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tenant record not found. Please contact admin.');
        }

        $stats = [
            'total_paid'         => RentPayment::where('tenant_id', $tenant->id)->sum('paid_amount'),
            'total_due'          => RentPayment::where('tenant_id', $tenant->id)->sum('due_amount'),
            'unpaid_bills'       => UtilityBill::where('tenant_id', $tenant->id)->where('status', 'unpaid')->count(),
            'total_complaints'   => Complaint::where('tenant_id', $tenant->id)->count(),
            'pending_complaints' => Complaint::where('tenant_id', $tenant->id)->where('status', 'pending')->count(),
        ];

        $latestPayments = RentPayment::where('tenant_id', $tenant->id)->latest()->take(3)->get();

        $notices = Notice::where(function ($q) use ($tenant) {
                        $q->where('building_id', $tenant->building_id)->orWhereNull('building_id');
                    })
                    ->where(function ($q) {
                        $q->whereNull('expire_date')->orWhere('expire_date', '>=', now());
                    })
                    ->whereIn('target', ['all', 'tenants'])
                    ->latest()->take(3)->get();

        return view('tenant.dashboard', compact('tenant', 'stats', 'latestPayments', 'notices'));
    }
}