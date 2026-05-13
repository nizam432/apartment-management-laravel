<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Flat;
use App\Models\RentPayment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RentPaymentController
 *
 * Handles rent payment management for Admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class RentPaymentController extends Controller
{
    /**
     * Display a paginated list of rent payments.
     */
    public function index(Request $request)
    {
        $query = RentPayment::where('admin_id', Auth::id())
                            ->with(['building', 'flat', 'tenant']);

        // Filter by month
        if ($request->month) {
            $query->where('month', $request->month);
        }

        // Filter by building
        if ($request->building_id) {
            $query->where('building_id', $request->building_id);
        }

        $payments   = $query->latest()->paginate(15);
        $buildings  = Building::where('admin_id', Auth::id())->get();

        return view('admin.rent-payments.index', compact('payments', 'buildings'));
    }

    /**
     * Show the form for creating a new rent payment.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.rent-payments.create', compact('buildings'));
    }

    /**
     * Store a newly created rent payment.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'    => 'required|exists:buildings,id',
            'flat_id'        => 'required|exists:flats,id',
            'tenant_id'      => 'required|exists:tenants,id',
            'month'          => 'required|string',
            'rent_amount'    => 'required|numeric|min:0',
            'paid_amount'    => 'required|numeric|min:0',
            'paid_date'      => 'required|date',
            'payment_method' => 'required|in:cash,bkash,nagad,bank,other',
            'transaction_id' => 'nullable|string|max:100',
            'note'           => 'nullable|string|max:500',
        ]);

        // Auto calculate due amount
        $dueAmount = $request->rent_amount - $request->paid_amount;

        // Check duplicate payment for same tenant & month
        $exists = RentPayment::where('tenant_id', $request->tenant_id)
                             ->where('month', $request->month)
                             ->exists();

        if ($exists) {
            return back()->withErrors(['month' => 'Rent payment already exists for this tenant and month.'])
                         ->withInput();
        }

        RentPayment::create([
            'admin_id'       => Auth::id(),
            'building_id'    => $request->building_id,
            'flat_id'        => $request->flat_id,
            'tenant_id'      => $request->tenant_id,
            'month'          => $request->month,
            'rent_amount'    => $request->rent_amount,
            'paid_amount'    => $request->paid_amount,
            'due_amount'     => max(0, $dueAmount),
            'paid_date'      => $request->paid_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'note'           => $request->note,
        ]);

        return redirect()->route('admin.rent-payments.index')
                         ->with('success', 'Rent payment recorded successfully!');
    }

    /**
     * Show rent payment details.
     *
     * @param RentPayment $rentPayment
     */
    public function show(RentPayment $rentPayment)
    {
        $this->authorizePayment($rentPayment);
        return view('admin.rent-payments.show', compact('rentPayment'));
    }

    /**
     * Remove the specified rent payment.
     *
     * @param RentPayment $rentPayment
     */
    public function destroy(RentPayment $rentPayment)
    {
        $this->authorizePayment($rentPayment);
        $rentPayment->delete();
        return back()->with('warning', 'Payment record deleted successfully.');
    }

    /**
     * Get tenants for a specific flat as JSON.
     *
     * @param Flat $flat
     */
    public function tenantByFlat(Flat $flat)
    {
        $tenant = Tenant::where('flat_id', $flat->id)
                        ->where('status', 'active')
                        ->first(['id', 'name', 'phone', 'monthly_rent']);
        return response()->json($tenant);
    }

    /**
     * Show tenant's payment history.
     *
     * @param Tenant $tenant
     */
    public function tenantHistory(Tenant $tenant)
    {
        abort_if($tenant->admin_id !== Auth::id(), 403);

        $payments = RentPayment::where('tenant_id', $tenant->id)
                               ->latest()
                               ->paginate(12);

        $totalPaid = RentPayment::where('tenant_id', $tenant->id)->sum('paid_amount');
        $totalDue  = RentPayment::where('tenant_id', $tenant->id)->sum('due_amount');

        return view('admin.rent-payments.tenant-history', compact('tenant', 'payments', 'totalPaid', 'totalDue'));
    }

    /**
     * Ensure admin owns this payment record.
     *
     * @param RentPayment $rentPayment
     */
    private function authorizePayment(RentPayment $rentPayment)
    {
        abort_if($rentPayment->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}