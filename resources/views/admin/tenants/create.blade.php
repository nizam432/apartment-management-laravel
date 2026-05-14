@extends('layouts.app')

@section('title', 'Add Tenant')
@section('page-title', 'Add New Tenant')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item active">Add Tenant</li>
@endsection

@section('content')
<form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Personal Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user mr-2"></i>Personal Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter full name">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email <small class="text-muted">(Optional)</small></label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="example@email.com">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date of Birth <small class="text-muted">(Optional)</small></label>
                        <input type="date" name="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth') }}">
                        @error('date_of_birth') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gender <small class="text-muted">(Optional)</small></label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Profession <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="profession"
                            class="form-control @error('profession') is-invalid @enderror"
                            value="{{ old('profession') }}" placeholder="e.g. Engineer, Teacher">
                        @error('profession') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Permanent Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="permanent_address"
                            class="form-control @error('permanent_address') is-invalid @enderror"
                            value="{{ old('permanent_address') }}" placeholder="Enter permanent address">
                        @error('permanent_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Notes <small class="text-muted">(Optional)</small></label>
                        <textarea name="notes" rows="2"
                            class="form-control @error('notes') is-invalid @enderror"
                            placeholder="e.g. Family of 4 members">{{ old('notes') }}</textarea>
                        @error('notes') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Emergency Contact --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-phone mr-2"></i>Emergency Contact</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Name <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="emergency_contact_name"
                            class="form-control @error('emergency_contact_name') is-invalid @enderror"
                            value="{{ old('emergency_contact_name') }}" placeholder="Enter contact name">
                        @error('emergency_contact_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Phone <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="emergency_contact_phone"
                            class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                            value="{{ old('emergency_contact_phone') }}" placeholder="01XXXXXXXXX">
                        @error('emergency_contact_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Login Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-lock mr-2"></i>Login Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 6 characters">
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="form-control" placeholder="Repeat password">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Flat & Rent Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-home mr-2"></i>Flat & Rent Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Building <span class="text-danger">*</span></label>
                        <select name="building_id" id="building_id"
                            class="form-control @error('building_id') is-invalid @enderror"
                            onchange="loadFloors(this.value)">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Floor <span class="text-danger">*</span></label>
                        <select name="floor_id" id="floor_id"
                            class="form-control @error('floor_id') is-invalid @enderror"
                            onchange="loadFlats(this.value)">
                            <option value="">Select Building First</option>
                        </select>
                        @error('floor_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Flat <span class="text-danger">*</span></label>
                        <select name="flat_id" id="flat_id"
                            class="form-control @error('flat_id') is-invalid @enderror"
                            onchange="setRent(this)">
                            <option value="">Select Floor First</option>
                        </select>
                        @error('flat_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Monthly Rent (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="monthly_rent" id="monthly_rent"
                            class="form-control @error('monthly_rent') is-invalid @enderror"
                            value="{{ old('monthly_rent') }}" placeholder="Auto-filled from flat">
                        @error('monthly_rent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Advance Amount (BDT) <small class="text-muted">(Optional)</small></label>
                        <input type="number" name="advance_amount"
                            class="form-control @error('advance_amount') is-invalid @enderror"
                            value="{{ old('advance_amount') }}" placeholder="e.g. 30000">
                        @error('advance_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Move In Date <span class="text-danger">*</span></label>
                        <input type="date" name="move_in_date"
                            class="form-control @error('move_in_date') is-invalid @enderror"
                            value="{{ old('move_in_date') }}">
                        @error('move_in_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Documents --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Documents <small class="text-muted">(All Optional)</small></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" name="picture"
                            class="form-control @error('picture') is-invalid @enderror" accept="image/*">
                        @error('picture') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Front</label>
                        <input type="file" name="nid_front"
                            class="form-control @error('nid_front') is-invalid @enderror" accept="image/*">
                        @error('nid_front') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Back</label>
                        <input type="file" name="nid_back"
                            class="form-control @error('nid_back') is-invalid @enderror" accept="image/*">
                        @error('nid_back') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Save Tenant
        </button>
        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-times mr-1"></i> Cancel
        </a>
    </div>
</form>

<script>
const floorsByBuildingUrl = "{{ route('admin.floors.by-building', ['building' => '__ID__']) }}".replace('__ID__', '');
const flatsByFloorUrl     = "{{ route('admin.tenants.flats-by-floor', ['floor' => '__ID__']) }}".replace('__ID__', '');

function loadFloors(buildingId) {
    const floorSelect = document.getElementById('floor_id');
    const flatSelect  = document.getElementById('flat_id');
    floorSelect.innerHTML = '<option value="">Loading...</option>';
    flatSelect.innerHTML  = '<option value="">Select Floor First</option>';
    document.getElementById('monthly_rent').value = '';

    if (!buildingId) {
        floorSelect.innerHTML = '<option value="">Select Building First</option>';
        return;
    }

    fetch(floorsByBuildingUrl + buildingId)
        .then(r => r.json())
        .then(floors => {
            floorSelect.innerHTML = '<option value="">Select Floor</option>';
            floors.forEach(f => {
                floorSelect.innerHTML += `<option value="${f.id}">${f.floor_name ?? 'Floor ' + f.floor_number}</option>`;
            });
        });
}

function loadFlats(floorId) {
    const flatSelect = document.getElementById('flat_id');
    flatSelect.innerHTML = '<option value="">Loading...</option>';

    if (!floorId) {
        flatSelect.innerHTML = '<option value="">Select Floor First</option>';
        return;
    }

    fetch(flatsByFloorUrl + floorId)
        .then(r => r.json())
        .then(flats => {
            flatSelect.innerHTML = '<option value="">Select Flat</option>';
            flats.forEach(f => {
                flatSelect.innerHTML += `<option value="${f.id}" data-rent="${f.rent_amount}">${f.flat_number} — ৳${f.rent_amount}</option>`;
            });
        });
}

function setRent(select) {
    const rent = select.options[select.selectedIndex]?.dataset.rent;
    if (rent) document.getElementById('monthly_rent').value = rent;
}
</script>
@endsection