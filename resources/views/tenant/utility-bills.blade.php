@extends('layouts.app')

@section('title', 'Utility Bills')
@section('page-title', 'Utility Bills')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Utility Bills</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Utility Bills</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Month</th>
                    <th>Water</th>
                    <th>Electricity</th>
                    <th>Other</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Paid Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($bill->month . '-01')->format('M Y') }}</td>
                    <td>৳{{ number_format($bill->water_bill) }}</td>
                    <td>
                        ৳{{ number_format($bill->electricity_bill) }}
                        @if($bill->unit_used)
                            <small class="text-muted">({{ $bill->unit_used }} units)</small>
                        @endif
                    </td>
                    <td>
                        @if($bill->other_bill > 0)
                            ৳{{ number_format($bill->other_bill) }}
                            <small class="text-muted">({{ $bill->other_bill_title }})</small>
                        @else
                            —
                        @endif
                    </td>
                    <td><b>৳{{ number_format($bill->total_amount) }}</b></td>
                    <td>
                        <span class="badge {{ $bill->status === 'paid' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </td>
                    <td>{{ $bill->paid_date ? $bill->paid_date->format('d M Y') : '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No utility bills found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $bills->links() }}
    </div>
</div>
@endsection