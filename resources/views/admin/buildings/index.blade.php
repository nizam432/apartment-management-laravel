@extends('layouts.app')

@section('title', 'Buildings')
@section('page-title', 'Building Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Buildings</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Buildings</h3>
        <div class="card-tools">
            <a href="{{ route('admin.buildings.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Building
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Floors</th>
                    <th>Electricity</th>
                    <th>Water Bill</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buildings as $building)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $building->name }}</td>
                    <td>{{ $building->address }}</td>
                    <td>{{ $building->city }}</td>
                    <td>{{ $building->total_floors }}</td>
                    <td>
                        <span class="badge {{ $building->electricity_type === 'prepaid' ? 'badge-info' : 'badge-warning' }}">
                            {{ ucfirst($building->electricity_type) }}
                        </span>
                    </td>
                    <td>
                        @if($building->water_bill_applicable)
                            <span class="badge badge-success">Yes — ৳{{ $building->water_bill_amount }}</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        @if($building->status === 'active')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        {{-- View --}}
                        <a href="{{ route('admin.buildings.show', $building->id) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.buildings.edit', $building->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Toggle Status --}}
                        <form action="{{ route('admin.buildings.toggle-status', $building->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="btn btn-sm {{ $building->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $building->status === 'active' ? 'ban' : 'check' }}"></i>
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('admin.buildings.destroy', $building->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this building?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No buildings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $buildings->links() }}
    </div>
</div>
@endsection