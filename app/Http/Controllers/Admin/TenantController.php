<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Flat;
use App\Models\Floor;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class TenantController
 *
 * Handles tenant management for Admin panel.
 * Admin can only manage tenants in their own buildings.
 *
 * @package App\Http\Controllers\Admin
 */
class TenantController extends Controller
{
    /**
     * Display a paginated list of all tenants for admin's buildings.
     */
    public function index()
    {
        $tenants = Tenant::where('admin_id', Auth::id())
                         ->with(['building', 'floor', 'flat'])
                         ->latest()
                         ->paginate(15);

        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new tenant.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.tenants.create', compact('buildings'));
    }

    /**
     * Store a newly created tenant in the database.
     * Also creates a user account for the tenant.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'             => 'required|exists:buildings,id',
            'floor_id'                => 'required|exists:floors,id',
            'flat_id'                 => 'required|exists:flats,id',
            'name'                    => 'required|string|max:100',
            'phone'                   => 'required|string|max:20|unique:users,phone',
            'email'                   => 'nullable|email|max:100|unique:users,email',
            'password'                => 'required|string|min:6|confirmed',
            'permanent_address'       => 'nullable|string|max:255',
            'date_of_birth'           => 'nullable|date',
            'gender'                  => 'nullable|in:male,female,other',
            'profession'              => 'nullable|string|max:100',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'nid_front'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nid_back'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'picture'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notes'                   => 'nullable|string|max:500',
            'monthly_rent'            => 'required|numeric|min:0',
            'advance_amount'          => 'nullable|numeric|min:0',
            'move_in_date'            => 'required|date',
        ]);

        // Check admin owns this building
        Building::where('id', $request->building_id)
                ->where('admin_id', Auth::id())
                ->firstOrFail();

        // Create user account for tenant
        $user = \App\Models\User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign tenant role
        $user->assignRole('tenant');

        // Upload files
        $nidFront = null;
        $nidBack  = null;
        $picture  = null;

        if ($request->hasFile('nid_front')) {
            $nidFront = $request->file('nid_front')->store('tenants/nid', 'public');
        }
        if ($request->hasFile('nid_back')) {
            $nidBack = $request->file('nid_back')->store('tenants/nid', 'public');
        }
        if ($request->hasFile('picture')) {
            $picture = $request->file('picture')->store('tenants/pictures', 'public');
        }

        // Create tenant record
        $tenant = Tenant::create([
            'user_id'                 => $user->id,
            'admin_id'                => Auth::id(),
            'building_id'             => $request->building_id,
            'floor_id'                => $request->floor_id,
            'flat_id'                 => $request->flat_id,
            'name'                    => $request->name,
            'phone'                   => $request->phone,
            'email'                   => $request->email,
            'permanent_address'       => $request->permanent_address,
            'date_of_birth'           => $request->date_of_birth,
            'gender'                  => $request->gender,
            'profession'              => $request->profession,
            'emergency_contact_name'  => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'nid_front'               => $nidFront,
            'nid_back'                => $nidBack,
            'picture'                 => $picture,
            'notes'                   => $request->notes,
            'monthly_rent'            => $request->monthly_rent,
            'advance_amount'          => $request->advance_amount ?? 0,
            'move_in_date'            => $request->move_in_date,
            'status'                  => 'active',
        ]);

        // Update flat status to occupied
        Flat::find($request->flat_id)->update(['status' => 'occupied']);

        return redirect()->route('admin.tenants.index')
                         ->with('success', 'Tenant added successfully!');
    }

    /**
     * Show tenant details.
     *
     * @param Tenant $tenant
     */
    public function show(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);
        $documents = $tenant->documents;
        return view('admin.tenants.show', compact('tenant', 'documents'));
    }

    /**
     * Show the form for editing a tenant.
     *
     * @param Tenant $tenant
     */
    public function edit(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);
        $buildings = Building::where('admin_id', Auth::id())->get();
        $floors    = Floor::where('building_id', $tenant->building_id)->get();
        $flats     = Flat::where('floor_id', $tenant->floor_id)->get();
        return view('admin.tenants.edit', compact('tenant', 'buildings', 'floors', 'flats'));
    }

    /**
     * Update the specified tenant in the database.
     *
     * @param Request $request
     * @param Tenant $tenant
     */
    public function update(Request $request, Tenant $tenant)
    {
        $this->authorizeTenant($tenant);

        $request->validate([
            'name'                    => 'required|string|max:100',
            'phone'                   => 'required|string|max:20',
            'email'                   => 'nullable|email|max:100',
            'permanent_address'       => 'nullable|string|max:255',
            'date_of_birth'           => 'nullable|date',
            'gender'                  => 'nullable|in:male,female,other',
            'profession'              => 'nullable|string|max:100',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'nid_front'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nid_back'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'picture'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'notes'                   => 'nullable|string|max:500',
            'monthly_rent'            => 'required|numeric|min:0',
            'advance_amount'          => 'nullable|numeric|min:0',
            'move_in_date'            => 'required|date',
        ]);

        $data = $request->except(['nid_front', 'nid_back', 'picture']);

        // Upload new files
        if ($request->hasFile('nid_front')) {
            if ($tenant->nid_front) Storage::disk('public')->delete($tenant->nid_front);
            $data['nid_front'] = $request->file('nid_front')->store('tenants/nid', 'public');
        }
        if ($request->hasFile('nid_back')) {
            if ($tenant->nid_back) Storage::disk('public')->delete($tenant->nid_back);
            $data['nid_back'] = $request->file('nid_back')->store('tenants/nid', 'public');
        }
        if ($request->hasFile('picture')) {
            if ($tenant->picture) Storage::disk('public')->delete($tenant->picture);
            $data['picture'] = $request->file('picture')->store('tenants/pictures', 'public');
        }

        $tenant->update($data);

        return redirect()->route('admin.tenants.index')
                         ->with('success', 'Tenant updated successfully!');
    }

    /**
     * Remove the specified tenant (soft delete).
     * Cannot delete if tenant has rent payment records.
     *
     * @param Tenant $tenant
     */
    public function destroy(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);

        // Check if tenant has any rent payment records
        $hasPayments = \App\Models\RentPayment::where('tenant_id', $tenant->id)->exists();

        if ($hasPayments) {
            return back()->with('error', 'Cannot delete tenant. They have rent payment records. Use Move Out instead.');
        }

        // Update flat status to vacant
        Flat::find($tenant->flat_id)->update(['status' => 'vacant']);

        $tenant->delete();
        return back()->with('warning', 'Tenant removed successfully.');
    }

    /**
     * Show Move Out form.
     *
     * @param Tenant $tenant
     */
    public function moveOutForm(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);
        return view('admin.tenants.move-out', compact('tenant'));
    }

    /**
     * Process Move Out — saves MoveOutRecord and marks tenant inactive.
     *
     * @param Request $request
     * @param Tenant $tenant
     */
    public function moveOut(Request $request, Tenant $tenant)
    {
        $this->authorizeTenant($tenant);

        $request->validate([
            'move_out_date'    => 'required|date|after_or_equal:' . $tenant->move_in_date,
            'amount_returned'  => 'required|numeric|min:0|max:' . $tenant->advance_amount,
            'deduction_reason' => 'nullable|string|max:500',
            'reason'           => 'nullable|string|max:255',
        ]);

        $advancePaid    = $tenant->advance_amount ?? 0;
        $amountReturned = $request->amount_returned;
        $deduction      = max(0, $advancePaid - $amountReturned);

        // MoveOutRecord save করো
        \App\Models\MoveOutRecord::create([
            'tenant_id'        => $tenant->id,
            'flat_id'          => $tenant->flat_id,
            'floor_id'         => $tenant->floor_id,
            'building_id'      => $tenant->building_id,
            'advance_paid'     => $advancePaid,
            'amount_returned'  => $amountReturned,
            'deduction'        => $deduction,
            'deduction_reason' => $request->deduction_reason,
            'move_out_date'    => $request->move_out_date,
            'reason'           => $request->reason,
            'created_by'       => Auth::id(),
        ]);

        // Tenant inactive করো
        $tenant->update([
            'status'        => 'inactive',
            'move_out_date' => $request->move_out_date,
        ]);

        // Flat vacant করো
        Flat::find($tenant->flat_id)->update(['status' => 'vacant']);

        return redirect()->route('admin.tenants.move-out-record', $tenant->id)
                         ->with('success', 'Tenant moved out successfully! Receipt ready.');
    }

    /**
     * Show move-out receipt for a tenant.
     *
     * @param Tenant $tenant
     */
    public function moveOutRecord(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);

        $record = \App\Models\MoveOutRecord::where('tenant_id', $tenant->id)
                                           ->with(['flat', 'floor', 'building', 'createdBy'])
                                           ->latest()
                                           ->firstOrFail();

        return view('admin.tenants.move-out-record', compact('tenant', 'record'));
    }

    /**
     * Show Flat Transfer form.
     *
     * @param Tenant $tenant
     */
    public function transferForm(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);
        $floors = Floor::where('building_id', $tenant->building_id)->get();
        return view('admin.tenants.transfer', compact('tenant', 'floors'));
    }

    /**
     * Process Flat Transfer.
     *
     * @param Request $request
     * @param Tenant $tenant
     */
    public function transfer(Request $request, Tenant $tenant)
    {
        $this->authorizeTenant($tenant);

        $request->validate([
            'to_flat_id'    => 'required|exists:flats,id',
            'new_rent'      => 'required|numeric|min:0',
            'transfer_date' => 'required|date',
            'reason'        => 'nullable|string|max:255',
        ]);

        $newFlat = Flat::find($request->to_flat_id);

        // Save transfer history
        \App\Models\FlatTransferHistory::create([
            'tenant_id'     => $tenant->id,
            'building_id'   => $tenant->building_id,
            'from_flat_id'  => $tenant->flat_id,
            'to_flat_id'    => $request->to_flat_id,
            'from_floor_id' => $tenant->floor_id,
            'to_floor_id'   => $newFlat->floor_id,
            'old_rent'      => $tenant->monthly_rent,
            'new_rent'      => $request->new_rent,
            'transfer_date' => $request->transfer_date,
            'reason'        => $request->reason,
            'created_by'    => Auth::id(),
        ]);

        // Old flat → vacant
        Flat::find($tenant->flat_id)->update(['status' => 'vacant']);

        // New flat → occupied
        $newFlat->update(['status' => 'occupied']);

        // Update tenant
        $tenant->update([
            'flat_id'      => $request->to_flat_id,
            'floor_id'     => $newFlat->floor_id,
            'monthly_rent' => $request->new_rent,
        ]);

        return redirect()->route('admin.tenants.index')
                         ->with('success', 'Tenant transferred successfully!');
    }

    /**
     * Get flats for a specific floor as JSON (for dropdown).
     *
     * @param Floor $floor
     */
    public function flatsByFloor(Floor $floor)
    {
        $flats = Flat::where('floor_id', $floor->id)
                     ->where('status', 'vacant')
                     ->get(['id', 'flat_number', 'rent_amount']);
        return response()->json($flats);
    }

    /**
     * Ensure admin owns the building this tenant belongs to.
     *
     * @param Tenant $tenant
     */
    private function authorizeTenant(Tenant $tenant)
    {
        abort_if($tenant->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}