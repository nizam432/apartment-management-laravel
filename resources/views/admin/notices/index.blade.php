@extends('layouts.app')

@section('title', 'Notices')
@section('page-title', 'Notice Board')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Notices</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Notices</h3>
        <div class="card-tools">
            <a href="{{ route('admin.notices.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Notice
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Building</th>
                    <th>Target</th>
                    <th>Expire Date</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notices as $notice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::limit($notice->title, 40) }}</td>
                    <td>{{ $notice->building->name ?? 'All Buildings' }}</td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($notice->target) }}</span>
                    </td>
                    <td>
                        @if($notice->expire_date)
                            @if($notice->expire_date->isPast())
                                <span class="badge badge-danger">Expired</span>
                            @else
                                {{ $notice->expire_date->format('d M Y') }}
                            @endif
                        @else
                            <span class="badge badge-secondary">No Expiry</span>
                        @endif
                    </td>
                    <td>{{ $notice->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.notices.edit', $notice->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.notices.destroy', $notice->id) }}"
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
                    <td colspan="7" class="text-center">No notices found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $notices->links() }}
    </div>
</div>
@endsection