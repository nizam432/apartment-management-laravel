@extends('layouts.app')

@section('title', 'Complaints')
@section('page-title', 'My Complaints')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Complaints</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">My Complaints</h3>
        <div class="card-tools">
            <a href="{{ route('tenant.complaints.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Submit Complaint
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Admin Note</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $complaint)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::limit($complaint->subject, 40) }}</td>
                    <td>
                        @if($complaint->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($complaint->status === 'in_progress')
                            <span class="badge badge-info">In Progress</span>
                        @else
                            <span class="badge badge-success">Resolved</span>
                        @endif
                    </td>
                    <td>{{ $complaint->admin_note ?? '—' }}</td>
                    <td>{{ $complaint->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No complaints found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $complaints->links() }}
    </div>
</div>
@endsection