<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Flat;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class FlatController
 *
 * Handles flat/unit management for Admin panel.
 * Admin selects building & floor from dropdown when creating/editing flats.
 *
 * @package App\Http\Controllers\Admin
 */
class FlatController extends Controller
{
    /**
     * Display a paginated list of all flats for admin's buildings.
     */
    public function index()
    {
        $flats = Flat::whereHas('building', fn($q) => $q->where('admin_id', Auth::id()))
                     ->with(['building', 'floor'])
                     ->latest()
                     ->paginate(15);

        return view('admin.flats.index', compact('flats'));
    }

    /**
     * Show the form for creating a new flat.
     * Loads admin's buildings for dropdown.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.flats.create', compact('buildings'));
    }

    /**
     * Store a newly created flat in the database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'           => 'required|exists:buildings,id',
            'floor_id'              => 'required|exists:floors,id',
            'flat_number'           => 'required|string|max:20',
            'flat_type'             => 'nullable|string|max:50',
            'size_sqft'             => 'nullable|numeric|min:0',
            'rent_amount'           => 'required|numeric|min:0',
            'electricity_type'      => 'required|in:prepaid,postpaid',
            'electricity_meter_no'  => 'nullable|string|max:50',
            'water_bill_applicable' => 'nullable|boolean',
            'water_bill_amount'     => 'nullable|numeric|min:0',
        ]);

        // Check admin owns this building
        Building::where('id', $request->building_id)
                ->where('admin_id', Auth::id())
                ->firstOrFail();

        Flat::create([
            'building_id'           => $request->building_id,
            'floor_id'              => $request->floor_id,
            'flat_number'           => $request->flat_number,
            'flat_type'             => $request->flat_type,
            'size_sqft'             => $request->size_sqft,
            'rent_amount'           => $request->rent_amount,
            'electricity_type'      => $request->electricity_type,
            'electricity_meter_no'  => $request->electricity_meter_no,
            'water_bill_applicable' => $request->has('water_bill_applicable'),
            'water_bill_amount'     => $request->water_bill_amount,
            'status'                => 'vacant',
        ]);

        // Update total units in floor
        Floor::find($request->floor_id)->increment('total_units');

        return redirect()->route('admin.flats.index')
                         ->with('success', 'Flat created successfully!');
    }

    /**
     * Show the form for editing a flat.
     *
     * @param Flat $flat
     */
    public function edit(Flat $flat)
    {
        $this->authorizeFlat($flat);
        $buildings = Building::where('admin_id', Auth::id())->get();
        $floors    = Floor::where('building_id', $flat->building_id)->get();
        return view('admin.flats.edit', compact('flat', 'buildings', 'floors'));
    }

    /**
     * Update the specified flat in the database.
     *
     * @param Request $request
     * @param Flat $flat
     */
    public function update(Request $request, Flat $flat)
    {
        $this->authorizeFlat($flat);

        $request->validate([
            'building_id'           => 'required|exists:buildings,id',
            'floor_id'              => 'required|exists:floors,id',
            'flat_number'           => 'required|string|max:20',
            'flat_type'             => 'nullable|string|max:50',
            'size_sqft'             => 'nullable|numeric|min:0',
            'rent_amount'           => 'required|numeric|min:0',
            'electricity_type'      => 'required|in:prepaid,postpaid',
            'electricity_meter_no'  => 'nullable|string|max:50',
            'water_bill_applicable' => 'nullable|boolean',
            'water_bill_amount'     => 'nullable|numeric|min:0',
        ]);

        $flat->update([
            'building_id'           => $request->building_id,
            'floor_id'              => $request->floor_id,
            'flat_number'           => $request->flat_number,
            'flat_type'             => $request->flat_type,
            'size_sqft'             => $request->size_sqft,
            'rent_amount'           => $request->rent_amount,
            'electricity_type'      => $request->electricity_type,
            'electricity_meter_no'  => $request->electricity_meter_no,
            'water_bill_applicable' => $request->has('water_bill_applicable'),
            'water_bill_amount'     => $request->water_bill_amount,
        ]);

        return redirect()->route('admin.flats.index')
                         ->with('success', 'Flat updated successfully!');
    }

    /**
     * Remove the specified flat from the database (soft delete).
     *
     * @param Flat $flat
     */
    public function destroy(Flat $flat)
    {
        $this->authorizeFlat($flat);
        $flat->delete();
        return back()->with('warning', 'Flat deleted successfully.');
    }

    /**
     * Ensure admin owns the building this flat belongs to.
     *
     * @param Flat $flat
     */
    private function authorizeFlat(Flat $flat)
    {
        abort_if($flat->building->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}