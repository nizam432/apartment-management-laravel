@extends('layouts.app')

@section('title', 'Visitor Log')
@section('page-title', 'Visitor Log')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Visitor Log</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Visitor Log</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Visitor Name</th>
                    <th>Phone</th>
                    <th>Flat</th>
                    <th>Tenant</th>
                    <th>Purpose</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->visitor_name }}</td>
                    <td>{{ $log->visitor_phone ?? '—' }}</td>
                    <td>{{ $log->flat->flat_number }}</td>
                    <td>{{ $log->tenant->name }}</td>
                    <td>{{ $log->purpose ?? '—' }}</td>
                    <td>{{ $log->in_time->format('d M Y h:i A') }}</td>
                    <td>{{ $log->out_time ? $log->out_time->format('d M Y h:i A') : '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No visitor logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $logs->links() }}
    </div>
</div>
@endsection