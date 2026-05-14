@extends('layouts.app')

@section('title', 'Complaints')
@section('page-title', 'My Complaints')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Complaints</li>