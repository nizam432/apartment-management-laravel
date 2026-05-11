@extends('layouts.app')

@section('title', 'Building Details')
@section('page-title', 'Building Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.buildings.index') }}">Buildings</a></li>
    <li class="breadcrumb-item active">{{ $building->name }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Building Info --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                @if($building->image)
                    <img src="{{ asset('storage/' . $building->image) }}"
                         alt="Building" class="img-fluid rounded mb-3">
                @else
                    <div class="text-center mb-3">
                        <i class="fas fa-building fa-5x text-muted"></i>
                    </div>
                @endif

                <h3 class="profile-username text-center">{{ $building->name }}</h3>
                <p class="text-muted text-center">{{ $building->city }}{{ $building->area ? ', ' . $building->area : '' }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Address</b>
                        <span class="float-right">{{ $building->address }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Total Floors</b>
                        <span class="float-right">{{ $building->total_floors }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Electricity</b>
                        <span class="float-right">
                            <span class="badge {{ $building->electricity_type === 'prepaid' ? 'badge-info' : 'badge-warning' }}">
                                {{ ucfirst($building->electricity_type) }}
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Water Bill</b>
                        <span class="float-right">
                            @if($building->water_bill_applicable)
                                <span class="badge badge-success">৳{{ $building->water_bill_amount }}</span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">
                            <span class="badge {{ $building->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($building->status) }}
                            </span>
                        </span>
                    </li>
                </ul>

                <a href="{{ route('admin.buildings.edit', $building->id) }}" class="btn btn-info btn-block">
                    <i class="fas fa-edit mr-1"></i> Edit Building
                </a>
            </div>
        </div>
    </div>

    {{-- Floors --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Floors & Units</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Floor</th>
                            <th>Total Units</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($floors as $floor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $floor->floor_name ?? 'Floor ' . $floor->floor_number }}</td>
                            <td>{{ $floor->flats_count }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> View Flats
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No floors found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection