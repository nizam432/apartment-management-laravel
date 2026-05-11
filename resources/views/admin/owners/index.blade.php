@extends('layouts.app')

@section('title', 'Owners')
@section('page-title', 'Owner Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Owners</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Owners</h3>
        <div class="card-tools">
            <a href="{{ route('admin.owners.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Owner
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>NID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($owners as $owner)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($owner->picture)
                            <img src="{{ asset('storage/' . $owner->picture) }}"
                                 alt="{{ $owner->user->name }}" width="40" height="40"
                                 class="rounded-circle">
                        @else
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $owner->user->name }}</td>
                    <td>{{ $owner->user->phone }}</td>
                    <td>{{ $owner->user->email ?? '—' }}</td>
                    <td>{{ $owner->nid_number ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $owner->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($owner->status) }}
                        </span>
                    </td>
                    <td>
                        {{-- View --}}
                        <a href="{{ route('admin.owners.show', $owner->id) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.owners.edit', $owner->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Toggle Status --}}
                        <form action="{{ route('admin.owners.toggle-status', $owner->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="btn btn-sm {{ $owner->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $owner->status === 'active' ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('admin.owners.destroy', $owner->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this owner?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No owners found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $owners->links() }}
    </div>
</div>
@endsection