@extends('layouts.app')

@section('title', 'My Flats')
@section('page-title', 'My Flats')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">My Flats</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">My Flats</h3>
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
                    <th>Tenant</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flats as $flat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $flat->building->name ?? '—' }}</td>
                    <td>{{ $flat->floor->floor_name ?? '—' }}</td>
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
                    <td>{{ $flat->tenant->name ?? '—' }}</td>
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