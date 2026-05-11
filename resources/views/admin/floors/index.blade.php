@extends('layouts.app')

@section('title', 'Floors')
@section('page-title', 'Floor Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Floors</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Floors</h3>
        <div class="card-tools">
            <a href="{{ route('admin.floors.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Floor
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Building</th>
                    <th>Floor Number</th>
                    <th>Floor Name</th>
                    <th>Total Units</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($floors as $floor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $floor->building->name }}</td>
                    <td>{{ $floor->floor_number }}</td>
                    <td>{{ $floor->floor_name ?? '—' }}</td>
                    <td>{{ $floor->total_units }}</td>
                    <td>
                        {{-- Edit --}}
                        <a href="{{ route('admin.floors.edit', $floor->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.floors.destroy', $floor->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this floor?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No floors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $floors->links() }}
    </div>
</div>
@endsection