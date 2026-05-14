<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileController
 *
 * Handles Owner profile management.
 *
 * @package App\Http\Controllers\Owner
 */
class ProfileController extends Controller
{
    /**
     * Display owner profile.
     */
    public function index()
    {
        $user  = Auth::user();
        $owner = $user->owner;
        return view('owner.profile', compact('user', 'owner'));
    }

    /**
     * Update owner profile.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'phone'    => 'required|string|unique:users,phone,' . $user->id,
            'email'    => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}