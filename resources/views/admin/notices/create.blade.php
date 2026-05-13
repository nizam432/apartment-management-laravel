@extends('layouts.app')

@section('title', 'Add Notice')
@section('page-title', 'Add New Notice')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.notices.index') }}">Notices</a></li>
    <li class="breadcrumb-item active">Add Notice</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Notice</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.notices.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="Enter notice title">
                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Target <span class="text-danger">*</span></label>
                        <select name="target" class="form-control @error('target') is-invalid @enderror">
                            <option value="all" {{ old('target') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="tenants" {{ old('target') == 'tenants' ? 'selected' : '' }}>Tenants</option>
                            <option value="owners" {{ old('target') == 'owners' ? 'selected' : '' }}>Owners</option>
                            <option value="employees" {{ old('target') == 'employees' ? 'selected' : '' }}>Employees</option>
                        </select>
                        @error('target') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building <small class="text-muted">(Optional — leave blank for all buildings)</small></label>
                        <select name="building_id" class="form-control @error('building_id') is-invalid @enderror">
                            <option value="">All Buildings</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Expire Date <small class="text-muted">(Optional)</small></label>
                        <input type="date" name="expire_date"
                            class="form-control @error('expire_date') is-invalid @enderror"
                            value="{{ old('expire_date') }}">
                        @error('expire_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Body <span class="text-danger">*</span></label>
                        <textarea name="body" rows="5"
                            class="form-control @error('body') is-invalid @enderror"
                            placeholder="Enter notice body">{{ old('body') }}</textarea>
                        @error('body') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Notice
                </button>
                <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection