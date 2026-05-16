@extends('layouts.app')

@section('title', 'Move Out Receipt')
@section('page-title', 'Move Out Receipt')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item active">Move Out Receipt</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="card" id="receipt-card">
            {{-- Receipt Header --}}
            <div class="card-header bg-success text-white text-center py-4">
                <h3 class="mb-1"><i class="fas fa-file-alt mr-2"></i>Security Deposit Return Receipt</h3>
                <p class="mb-0">{{ $record->building->name }}</p>
            </div>

            <div class="card-body p-4">

                {{-- Tenant & Flat Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-2">Tenant Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="font-weight-bold" style="width:45%">Name</td>
                                <td>{{ $tenant->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Phone</td>
                                <td>{{ $tenant->phone }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Move In</td>
                                <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Move Out</td>
                                <td>{{ $record->move_out_date->format('d M Y') }}</td>
                            </tr>
                            @if($record->reason)
                            <tr>
                                <td class="font-weight-bold">Reason</td>
                                <td>{{ $record->reason }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-2">Property Information</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="font-weight-bold" style="width:45%">Building</td>
                                <td>{{ $record->building->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Floor</td>
                                <td>{{ $record->floor->floor_name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Flat</td>
                                <td>{{ $record->flat->flat_number }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Processed By</td>
                                <td>{{ $record->createdBy->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Date</td>
                                <td>{{ $record->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                {{-- Security Deposit Summary --}}
                <h6 class="text-muted text-uppercase mb-3">Security Deposit Summary</h6>
                <table class="table table-bordered">
                    <tr class="table-light">
                        <td class="font-weight-bold">Advance / Security Deposit Paid</td>
                        <td class="text-right font-weight-bold text-dark">
                            BDT {{ number_format($record->advance_paid, 2) }}
                        </td>
                    </tr>
                    <tr class="table-danger">
                        <td class="font-weight-bold">
                            Deduction
                            @if($record->deduction_reason)
                                <br><small class="text-muted font-weight-normal">{{ $record->deduction_reason }}</small>
                            @endif
                        </td>
                        <td class="text-right font-weight-bold text-danger">
                            - BDT {{ number_format($record->deduction, 2) }}
                        </td>
                    </tr>
                    <tr class="table-success">
                        <td class="font-weight-bold h5 mb-0">Amount Returned to Tenant</td>
                        <td class="text-right font-weight-bold h5 mb-0 text-success">
                            BDT {{ number_format($record->amount_returned, 2) }}
                        </td>
                    </tr>
                </table>

                {{-- Note --}}
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle mr-2"></i>
                    This receipt confirms that the security deposit has been settled between the tenant and management.
                </div>

            </div>

            {{-- Footer --}}
            <div class="card-footer text-muted text-center">
                <small>Generated on {{ now()->format('d M Y, h:i A') }}</small>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-3 d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary mr-2">
                <i class="fas fa-print mr-1"></i> Print Receipt
            </button>
            <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Tenants
            </a>
        </div>

    </div>
</div>

{{-- Print Style --}}
<style>
    @media print {
        .btn, .alert-dismissible, .breadcrumb, .main-header, .main-sidebar, .content-header, #receipt-card + div {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
        }
        #receipt-card {
            border: none;
            box-shadow: none;
        }
    }
</style>
@endsection