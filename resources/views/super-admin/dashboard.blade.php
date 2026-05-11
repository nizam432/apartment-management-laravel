@extends('layouts.app')

@section('title', 'Super Admin Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Welcome, {{ auth()->user()->name }}! 👋</h4>
                    <p>Super Admin Dashboard — coming soon.</p>
                </div>
            </div>
        </div>
    </div>
@endsection