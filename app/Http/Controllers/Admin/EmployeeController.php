<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Class EmployeeController
 *
 * Handles employee management for Admin panel.
 * Admin can only manage employees in their own buildings.
 *
 * @package App\Http\Controllers\Admin
 */
class EmployeeController extends Controller
{
    /**
     * Display a paginated list of all employees.
     */
    public function index()
    {
        $employees = Employee::where('admin_id', Auth::id())
                             ->with(['building', 'department'])
                             ->latest()
                             ->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $buildings   = Building::where('admin_id', Auth::id())->get();
        $departments = Department::all();
        return view('admin.employees.create', compact('buildings', 'departments'));
    }

    /**
     * Store a newly created employee in the database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id'             => 'required|exists:buildings,id',
            'department_id'           => 'required|exists:departments,id',
            'name'                    => 'required|string|max:100',
            'phone'                   => 'required|string|max:20',
            'email'                   => 'nullable|email|max:100',
            'designation'             => 'required|string|max:100',
            'salary'                  => 'required|numeric|min:0',
            'join_date'               => 'required|date',
            'work_shift'              => 'nullable|in:morning,evening,night',
            'employment_status'       => 'required|in:active,resigned,terminated',
            'nid_number'              => 'nullable|string|max:20',
            'present_address'         => 'nullable|string|max:255',
            'permanent_address'       => 'nullable|string|max:255',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'payment_info'            => 'nullable|string|max:500',
            'photo'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'documents.*'             => 'nullable|file|max:5120',
            'document_names.*'        => 'nullable|string|max:100',
        ]);

        // Check admin owns this building
        Building::where('id', $request->building_id)
                ->where('admin_id', Auth::id())
                ->firstOrFail();

        $data             = $request->except(['photo', 'documents', 'document_names']);
        $data['admin_id'] = Auth::id();
        $data['employee_code'] = Employee::generateCode();

        // Upload photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee = Employee::create($data);

        // Upload extra documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $employee->documents()->create([
                    'document_name' => $request->document_names[$index] ?? $file->getClientOriginalName(),
                    'file_path'     => $file->store('employees/documents', 'public'),
                ]);
            }
        }

        return redirect()->route('admin.employees.index')
                         ->with('success', 'Employee created successfully!');
    }

    /**
     * Show employee details.
     *
     * @param Employee $employee
     */
    public function show(Employee $employee)
    {
        $this->authorizeEmployee($employee);
        $documents = $employee->documents;
        return view('admin.employees.show', compact('employee', 'documents'));
    }

    /**
     * Show the form for editing an employee.
     *
     * @param Employee $employee
     */
    public function edit(Employee $employee)
    {
        $this->authorizeEmployee($employee);
        $buildings   = Building::where('admin_id', Auth::id())->get();
        $departments = Department::all();
        return view('admin.employees.edit', compact('employee', 'buildings', 'departments'));
    }

    /**
     * Update the specified employee in the database.
     *
     * @param Request $request
     * @param Employee $employee
     */
    public function update(Request $request, Employee $employee)
    {
        $this->authorizeEmployee($employee);

        $request->validate([
            'building_id'             => 'required|exists:buildings,id',
            'department_id'           => 'required|exists:departments,id',
            'name'                    => 'required|string|max:100',
            'phone'                   => 'required|string|max:20',
            'email'                   => 'nullable|email|max:100',
            'designation'             => 'required|string|max:100',
            'salary'                  => 'required|numeric|min:0',
            'join_date'               => 'required|date',
            'resign_date'             => 'nullable|date',
            'work_shift'              => 'nullable|in:morning,evening,night',
            'employment_status'       => 'required|in:active,resigned,terminated',
            'nid_number'              => 'nullable|string|max:20',
            'present_address'         => 'nullable|string|max:255',
            'permanent_address'       => 'nullable|string|max:255',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'payment_info'            => 'nullable|string|max:500',
            'photo'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'documents.*'             => 'nullable|file|max:5120',
            'document_names.*'        => 'nullable|string|max:100',
        ]);

        $data = $request->except(['photo', 'documents', 'document_names']);

        // Upload new photo
        if ($request->hasFile('photo')) {
            if ($employee->photo) Storage::disk('public')->delete($employee->photo);
            $data['photo'] = $request->file('photo')->store('employees/photos', 'public');
        }

        $employee->update($data);

        // Upload extra documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $employee->documents()->create([
                    'document_name' => $request->document_names[$index] ?? $file->getClientOriginalName(),
                    'file_path'     => $file->store('employees/documents', 'public'),
                ]);
            }
        }

        return redirect()->route('admin.employees.index')
                         ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee (soft delete).
     *
     * @param Employee $employee
     */
    public function destroy(Employee $employee)
    {
        $this->authorizeEmployee($employee);
        $employee->delete();
        return back()->with('warning', 'Employee deleted successfully.');
    }

    /**
     * Delete a specific document of an employee.
     *
     * @param EmployeeDocument $document
     */
    public function deleteDocument(EmployeeDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Document deleted successfully.');
    }

    /**
     * Ensure admin owns the building this employee belongs to.
     *
     * @param Employee $employee
     */
    private function authorizeEmployee(Employee $employee)
    {
        abort_if($employee->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}