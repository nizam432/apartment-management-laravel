@extends('layouts.app')

@section('title', 'Tenants')
@section('page-title', 'Tenant Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tenants</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Tenants</h3>
        <div class="card-tools">
            <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Tenant
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
                    <th>Building</th>
                    <th>Flat</th>
                    <th>Rent</th>
                    <th>Move In</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($tenant->picture)
                            <img src="{{ asset('storage/' . $tenant->picture) }}"
                                 alt="{{ $tenant->name }}" width="40" height="40"
                                 class="rounded-circle">
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
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm">
                                {{-- View --}}
                                <a href="{{ route('admin.tenants.show', $tenant->id) }}" class="dropdown-item">
                                    <i class="fas fa-eye mr-2 text-secondary"></i> View
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="dropdown-item">
                                    <i class="fas fa-edit mr-2 text-info"></i> Edit
                                </a>

                                {{-- Rent History --}}
                                <a href="{{ route('admin.rent-amount-history.index', $tenant->id) }}" class="dropdown-item">
                                    <i class="fas fa-history mr-2 text-warning"></i> Rent History
                                </a>

                                @if($tenant->status === 'active')
                                <div class="dropdown-divider"></div>

                                {{-- Transfer Flat --}}
                                <a href="{{ route('admin.tenants.transfer', $tenant->id) }}" class="dropdown-item">
                                    <i class="fas fa-exchange-alt mr-2 text-primary"></i> Transfer Flat
                                </a>

                                {{-- Move Out --}}
                                <a href="{{ route('admin.tenants.move-out', $tenant->id) }}" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt mr-2 text-danger"></i> Move Out
                                </a>

                                <div class="dropdown-divider"></div>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('admin.tenants.destroy', $tenant->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to remove this tenant?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No tenants found.</td>
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