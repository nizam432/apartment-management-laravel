@extends('layouts.app')

@section('title', 'Flats')
@section('page-title', 'Flat Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Flats</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Flats</h3>
        <div class="card-tools">
            <a href="{{ route('admin.flats.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Flat
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Building</th>
                    <th>Floor</th>
                    <th>Flat No</th>
                    <th>Type</th>
                    <th>Rent</th>
                    <th>Electricity</th>
                    <th>Water Bill</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flats as $flat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $flat->building->name }}</td>
                    <td>{{ $flat->floor->floor_name ?? 'Floor ' . $flat->floor->floor_number }}</td>
                    <td><b>{{ $flat->flat_number }}</b></td>
                    <td>{{ $flat->flat_type ?? '—' }}</td>
                    <td>৳{{ number_format($flat->rent_amount) }}</td>
                    <td>
                        <span class="badge {{ $flat->electricity_type === 'prepaid' ? 'badge-info' : 'badge-warning' }}">
                            {{ ucfirst($flat->electricity_type) }}
                        </span>
                    </td>
                    <td>
                        @if($flat->water_bill_applicable)
                            <span class="badge badge-success">৳{{ $flat->water_bill_amount }}</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $flat->status === 'vacant' ? 'badge-warning' : 'badge-success' }}">
                            {{ ucfirst($flat->status) }}
                        </span>
                    </td>
                    <td>
                        {{-- Edit --}}
                        <a href="{{ route('admin.flats.edit', $flat->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.flats.destroy', $flat->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this flat?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No flats found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $flats->links() }}
    </div>
</div>
@endsection