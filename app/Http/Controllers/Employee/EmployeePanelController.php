<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Flat;
use App\Models\Notice;
use App\Models\Tenant;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class EmployeePanelController
 *
 * Handles Employee panel views and actions.
 *
 * @package App\Http\Controllers\Employee
 */
class EmployeePanelController extends Controller
{
    /**
     * Get current employee record.
     */
    private function getEmployee()
    {
        return Employee::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Display visitor logs entered by this employee.
     */
    public function visitorLogs()
    {
        $employee = $this->getEmployee();

        $logs = VisitorLog::where('employee_id', $employee->id)
                          ->with(['building', 'flat', 'tenant'])
                          ->latest()
                          ->paginate(15);

        return view('employee.visitor-logs', compact('logs', 'employee'));
    }

    /**
     * Show the form for creating a new visitor log.
     */
    public function createVisitorLog()
    {
        $employee = $this->getEmployee();
        $flats    = Flat::where('building_id', $employee->building_id)
                        ->where('status', 'occupied')
                        ->with('floor')
                        ->get();

        return view('employee.visitor-log-create', compact('employee', 'flats'));
    }

    /**
     * Store a newly created visitor log.
     *
     * @param Request $request
     */
    public function storeVisitorLog(Request $request)
    {
        $employee = $this->getEmployee();

        $request->validate([
            'flat_id'       => 'required|exists:flats,id',
            'tenant_id'     => 'required|exists:tenants,id',
            'visitor_name'  => 'required|string|max:100',
            'visitor_phone' => 'nullable|string|max:20',
            'purpose'       => 'nullable|string|max:200',
            'in_time'       => 'required|date',
            'note'          => 'nullable|string|max:500',
        ]);

        VisitorLog::create([
            'admin_id'      => $employee->admin_id,
            'building_id'   => $employee->building_id,
            'flat_id'       => $request->flat_id,
            'tenant_id'     => $request->tenant_id,
            'employee_id'   => $employee->id,
            'visitor_name'  => $request->visitor_name,
            'visitor_phone' => $request->visitor_phone,
            'purpose'       => $request->purpose,
            'in_time'       => $request->in_time,
            'note'          => $request->note,
        ]);

        return redirect()->route('employee.visitor-logs')
                         ->with('success', 'Visitor log created successfully!');
    }

    /**
     * Mark visitor checkout time.
     *
     * @param VisitorLog $visitorLog
     */
    public function checkout(VisitorLog $visitorLog)
    {
        $employee = $this->getEmployee();
        abort_if($visitorLog->employee_id !== $employee->id, 403);

        $visitorLog->update(['out_time' => now()]);

        return back()->with('success', 'Visitor checked out successfully!');
    }

    /**
     * Display notices for this employee's building.
     */
    public function notices()
    {
        $employee = $this->getEmployee();

        $notices = Notice::where(function ($q) use ($employee) {
                        $q->where('building_id', $employee->building_id)
                          ->orWhereNull('building_id');
                    })
                    ->where(function ($q) {
                        $q->whereNull('expire_date')
                          ->orWhere('expire_date', '>=', now());
                    })
                    ->whereIn('target', ['all', 'employees'])
                    ->latest()
                    ->paginate(15);

        return view('employee.notices', compact('notices'));
    }
}