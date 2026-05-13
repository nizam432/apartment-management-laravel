<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Flat;
use App\Models\Tenant;
use App\Models\UtilityBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UtilityBillController
 *
 * Handles utility bill management for Admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class UtilityBillController extends Controller
{
    /**
     * Display a paginated list of utility bills.
     */
    public function index(Request $request)
    {
        $query = UtilityBill::where('admin_id', Auth::id())
                            ->with(['building', 'flat', 'tenant']);

        if ($request->month) {
            $query->where('month', $request->month);
        }
        if ($request->building_id) {
            $query->where('building_id', $request->building_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bills     = $query->latest()->paginate(15);
        $buildings = Building::where('admin_id', Auth::id())->get();

        return view('admin.utility-bills.index', compact('bills', 'buildings'));
    }

    /**
     * Show the form for creating a new utility bill.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.utility-bills.create', compact('buildings'));
    }

    /**
     * Store a newly created utility bill.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'      => 'required|exists:buildings,id',
            'flat_id'          => 'required|exists:flats,id',
            'tenant_id'        => 'required|exists:tenants,id',
            'month'            => 'required|string',
            'water_bill'       => 'nullable|numeric|min:0',
            'electricity_bill' => 'nullable|numeric|min:0',
            'previous_reading' => 'nullable|integer|min:0',
            'current_reading'  => 'nullable|integer|min:0',
            'rate_per_unit'    => 'nullable|numeric|min:0',
            'other_bill'       => 'nullable|numeric|min:0',
            'other_bill_title' => 'nullable|string|max:100',
        ]);

        // Check duplicate bill for same tenant & month
        $exists = UtilityBill::where('tenant_id', $request->tenant_id)
                             ->where('month', $request->month)
                             ->exists();

        if ($exists) {
            return back()->withErrors(['month' => 'Utility bill already exists for this tenant and month.'])
                         ->withInput();
        }

        // Calculate electricity bill for postpaid
        $electricityBill = $request->electricity_bill ?? 0;
        $unitUsed        = null;

        if ($request->previous_reading && $request->current_reading && $request->rate_per_unit) {
            $unitUsed        = $request->current_reading - $request->previous_reading;
            $electricityBill = $unitUsed * $request->rate_per_unit;
        }

        // Calculate total
        $total = ($request->water_bill ?? 0)
               + $electricityBill
               + ($request->other_bill ?? 0);

        UtilityBill::create([
            'admin_id'         => Auth::id(),
            'building_id'      => $request->building_id,
            'flat_id'          => $request->flat_id,
            'tenant_id'        => $request->tenant_id,
            'month'            => $request->month,
            'water_bill'       => $request->water_bill ?? 0,
            'electricity_bill' => $electricityBill,
            'previous_reading' => $request->previous_reading,
            'current_reading'  => $request->current_reading,
            'unit_used'        => $unitUsed,
            'rate_per_unit'    => $request->rate_per_unit,
            'other_bill'       => $request->other_bill ?? 0,
            'other_bill_title' => $request->other_bill_title,
            'total_amount'     => $total,
            'status'           => 'unpaid',
        ]);

        return redirect()->route('admin.utility-bills.index')
                         ->with('success', 'Utility bill created successfully!');
    }

    /**
     * Show utility bill details.
     *
     * @param UtilityBill $utilityBill
     */
    public function show(UtilityBill $utilityBill)
    {
        $this->authorizeBill($utilityBill);
        return view('admin.utility-bills.show', compact('utilityBill'));
    }

    /**
     * Mark utility bill as paid.
     *
     * @param Request $request
     * @param UtilityBill $utilityBill
     */
    public function markPaid(Request $request, UtilityBill $utilityBill)
    {
        $this->authorizeBill($utilityBill);

        $request->validate([
            'paid_date'      => 'required|date',
            'payment_method' => 'required|in:cash,bkash,nagad,bank,other',
        ]);

        $utilityBill->update([
            'status'         => 'paid',
            'paid_date'      => $request->paid_date,
            'payment_method' => $request->payment_method,
        ]);

        return back()->with('success', 'Bill marked as paid!');
    }

    /**
     * Remove the specified utility bill.
     *
     * @param UtilityBill $utilityBill
     */
    public function destroy(UtilityBill $utilityBill)
    {
        $this->authorizeBill($utilityBill);
        $utilityBill->delete();
        return back()->with('warning', 'Utility bill deleted successfully.');
    }

    /**
     * Get flat details for utility bill form.
     *
     * @param Flat $flat
     */
    public function flatDetails(Flat $flat)
    {
        $tenant = Tenant::where('flat_id', $flat->id)
                        ->where('status', 'active')
                        ->first(['id', 'name', 'phone']);

        return response()->json([
            'tenant'           => $tenant,
            'water_bill'       => $flat->water_bill_applicable ? $flat->water_bill_amount : 0,
            'electricity_type' => $flat->electricity_type,
            'meter_no'         => $flat->electricity_meter_no,
        ]);
    }

    /**
     * Ensure admin owns this bill.
     *
     * @param UtilityBill $utilityBill
     */
    private function authorizeBill(UtilityBill $utilityBill)
    {
        abort_if($utilityBill->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}