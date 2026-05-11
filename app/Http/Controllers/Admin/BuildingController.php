<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class BuildingController
 *
 * Handles building management for Admin panel.
 * Admin can only manage their own buildings.
 *
 * @package App\Http\Controllers\Admin
 */
class BuildingController extends Controller
{
    /**
     * Display a paginated list of admin's buildings.
     */
    public function index()
    {
        $buildings = Building::where('admin_id', Auth::id())
                             ->latest()
                             ->paginate(10);

        return view('admin.buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new building.
     */
    public function create()
    {
        return view('admin.buildings.create');
    }

    /**
     * Store a newly created building in the database.
     * Auto-creates floors based on total_floors.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:100',
            'address'               => 'required|string|max:255',
            'city'                  => 'required|string|max:50',
            'area'                  => 'nullable|string|max:50',
            'total_floors'          => 'required|integer|min:1|max:50',
            'electricity_type'      => 'required|in:prepaid,postpaid',
            'water_bill_applicable' => 'nullable|boolean',
            'water_bill_amount'     => 'nullable|numeric|min:0',
            'description'           => 'nullable|string|max:500',
            'image'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data                = $request->except('image');
        $data['admin_id']    = Auth::id();
        $data['water_bill_applicable'] = $request->has('water_bill_applicable');

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('buildings', 'public');
        }

        $building = Building::create($data);

        // Auto-create floors
        for ($i = 1; $i <= $request->total_floors; $i++) {
            $building->floors()->create([
                'floor_number' => $i,
                'floor_name'   => $this->floorLabel($i),
            ]);
        }

        return redirect()->route('admin.buildings.index')
                         ->with('success', 'Building created successfully!');
    }

    /**
     * Show building details with floors.
     *
     * @param Building $building
     */
    public function show(Building $building)
    {
        $this->authorizeBuilding($building);
        $floors = $building->floors()->withCount('flats')->get();
        return view('admin.buildings.show', compact('building', 'floors'));
    }

    /**
     * Show the form for editing a building.
     *
     * @param Building $building
     */
    public function edit(Building $building)
    {
        $this->authorizeBuilding($building);
        return view('admin.buildings.edit', compact('building'));
    }

    /**
     * Update the specified building in the database.
     *
     * @param Request $request
     * @param Building $building
     */
    public function update(Request $request, Building $building)
    {
        $this->authorizeBuilding($building);

        $request->validate([
            'name'                  => 'required|string|max:100',
            'address'               => 'required|string|max:255',
            'city'                  => 'required|string|max:50',
            'area'                  => 'nullable|string|max:50',
            'electricity_type'      => 'required|in:prepaid,postpaid',
            'water_bill_applicable' => 'nullable|boolean',
            'water_bill_amount'     => 'nullable|numeric|min:0',
            'description'           => 'nullable|string|max:500',
            'image'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['water_bill_applicable'] = $request->has('water_bill_applicable');

        // Upload new image
        if ($request->hasFile('image')) {
            if ($building->image) {
                Storage::disk('public')->delete($building->image);
            }
            $data['image'] = $request->file('image')->store('buildings', 'public');
        }

        $building->update($data);

        return redirect()->route('admin.buildings.index')
                         ->with('success', 'Building updated successfully!');
    }

    /**
     * Remove the specified building from the database (soft delete).
     *
     * @param Building $building
     */
    public function destroy(Building $building)
    {
        $this->authorizeBuilding($building);

        if ($building->image) {
            Storage::disk('public')->delete($building->image);
        }

        $building->delete();

        return back()->with('warning', 'Building deleted successfully.');
    }

    /**
     * Toggle active/inactive status of a building.
     *
     * @param Building $building
     */
    public function toggleStatus(Building $building)
    {
        $this->authorizeBuilding($building);
        $building->update([
            'status' => $building->status === 'active' ? 'inactive' : 'active'
        ]);
        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Ensure admin can only access their own buildings.
     *
     * @param Building $building
     */
    private function authorizeBuilding(Building $building)
    {
        abort_if($building->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }

    /**
     * Generate floor label based on floor number.
     *
     * @param int $n
     * @return string
     */
    private function floorLabel(int $n): string
    {
        return match($n) {
            1 => 'Ground Floor',
            2 => '1st Floor',
            3 => '2nd Floor',
            4 => '3rd Floor',
            default => ($n - 1) . 'th Floor',
        };
    }
}