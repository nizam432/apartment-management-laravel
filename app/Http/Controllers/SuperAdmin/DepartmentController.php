<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DepartmentController
 *
 * Handles department management for Super Admin panel.
 * Departments are used when creating employees.
 *
 * @package App\Http\Controllers\SuperAdmin
 */
class DepartmentController extends Controller
{
    /**
     * Display a list of all departments.
     */
    public function index()
    {
        $departments = Department::withCount('employees')->latest()->paginate(15);
        return view('super-admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('super-admin.departments.create');
    }

    /**
     * Store a newly created department in the database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
        ]);

        Department::create([
            'name'       => $request->name,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('super-admin.departments.index')
                         ->with('success', 'Department created successfully!');
    }

    /**
     * Show the form for editing a department.
     *
     * @param Department $department
     */
    public function edit(Department $department)
    {
        return view('super-admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified department in the database.
     *
     * @param Request $request
     * @param Department $department
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:departments,name,' . $department->id,
        ]);

        $department->update(['name' => $request->name]);

        return redirect()->route('super-admin.departments.index')
                         ->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified department from the database.
     *
     * @param Department $department
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return back()->with('warning', 'Department deleted successfully.');
    }
}