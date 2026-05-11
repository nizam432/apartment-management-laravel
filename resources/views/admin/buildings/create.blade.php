@extends('layouts.app')

@section('title', 'Add Building')
@section('page-title', 'Add New Building')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.buildings.index') }}">Buildings</a></li>
    <li class="breadcrumb-item active">Add Building</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Building</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.buildings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Name --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter building name">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- City --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>City <span class="text-danger">*</span></label>
                        <input type="text" name="city"
                            class="form-control @error('city') is-invalid @enderror"
                            value="{{ old('city') }}" placeholder="Enter city">
                        @error('city') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
                        <input type="text" name="address"
                            class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('address') }}" placeholder="Enter full address">
                        @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Area --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Area <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="area"
                            class="form-control @error('area') is-invalid @enderror"
                            value="{{ old('area') }}" placeholder="e.g. Mirpur, Dhanmondi">
                        @error('area') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Total Floors --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Total Floors <span class="text-danger">*</span></label>
                        <input type="number" name="total_floors"
                            class="form-control @error('total_floors') is-invalid @enderror"
                            value="{{ old('total_floors', 1) }}" min="1" max="50">
                        @error('total_floors') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Electricity Type --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Electricity Type <span class="text-danger">*</span></label>
                        <select name="electricity_type"
                            class="form-control @error('electricity_type') is-invalid @enderror">
                            <option value="prepaid" {{ old('electricity_type') == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                            <option value="postpaid" {{ old('electricity_type') == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                        </select>
                        @error('electricity_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Water Bill --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Water Bill</label>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="water_bill_applicable"
                                name="water_bill_applicable" value="1"
                                {{ old('water_bill_applicable') ? 'checked' : '' }}
                                onchange="toggleWaterBill(this)">
                            <label class="custom-control-label" for="water_bill_applicable">
                                Water bill applicable
                            </label>
                        </div>
                        <input type="number" name="water_bill_amount" id="water_bill_amount"
                            class="form-control @error('water_bill_amount') is-invalid @enderror"
                            value="{{ old('water_bill_amount') }}" placeholder="Amount in BDT"
                            style="{{ old('water_bill_applicable') ? '' : 'display:none' }}">
                        @error('water_bill_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Image --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building Image <small class="text-muted">(Optional)</small></label>
                        <input type="file" name="image"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/*">
                        @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description <small class="text-muted">(Optional)</small></label>
                        <textarea name="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter building description">{{ old('description') }}</textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Building
                </button>
                <a href="{{ route('admin.buildings.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleWaterBill(checkbox) {
    const amountField = document.getElementById('water_bill_amount');
    amountField.style.display = checkbox.checked ? 'block' : 'none';
}
</script>
@endsection