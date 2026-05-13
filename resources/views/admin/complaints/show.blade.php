@extends('layouts.app')

@section('title', 'Complaint Details')
@section('page-title', 'Complaint Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.complaints.index') }}">Complaints</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $complaint->subject }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><b>Tenant</b></td>
                        <td>{{ $complaint->tenant->name }} ({{ $complaint->tenant->phone }})</td>
                    </tr>
                    <tr>
                        <td><b>Building</b></td>
                        <td>{{ $complaint->building->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Flat</b></td>
                        <td>{{ $complaint->flat->flat_number }}</td>
                    </tr>
                    <tr>
                        <td><b>Date</b></td>
                        <td>{{ $complaint->created_at->format('d M Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <td><b>Status</b></td>
                        <td>
                            @if($complaint->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($complaint->status === 'in_progress')
                                <span class="badge badge-info">In Progress</span>
                            @else
                                <span class="badge badge-success">Resolved</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="mt-3">
                    <h6><b>Description:</b></h6>
                    <p class="text-muted">{{ $complaint->description }}</p>
                </div>

                @if($complaint->admin_note)
                <div class="mt-3">
                    <h6><b>Admin Note:</b></h6>
                    <p class="text-muted">{{ $complaint->admin_note }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Update Status --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Admin Note <small class="text-muted">(Optional)</small></label>
                        <textarea name="admin_note" rows="3" class="form-control"
                            placeholder="Add a note...">{{ $complaint->admin_note }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection