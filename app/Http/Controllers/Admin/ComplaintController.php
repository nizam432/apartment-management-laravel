<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ComplaintController
 *
 * Handles complaint management for Admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class ComplaintController extends Controller
{
    /**
     * Display a paginated list of all complaints.
     */
    public function index()
    {
        $complaints = Complaint::where('admin_id', Auth::id())
                               ->with(['building', 'flat', 'tenant'])
                               ->latest()
                               ->paginate(15);

        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Show complaint details.
     *
     * @param Complaint $complaint
     */
    public function show(Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Update complaint status and admin note.
     *
     * @param Request $request
     * @param Complaint $complaint
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);

        $request->validate([
            'status'     => 'required|in:pending,in_progress,resolved',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $complaint->update([
            'status'     => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Complaint updated successfully!');
    }

    /**
     * Remove the specified complaint.
     *
     * @param Complaint $complaint
     */
    public function destroy(Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);
        $complaint->delete();
        return back()->with('warning', 'Complaint deleted successfully.');
    }

    /**
     * Ensure admin owns this complaint.
     *
     * @param Complaint $complaint
     */
    private function authorizeComplaint(Complaint $complaint)
    {
        abort_if($complaint->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}