<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Employee;
use App\Models\Flat;
use App\Models\Tenant;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class VisitorLogController
 *
 * Handles visitor log management for Admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class VisitorLogController extends Controller
{
    /**
     * Display a paginated list of visitor logs.
     */
    public function index()
    {
        $logs = VisitorLog::where('admin_id', Auth::id())
                          ->with(['building', 'flat', 'tenant', 'employee'])
                          ->latest()
                          ->paginate(15);

        return view('admin.visitor-logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new visitor log.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        $employees = Employee::where('admin_id', Auth::id())
                             ->where('employment_status', 'active')
                             ->get();
        return view('admin.visitor-logs.create', compact('buildings', 'employees'));
    }

    /**
     * Store a newly created visitor log.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'   => 'required|exists:buildings,id',
            'flat_id'       => 'required|exists:flats,id',
            'tenant_id'     => 'required|exists:tenants,id',
            'visitor_name'  => 'required|string|max:100',
            'visitor_phone' => 'nullable|string|max:20',
            'purpose'       => 'nullable|string|max:200',
            'in_time'       => 'required|date',
            'out_time'      => 'nullable|date|after:in_time',
            'employee_id'   => 'nullable|exists:employees,id',
            'note'          => 'nullable|string|max:500',
        ]);

        VisitorLog::create([
            ...$request->all(),
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.visitor-logs.index')
                         ->with('success', 'Visitor log created successfully!');
    }

    /**
     * Update out_time of a visitor log.
     *
     * @param Request $request
     * @param VisitorLog $visitorLog
     */
    public function update(Request $request, VisitorLog $visitorLog)
    {
        $this->authorizeLog($visitorLog);

        $request->validate([
            'out_time' => 'required|date|after:in_time',
        ]);

        $visitorLog->update(['out_time' => $request->out_time]);

        return back()->with('success', 'Out time updated successfully!');
    }

    /**
     * Remove the specified visitor log.
     *
     * @param VisitorLog $visitorLog
     */
    public function destroy(VisitorLog $visitorLog)
    {
        $this->authorizeLog($visitorLog);
        $visitorLog->delete();
        return back()->with('warning', 'Visitor log deleted successfully.');
    }

    /**
     * Get tenants for a specific flat as JSON.
     *
     * @param Flat $flat
     */
    public function tenantsByFlat(Flat $flat)
    {
        $tenants = Tenant::where('flat_id', $flat->id)
                         ->where('status', 'active')
                         ->get(['id', 'name', 'phone']);
        return response()->json($tenants);
    }

    /**
     * Ensure admin owns this visitor log.
     *
     * @param VisitorLog $visitorLog
     */
    private function authorizeLog(VisitorLog $visitorLog)
    {
        abort_if($visitorLog->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}