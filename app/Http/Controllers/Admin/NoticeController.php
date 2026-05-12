<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class NoticeController
 *
 * Handles notice/announcement management for Admin panel.
 *
 * @package App\Http\Controllers\Admin
 */
class NoticeController extends Controller
{
    /**
     * Display a paginated list of notices.
     */
    public function index()
    {
        $notices = Notice::where('admin_id', Auth::id())
                         ->with('building')
                         ->latest()
                         ->paginate(15);

        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new notice.
     */
    public function create()
    {
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.notices.create', compact('buildings'));
    }

    /**
     * Store a newly created notice.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'body'        => 'required|string',
            'target'      => 'required|in:all,tenants,owners,employees',
            'building_id' => 'nullable|exists:buildings,id',
            'expire_date' => 'nullable|date|after:today',
        ]);

        Notice::create([
            ...$request->all(),
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.notices.index')
                         ->with('success', 'Notice created successfully!');
    }

    /**
     * Show the form for editing a notice.
     *
     * @param Notice $notice
     */
    public function edit(Notice $notice)
    {
        $this->authorizeNotice($notice);
        $buildings = Building::where('admin_id', Auth::id())->get();
        return view('admin.notices.edit', compact('notice', 'buildings'));
    }

    /**
     * Update the specified notice.
     *
     * @param Request $request
     * @param Notice $notice
     */
    public function update(Request $request, Notice $notice)
    {
        $this->authorizeNotice($notice);

        $request->validate([
            'title'       => 'required|string|max:200',
            'body'        => 'required|string',
            'target'      => 'required|in:all,tenants,owners,employees',
            'building_id' => 'nullable|exists:buildings,id',
            'expire_date' => 'nullable|date',
        ]);

        $notice->update($request->all());

        return redirect()->route('admin.notices.index')
                         ->with('success', 'Notice updated successfully!');
    }

    /**
     * Remove the specified notice.
     *
     * @param Notice $notice
     */
    public function destroy(Notice $notice)
    {
        $this->authorizeNotice($notice);
        $notice->delete();
        return back()->with('warning', 'Notice deleted successfully.');
    }

    /**
     * Ensure admin owns this notice.
     *
     * @param Notice $notice
     */
    private function authorizeNotice(Notice $notice)
    {
        abort_if($notice->admin_id !== Auth::id(), 403, 'Unauthorized access.');
    }
}