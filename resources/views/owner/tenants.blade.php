@extends('layouts.app')

@section('title', 'Tenants')
@section('page-title', 'My Tenants')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tenants</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">My Tenants</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Building</th>
                    <th>Flat</th>
                    <th>Rent</th>
                    <th>Move In</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($tenant->picture)
                            <img src="{{ asset('storage/' . $tenant->picture) }}"
                                 width="40" height="40" class="rounded-circle">
                        @else
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $tenant->name }}</td>
                    <td>{{ $tenant->phone }}</td>
                    <td>{{ $tenant->building->name ?? '—' }}</td>
                    <td>{{ $tenant->flat->flat_number ?? '—' }}</td>
                    <td>৳{{ number_format($tenant->monthly_rent) }}</td>
                    <td>{{ $tenant->move_in_date?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $tenant->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($tenant->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No tenants found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $tenants->links() }}
    </div>
</div>
@endsection