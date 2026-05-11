<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class FloorController
 *
 * Handles floor management for Admin panel.
 * Admin selects building from dropdown when creating/editing floors.
 *
 * @package App\Http\Controllers\Admin
 */
class FloorController extends Controller
{
    /**
     * Return floors for a specific building as JSON (for dropdown).
     *
     * @param Building $building
     */
    public function byBuilding(Building $building)
    {
        abort_if($building->admin_id !== Auth::id(), 403);
        $floors = Floor::where('building_id', $building->id)->get();
        return response()->json($floors);
    }

    /**
     * Display a paginated list of all floors for admin's buildings.
     */
    public function index()
    {
        $floors = Floor::whereHas('building', fn($q) => $q->where('admin_id', Auth::id()))
                       ->with('building')
                       ->latest()
                       ->paginate(15);

        return view('admin.floors.index', compact('floors'));
    }

    /**
     * Show the form for creating a new floor.
     * Loads admin's buildings for dropdown.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.floors.create', compact('buildings'));
    }

    /**
     * Store a newly created floor in the database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'  => 'required|exists:buildings,id',
            'floor_number' => 'required|integer|min:0',
            'floor_name'   => 'nullable|string|max:50',
        ]);

        // Check admin owns this building
        $building = Building::where('id', $request->building_id)
                            ->where('admin_id', Auth::id())
                            ->firstOrFail();

        // Check duplicate floor number in same building
        $exists = Floor::where('building_id', $request->building_id)
                       ->where('floor_number', $request->floor_number)
                       ->exists();

        if ($exists) {
            return back()->withErrors(['floor_number' => 'This floor number already exists in this building.'])
                         ->withInput();
        }

        Floor::create([
            'building_id'  => $request->building_id,
            'floor_number' => $request->floor_number,
            'floor_name'   => $request->floor_name ?? $this->floorLabel($request->floor_number),
        ]);

        return redirect()->route('admin.floors.index')
                         ->with('success', 'Floor created successfully!');
    }

    /**
     * Show the form for editing a floor.
     *
     * @param Floor $floor
     */
    public function edit(Floor $floor)
    {
        $this->authorizeFloor($floor);
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.floors.edit', compact('floor', 'buildings'));
    }

    /**
     * Update the specified floor in the database.
     *
     * @param Request $request
     * @param Floor $floor
     */
    public function update(Request $request, Floor $floor)
    {
        $this->authorizeFloor($floor);

        $request->validate([
            'floor_number' => 'required|integer|min:0',
            'floor_name'   => 'nullable|string|max:50',
        ]);

        $floor->update([
            'floor_number' => $request->floor_number,
            'floor_name'   => $request->floor_name,
        ]);

        return redirect()->route('admin.floors.index')
                         ->with('success', 'Floor updated successfully!');
    }

    /**
     * Remove the specified floor from the database.
     *
     * @param Floor $floor
     */
    public function destroy(Floor $floor)
    {
        $this->authorizeFloor($floor);
        $floor->delete();
        return back()->with('warning', 'Floor deleted successfully.');
    }

    /**
     * Ensure admin owns the building this floor belongs to.
     *
     * @param Floor $floor
     */
    private function authorizeFloor(Floor $floor)
    {
        abort_if($floor->building->admin_id !== Auth::id(), 403, 'Unauthorized access.');
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
            0 => 'Ground Floor',
            1 => '1st Floor',
            2 => '2nd Floor',
            3 => '3rd Floor',
            default => $n . 'th Floor',
        };
    }
}