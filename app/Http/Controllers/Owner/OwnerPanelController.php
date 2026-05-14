<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Flat;
use App\Models\Notice;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Models\UtilityBill;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Auth;

/**
 * Class OwnerPanelController
 *
 * Handles all Owner panel views.
 * Owner can only see data related to their own flats.
 *
 * @package App\Http\Controllers\Owner
 */
class OwnerPanelController extends Controller
{
    /**
     * Get owner's flat IDs.
     */
    private function flatIds()
    {
        return Flat::where('owner_id', Auth::id())->pluck('id');
    }

    /**
     * Display owner's flats.
     */
    public function flats()
    {
        $flats = Flat::where('owner_id', Auth::id())
                     ->with(['building', 'floor', 'tenant'])
                     ->paginate(15);

        return view('owner.flats', compact('flats'));
    }

    /**
     * Display tenants in owner's flats.
     */
    public function tenants()
    {
     
        $tenants = Tenant::whereIn('flat_id', $this->flatIds())
                         ->with(['building', 'flat'])
                         ->latest()
                         ->paginate(15);

        return view('owner.tenants', compact('tenants'));
    }

    /**
     * Display rent payment history for owner's flats.
     */
    public function rentPayments()
    {
        $payments = RentPayment::whereIn('flat_id', $this->flatIds())
                               ->with(['tenant', 'flat', 'building'])
                               ->latest()
                               ->paginate(15);

        $totalReceived = RentPayment::whereIn('flat_id', $this->flatIds())->sum('paid_amount');
        $totalDue      = RentPayment::whereIn('flat_id', $this->flatIds())->sum('due_amount');

        return view('owner.rent-payments', compact('payments', 'totalReceived', 'totalDue'));
    }

    /**
     * Display utility bills for owner's flats.
     */
    public function utilityBills()
    {
        $bills = UtilityBill::whereIn('flat_id', $this->flatIds())
                            ->with(['tenant', 'flat', 'building'])
                            ->latest()
                            ->paginate(15);

        return view('owner.utility-bills', compact('bills'));
    }

    /**
     * Display complaints for owner's flats.
     */
    public function complaints()
    {
        $complaints = Complaint::whereIn('flat_id', $this->flatIds())
                               ->with(['tenant', 'flat', 'building'])
                               ->latest()
                               ->paginate(15);

        return view('owner.complaints', compact('complaints'));
    }

    /**
     * Display visitor logs for owner's flats.
     */
    public function visitorLogs()
    {
        $logs = VisitorLog::whereIn('flat_id', $this->flatIds())
                          ->with(['tenant', 'flat', 'building'])
                          ->latest()
                          ->paginate(15);

        return view('owner.visitor-logs', compact('logs'));
    }

    /**
     * Display notices for owner.
     */
    public function notices()
    {
        $flatIds     = $this->flatIds();
        $buildingIds = Flat::whereIn('id', $flatIds)->pluck('building_id');

        $notices = Notice::where(function ($q) use ($buildingIds) {
                        $q->whereIn('building_id', $buildingIds)
                          ->orWhereNull('building_id');
                    })
                    ->where(function ($q) {
                        $q->whereNull('expire_date')
                          ->orWhere('expire_date', '>=', now());
                    })
                    ->whereIn('target', ['all', 'owners'])
                    ->latest()
                    ->paginate(15);

        return view('owner.notices', compact('notices'));
    }
}