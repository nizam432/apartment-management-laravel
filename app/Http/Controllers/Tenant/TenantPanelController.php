<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Notice;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Models\UtilityBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TenantPanelController
 *
 * Handles Tenant panel views and actions.
 *
 * @package App\Http\Controllers\Tenant
 */
class TenantPanelController extends Controller
{
    /**
     * Get current tenant record.
     */
    private function getTenant()
    {
        return Tenant::where('user_id', Auth::id())
                     ->where('status', 'active')
                     ->firstOrFail();
    }

    /**
     * Display tenant's flat info.
     */
    public function flat()
    {
        $tenant = $this->getTenant();
        $tenant->load(['building', 'floor', 'flat']);
        return view('tenant.flat', compact('tenant'));
    }

    /**
     * Display rent payment history.
     */
    public function rentPayments()
    {
        $tenant    = $this->getTenant();
        $payments  = RentPayment::where('tenant_id', $tenant->id)->latest()->paginate(12);
        $totalPaid = RentPayment::where('tenant_id', $tenant->id)->sum('paid_amount');
        $totalDue  = RentPayment::where('tenant_id', $tenant->id)->sum('due_amount');
        return view('tenant.rent-payments', compact('tenant', 'payments', 'totalPaid', 'totalDue'));
    }

    /**
     * Display utility bill history.
     */
    public function utilityBills()
    {
        $tenant = $this->getTenant();
        $bills  = UtilityBill::where('tenant_id', $tenant->id)->latest()->paginate(12);
        return view('tenant.utility-bills', compact('tenant', 'bills'));
    }

    /**
     * Display complaints.
     */
    public function complaints()
    {
        $tenant     = $this->getTenant();
        $complaints = Complaint::where('tenant_id', $tenant->id)->latest()->paginate(12);
        return view('tenant.complaints', compact('tenant', 'complaints'));
    }

    /**
     * Show complaint create form.
     */
    public function createComplaint()
    {
        $tenant = $this->getTenant();
        return view('tenant.complaint-create', compact('tenant'));
    }

    /**
     * Store a new complaint.
     *
     * @param Request $request
     */
    public function storeComplaint(Request $request)
    {
        $tenant = $this->getTenant();

        $request->validate([
            'subject'     => 'required|string|max:200',
            'description' => 'required|string|max:1000',
        ]);

        Complaint::create([
            'admin_id'    => $tenant->admin_id,
            'building_id' => $tenant->building_id,
            'flat_id'     => $tenant->flat_id,
            'tenant_id'   => $tenant->id,
            'subject'     => $request->subject,
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        return redirect()->route('tenant.complaints')
                         ->with('success', 'Complaint submitted successfully!');
    }

    /**
     * Display notices for tenant.
     */
    public function notices()
    {
        $tenant  = $this->getTenant();
        $notices = Notice::where(function ($q) use ($tenant) {
                        $q->where('building_id', $tenant->building_id)->orWhereNull('building_id');
                    })
                    ->where(function ($q) {
                        $q->whereNull('expire_date')->orWhere('expire_date', '>=', now());
                    })
                    ->whereIn('target', ['all', 'tenants'])
                    ->latest()->paginate(15);

        return view('tenant.notices', compact('notices'));
    }
}