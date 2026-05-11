@extends('layouts.app')

@section('title', 'Edit Floor')
@section('page-title', 'Edit Floor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.floors.index') }}">Floors</a></li>
    <li class="breadcrumb-item active">Edit Floor</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Floor — {{ $floor->floor_name ?? 'Floor ' . $floor->floor_number }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.floors.update', $floor->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                {{-- Building (readonly) --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building</label>
                        <input type="text" class="form-control"
                            value="{{ $floor->building->name }}" readonly>
                    </div>
                </div>

                {{-- Floor Number --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Floor Number <span class="text-danger">*</span></label>
                        <input type="number" name="floor_number"
                            class="form-control @error('floor_number') is-invalid @enderror"
                            value="{{ old('floor_number', $floor->floor_number) }}" min="0">
                        @error('floor_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Floor Name --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Floor Name <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="floor_name"
                            class="form-control @error('floor_name') is-invalid @enderror"
                            value="{{ old('floor_name', $floor->floor_name) }}"
                            placeholder="e.g. Ground Floor, 1st Floor">
                        @error('floor_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Update Floor
                </button>
                <a href="{{ route('admin.floors.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection