@extends('layouts.app')

@section('title', 'Submit Complaint')
@section('page-title', 'Submit Complaint')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tenant.complaints') }}">Complaints</a></li>
    <li class="breadcrumb-item active">Submit Complaint</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Submit New Complaint</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tenant.complaints.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Subject <span class="text-danger">*</span></label>
                        <input type="text" name="subject"
                            class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}"
                            placeholder="Brief description of the issue">
                        @error('subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="description" rows="5"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Describe the issue in detail">{{ old('description') }}</textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane mr-1"></i> Submit Complaint
                </button>
                <a href="{{ route('tenant.complaints') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection