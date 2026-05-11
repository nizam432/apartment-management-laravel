@extends('layouts.app')

@section('title', 'Add Floor')
@section('page-title', 'Add New Floor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.floors.index') }}">Floors</a></li>
    <li class="breadcrumb-item active">Add Floor</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Floor</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.floors.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Building --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building <span class="text-danger">*</span></label>
                        <select name="building_id"
                            class="form-control @error('building_id') is-invalid @enderror">
                            <option value="">Select Building</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Floor Number --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Floor Number <span class="text-danger">*</span></label>
                        <input type="number" name="floor_number"
                            class="form-control @error('floor_number') is-invalid @enderror"
                            value="{{ old('floor_number', 0) }}" min="0">
                        <small class="text-muted">0 = Ground Floor</small>
                        @error('floor_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Floor Name --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Floor Name <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="floor_name"
                            class="form-control @error('floor_name') is-invalid @enderror"
                            value="{{ old('floor_name') }}" placeholder="e.g. Ground Floor, 1st Floor">
                        <small class="text-muted">Leave blank to auto-generate</small>
                        @error('floor_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Floor
                </button>
                <a href="{{ route('admin.floors.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection