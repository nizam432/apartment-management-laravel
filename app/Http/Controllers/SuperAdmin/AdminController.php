<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * Class AdminController
 *
 * Handles Admin management for Super Admin panel.
 * Includes create, update, delete and status toggle functionality.
 *
 * @package App\Http\Controllers\SuperAdmin
 */
class AdminController extends Controller
{
    /**
     * Display a paginated list of all admins.
     * Paginate: 10 per page
     */
    public function index()
    {
        $admins = User::role('admin')->latest()->paginate(10);
        return view('super-admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('super-admin.admins.create');
    }

    /**
     * Store a newly created admin in the database.
     * Assigns the 'admin' role after creation.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'required|string|unique:users,phone',
            'email'    => 'nullable|email|unique:users,email',
            'username' => 'nullable|string|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Assign admin role
        $user->assignRole('admin');

        return redirect()->route('super-admin.admins.index')
                         ->with('success', 'Admin created successfully!');
    }

    /**
     * Show the form for editing an existing admin.
     *
     * @param User $admin
     */
    public function edit(User $admin)
    {
        return view('super-admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in the database.
     * Password will only be updated if provided.
     *
     * @param Request $request
     * @param User $admin
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'required|string|unique:users,phone,' . $admin->id,
            'email'    => 'nullable|email|unique:users,email,' . $admin->id,
            'username' => 'nullable|string|unique:users,username,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'username' => $request->username,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('super-admin.admins.index')
                         ->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified admin from the database.
     *
     * @param User $admin
     */
    public function destroy(User $admin)
    {
        $admin->delete();
        return back()->with('success', 'Admin deleted successfully.');
    }

    /**
     * Toggle the active/inactive status of the specified admin.
     *
     * @param User $admin
     */
    public function toggleStatus(User $admin)
    {
        $admin->update(['is_active' => !$admin->is_active]);
        return back()->with('success', 'Status updated successfully.');
    }
}