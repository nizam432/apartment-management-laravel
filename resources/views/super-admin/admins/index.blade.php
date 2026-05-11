@extends('layouts.app')

@section('title', 'Admin List')
@section('page-title', 'Admin Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Admins</li>
@endsection


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Admins</h3>
        <div class="card-tools">
            <a href="{{ route('super-admin.admins.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Admin
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->phone }}</td>
                    <td>{{ $admin->email ?? '—' }}</td>
                    <td>
                        @if($admin->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $admin->created_at->format('d M Y') }}</td>
                    <td>
                        {{-- Edit --}}
                        <a href="{{ route('super-admin.admins.edit', $admin->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Toggle Status --}}
                        <form action="{{ route('super-admin.admins.toggle-status', $admin->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="btn btn-sm {{ $admin->is_active ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $admin->is_active ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('super-admin.admins.destroy', $admin->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this admin?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No admins found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $admins->links() }}
    </div>
</div>
@endsection