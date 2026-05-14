@extends('layouts.app')

@section('title', 'My Flat')
@section('page-title', 'My Flat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">My Flat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-home mr-2"></i>Flat Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><b>Building</b></td>
                        <td>{{ $tenant->building->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Floor</b></td>
                        <td>{{ $tenant->floor->floor_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Flat Number</b></td>
                        <td><b>{{ $tenant->flat->flat_number ?? '—' }}</b></td>
                    </tr>
                    <tr>
                        <td><b>Flat Type</b></td>
                        <td>{{ $tenant->flat->flat_type ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Size</b></td>
                        <td>{{ $tenant->flat->size_sqft ? $tenant->flat->size_sqft . ' sqft' : '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Electricity</b></td>
                        <td>
                            <span class="badge {{ $tenant->flat->electricity_type === 'prepaid' ? 'badge-info' : 'badge-warning' }}">
                                {{ ucfirst($tenant->flat->electricity_type ?? '—') }}
                            </span>
                            @if($tenant->flat->electricity_meter_no)
                                <small class="text-muted">(Meter: {{ $tenant->flat->electricity_meter_no }})</small>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Water Bill</b></td>
                        <td>
                            @if($tenant->flat->water_bill_applicable)
                                <span class="badge badge-success">৳{{ $tenant->flat->water_bill_amount }}/month</span>
                            @else
                                <span class="badge badge-secondary">Not Applicable</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-contract mr-2"></i>Rent Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><b>Monthly Rent</b></td>
                        <td><b class="text-primary">৳{{ number_format($tenant->monthly_rent) }}</b></td>
                    </tr>
                    <tr>
                        <td><b>Advance Paid</b></td>
                        <td>৳{{ number_format($tenant->advance_amount) }}</td>
                    </tr>
                    <tr>
                        <td><b>Move In Date</b></td>
                        <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td><b>Address</b></td>
                        <td>{{ $tenant->building->address ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>City</b></td>
                        <td>{{ $tenant->building->city ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection