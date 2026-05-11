<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Check admin owns this building
        Building::where('id', $request->building_id)
                ->where('admin_id', Auth::id())
                ->firstOrFail();

        $data             = $request->except(['nid_front', 'nid_back', 'picture']);
        $data['admin_id'] = Auth::id();

        // Upload files
        if ($request->hasFile('nid_front')) {
            $data['nid_front'] = $request->file('nid_front')->store('tenants/nid', 'public');
        }
        if ($request->hasFile('nid_back')) {
            $data['nid_back'] = $request->file('nid_back')->store('tenants/nid', 'public');
        }
        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('tenants/pictures', 'public');
        }

        $tenant = Tenant::create($data);

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
     * Also updates flat status to vacant.
     *
     * @param Tenant $tenant
     */
    public function destroy(Tenant $tenant)
    {
        $this->authorizeTenant($tenant);

        // Update flat status to vacant
        Flat::find($tenant->flat_id)->update(['status' => 'vacant']);

        $tenant->delete();
        return back()->with('warning', 'Tenant removed successfully.');
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