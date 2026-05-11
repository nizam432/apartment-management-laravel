<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\User;
use App\Models\Flat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class OwnerController
 *
 * Handles owner management for Admin panel.
 * Admin can create owners and assign flats to them.
 *
 * @package App\Http\Controllers\Admin
 */
class OwnerController extends Controller
{
    /**
     * Display a paginated list of all owners for admin's buildings.
     */
    public function index()
    {
        $owners = Owner::where('admin_id', Auth::id())
                       ->with('user')
                       ->latest()
                       ->paginate(15);

        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new owner.
     */
    public function create()
    {
        return view('admin.owners.create');
    }

    /**
     * Store a newly created owner in the database.
     * Creates a user account and assigns the owner role.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:100',
            'phone'           => 'required|string|unique:users,phone',
            'email'           => 'nullable|email|unique:users,email',
            'password'        => 'required|string|min:6|confirmed',
            'nid_number'      => 'nullable|string|max:20',
            'present_address' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'payment_info'    => 'nullable|string|max:500',
            'notes'           => 'nullable|string|max:500',
            'nid_front'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nid_back'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'picture'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Create user account
        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign owner role
        $user->assignRole('owner');

        $data = [
            'user_id'          => $user->id,
            'admin_id'         => Auth::id(),
            'nid_number'       => $request->nid_number,
            'present_address'  => $request->present_address,
            'permanent_address'=> $request->permanent_address,
            'payment_info'     => $request->payment_info,
            'notes'            => $request->notes,
        ];

        // Upload files
        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('owners/pictures', 'public');
        }
        if ($request->hasFile('nid_front')) {
            $data['nid_front'] = $request->file('nid_front')->store('owners/nid', 'public');
        }
        if ($request->hasFile('nid_back')) {
            $data['nid_back'] = $request->file('nid_back')->store('owners/nid', 'public');
        }

        Owner::create($data);

        return redirect()->route('admin.owners.index')
                         ->with('success', 'Owner created successfully!');
    }

    /**
     * Show owner details.
     *
     * @param Owner $owner
     */
    public function show(Owner $owner)
    {
        $this->authorizeOwner($owner);
        $flats = Flat::where('owner_id', $owner->user_id)
                     ->with(['building', 'floor'])
                     ->get();
        return view('admin.owners.show', compact('owner', 'flats'));
    }

    /**
     * Show the form for editing an owner.
     *
     * @param Owner $owner
     */
    public function edit(Owner $owner)
    {
        $this->authorizeOwner($owner);
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified owner in the database.
     *
     * @param Request $request
     * @param Owner $owner
     */
    public function update(Request $request, Owner $owner)
    {
        $this->authorizeOwner($owner);

        $request->validate([
            'name'             => 'required|string|max:100',
            'phone'            => 'required|string|unique:users,phone,' . $owner->user_id,
            'email'            => 'nullable|email|unique:users,email,' . $owner->user_id,
            'password'         => 'nullable|string|min:6|confirmed',
            'nid_number'       => 'nullable|string|max:20',
            'present_address'  => 'nullable|string|max:255',
            'permanent_address'=> 'nullable|string|max:255',
            'payment_info'     => 'nullable|string|max:500',
            'notes'            => 'nullable|string|max:500',
            'nid_front'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nid_back'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'picture'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user account
        $userData = [
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $owner->user->update($userData);

        $data = [
            'nid_number'       => $request->nid_number,
            'present_address'  => $request->present_address,
            'permanent_address'=> $request->permanent_address,
            'payment_info'     => $request->payment_info,
            'notes'            => $request->notes,
        ];

        // Upload new files
        if ($request->hasFile('picture')) {
            if ($owner->picture) Storage::disk('public')->delete($owner->picture);
            $data['picture'] = $request->file('picture')->store('owners/pictures', 'public');
        }
        if ($request->hasFile('nid_front')) {
            if ($owner->nid_front) Storage::disk('public')->delete($owner->nid_front);
            $data['nid_front'] = $request->file('nid_front')->store('owners/nid', 'public');
        }
        if ($request->hasFile('nid_back')) {
            if ($owner->nid_back) Storage::disk('public')->delete($owner->nid_back);
            $data['nid_back'] = $request->file('nid_back')->store('owners/nid', 'public');
        }

        $owner->update($data);

        return redirect()->route('admin.owners.index')
                         ->with('success', 'Owner updated successfully!');
    }

    /**
     * Remove the specified owner (soft delete).
     *
     * @param Owner $owner
     */
    public function destroy(Owner $owner)
    {
        $this->authorizeOwner($owner);
        $owner->user->delete();
        $owner->delete();
        return back()->with('warning', 'Owner deleted successfully.');
    }

    /**
     * Toggle owner active/inactive status.
     *
     * @param Owner $owner
     */
    public function toggleStatus(Owner $owner)
    {
        $this->authorizeOwner($owner);
        $owner->update(['status' => $owner->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Ensure admin owns this owner record.
     *
     * @param Owner $owner
     */
    private function authorizeOwner(Owner $owner)
    {
        abort_if($owner->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}