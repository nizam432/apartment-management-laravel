@extends('layouts.app')

@section('title', 'Tenant Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('sidebar')
    <li class="nav-item">
        <a href="{{ route('tenant.dashboard') }}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Welcome, {{ auth()->user()->name }}! 👋</h4>
                    <p>Tenant Dashboard — coming soon.</p>
                </div>
            </div>
        </div>
    </div>
@endsection