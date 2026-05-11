@extends('layouts.app')

@section('title', 'Edit Flat')
@section('page-title', 'Edit Flat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.flats.index') }}">Flats</a></li>
    <li class="breadcrumb-item active">Edit Flat</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Flat — {{ $flat->flat_number }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.flats.update', $flat->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                {{-- Building --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Building <span class="text-danger">*</span></label>
                        <select name="building_id" id="building_id"
                            class="form-control @error('building_id') is-invalid @enderror"
                            onchange="loadFloors(this.value)">
                            <option value="">Select Building</option>
                            @foreach($buildings as $building)
                                <option value="{{ $building->id }}"
                                    {{ old('building_id', $flat->building_id) == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('building_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Floor --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Floor <span class="text-danger">*</span></label>
                        <select name="floor_id" id="floor_id"
                            class="form-control @error('floor_id') is-invalid @enderror">
                            @foreach($floors as $floor)
                                <option value="{{ $floor->id }}"
                                    {{ old('floor_id', $flat->floor_id) == $floor->id ? 'selected' : '' }}>
                                    {{ $floor->floor_name ?? 'Floor ' . $floor->floor_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('floor_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Flat Number --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Flat Number <span class="text-danger">*</span></label>
                        <input type="text" name="flat_number"
                            class="form-control @error('flat_number') is-invalid @enderror"
                            value="{{ old('flat_number', $flat->flat_number) }}">
                        @error('flat_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Flat Type --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Flat Type <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="flat_type"
                            class="form-control @error('flat_type') is-invalid @enderror"
                            value="{{ old('flat_type', $flat->flat_type) }}" placeholder="e.g. 2BHK, 3BHK">
                        @error('flat_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Size --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Size (sqft) <small class="text-muted">(Optional)</small></label>
                        <input type="number" name="size_sqft"
                            class="form-control @error('size_sqft') is-invalid @enderror"
                            value="{{ old('size_sqft', $flat->size_sqft) }}">
                        @error('size_sqft') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Rent Amount --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Rent Amount (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="rent_amount"
                            class="form-control @error('rent_amount') is-invalid @enderror"
                            value="{{ old('rent_amount', $flat->rent_amount) }}">
                        @error('rent_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Electricity Type --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Electricity Type <span class="text-danger">*</span></label>
                        <select name="electricity_type"
                            class="form-control @error('electricity_type') is-invalid @enderror">
                            <option value="prepaid" {{ old('electricity_type', $flat->electricity_type) == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                            <option value="postpaid" {{ old('electricity_type', $flat->electricity_type) == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                        </select>
                        @error('electricity_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Meter Number --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Electricity Meter No <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="electricity_meter_no"
                            class="form-control @error('electricity_meter_no') is-invalid @enderror"
                            value="{{ old('electricity_meter_no', $flat->electricity_meter_no) }}">
                        @error('electricity_meter_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Water Bill --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Water Bill</label>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="water_bill_applicable"
                                name="water_bill_applicable" value="1"
                                {{ old('water_bill_applicable', $flat->water_bill_applicable) ? 'checked' : '' }}
                                onchange="toggleWaterBill(this)">
                            <label class="custom-control-label" for="water_bill_applicable">
                                Water bill applicable
                            </label>
                        </div>
                        <input type="number" name="water_bill_amount" id="water_bill_amount"
                            class="form-control @error('water_bill_amount') is-invalid @enderror"
                            value="{{ old('water_bill_amount', $flat->water_bill_amount) }}"
                            placeholder="Amount in BDT"
                            style="{{ old('water_bill_applicable', $flat->water_bill_applicable) ? '' : 'display:none' }}">
                        @error('water_bill_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Update Flat
                </button>
                <a href="{{ route('admin.flats.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function loadFloors(buildingId) {
    const floorSelect = document.getElementById('floor_id');
    floorSelect.innerHTML = '<option value="">Loading...</option>';

    if (!buildingId) {
        floorSelect.innerHTML = '<option value="">Select Building First</option>';
        return;
    }

    fetch(`/admin/floors/by-building/${buildingId}`)
        .then(res => res.json())
        .then(floors => {
            floorSelect.innerHTML = '<option value="">Select Floor</option>';
            floors.forEach(floor => {
                floorSelect.innerHTML += `<option value="${floor.id}">${floor.floor_name ?? 'Floor ' + floor.floor_number}</option>`;
            });
        });
}

function toggleWaterBill(checkbox) {
    document.getElementById('water_bill_amount').style.display = checkbox.checked ? 'block' : 'none';
}
</script>
@endsection