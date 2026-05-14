<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Notice;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * Handles Employee dashboard statistics.
 *
 * @package App\Http\Controllers\Employee
 */
class DashboardController extends Controller
{
    /**
     * Display the Employee dashboard with stats.
     */
    public function index()
    {
        $employee = Employee::where('user_id', Auth::id())->first();

        // If employee record not found redirect
        if (!$employee) {
            return redirect()->route('login')->with('error', 'Employee record not found.');
        }

        $stats = [
            'today_visitors'  => VisitorLog::where('employee_id', $employee->id)
                                           ->whereDate('in_time', today())
                                           ->count(),
            'total_visitors'  => VisitorLog::where('employee_id', $employee->id)->count(),
            'pending_checkout'=> VisitorLog::where('employee_id', $employee->id)
                                           ->whereNull('out_time')
                                           ->count(),
            'total_notices'   => Notice::where(function ($q) use ($employee) {
                                        $q->where('building_id', $employee->building_id)
                                          ->orWhereNull('building_id');
                                    })
                                    ->whereIn('target', ['all', 'employees'])
                                    ->count(),
        ];

        $recentVisitors = VisitorLog::where('employee_id', $employee->id)
                                    ->with(['flat', 'tenant'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('employee.dashboard', compact('employee', 'stats', 'recentVisitors'));
    }
}