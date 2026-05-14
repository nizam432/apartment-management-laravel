@extends('layouts.app')

@section('title', 'Notice Board')
@section('page-title', 'Notice Board')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Notice Board</li>
@endsection

@section('content')
@forelse($notices as $notice)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $notice->title }}</h3>
        <div class="card-tools">
            <span class="badge badge-info">{{ ucfirst($notice->target) }}</span>
            @if($notice->expire_date)
                <span class="badge badge-warning ml-1">Expires: {{ $notice->expire_date->format('d M Y') }}</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <p>{{ $notice->body }}</p>
        <small class="text-muted">
            <i class="fas fa-calendar mr-1"></i>{{ $notice->created_at->format('d M Y') }}
        </small>
    </div>
</div>
@empty
<div class="card">
    <div class="card-body text-center">
        <p class="text-muted">No notices found.</p>
    </div>
</div>
@endforelse

{{ $notices->links() }}
@endsection