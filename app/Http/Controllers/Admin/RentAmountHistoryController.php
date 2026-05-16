<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentAmountHistory;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RentAmountHistoryController
 *
 * Handles rent amount change history for Admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class RentAmountHistoryController extends Controller
{
    /**
     * Display rent amount history for a specific tenant.
     *
     * @param Tenant $tenant
     */
    public function index(Tenant $tenant)
    {
        abort_if($tenant->admin_id !== Auth::id(), 403);

        $histories = RentAmountHistory::where('tenant_id', $tenant->id)
                                      ->with('createdBy')
                                      ->latest('effective_from')
                                      ->get();

        return view('admin.rent-amount-history.index', compact('tenant', 'histories'));
    }

    /**
     * Show form to update rent amount.
     *
     * @param Tenant $tenant
     */
    public function create(Tenant $tenant)
    {
        abort_if($tenant->admin_id !== Auth::id(), 403);
        return view('admin.rent-amount-history.create', compact('tenant'));
    }

    /**
     * Store new rent amount change.
     *
     * @param Request $request
     * @param Tenant $tenant
     */
    public function store(Request $request, Tenant $tenant)
    {
        abort_if($tenant->admin_id !== Auth::id(), 403);

        $request->validate([
            'new_amount'     => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'reason'         => 'nullable|string|max:255',
        ]);

        // Save history
        RentAmountHistory::create([
            'flat_id'        => $tenant->flat_id,
            'tenant_id'      => $tenant->id,
            'created_by'     => Auth::id(),
            'old_amount'     => $tenant->monthly_rent,
            'new_amount'     => $request->new_amount,
            'effective_from' => $request->effective_from,
            'reason'         => $request->reason,
        ]);

        // Update tenant's current monthly rent
        $tenant->update(['monthly_rent' => $request->new_amount]);

        return redirect()->route('admin.rent-amount-history.index', $tenant->id)
                         ->with('success', 'Rent amount updated successfully!');
    }
}