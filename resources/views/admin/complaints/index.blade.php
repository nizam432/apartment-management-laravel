@extends('layouts.app')

@section('title', 'Complaints')
@section('page-title', 'Complaint Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Complaints</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Complaints</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tenant</th>
                    <th>Building</th>
                    <th>Flat</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $complaint)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $complaint->tenant->name }}</td>
                    <td>{{ $complaint->building->name }}</td>
                    <td>{{ $complaint->flat->flat_number }}</td>
                    <td>{{ Str::limit($complaint->subject, 30) }}</td>
                    <td>
                        @if($complaint->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($complaint->status === 'in_progress')
                            <span class="badge badge-info">In Progress</span>
                        @else
                            <span class="badge badge-success">Resolved</span>
                        @endif
                    </td>
                    <td>{{ $complaint->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.complaints.destroy', $complaint->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No complaints found.</td>
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