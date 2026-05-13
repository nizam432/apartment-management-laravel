@extends('layouts.app')

@section('title', 'Add Visitor')
@section('page-title', 'Add Visitor Log')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.visitor-logs.index') }}">Visitor Log</a></li>
    <li class="breadcrumb-item active">Add Visitor</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Visitor</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.visitor-logs.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Building --}}
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

                {{-- Flat --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Flat <span class="text-danger">*</span></label>
                        <select name="flat_id" id="flat_id"
                            class="form-control @error('flat_id') is-invalid @enderror"
                            onchange="loadTenants(this.value)">
                            <option value="">Select Building First</option>
                        </select>
                        @error('flat_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Tenant --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tenant <span class="text-danger">*</span></label>
                        <select name="tenant_id" id="tenant_id"
                            class="form-control @error('tenant_id') is-invalid @enderror">
                            <option value="">Select Flat First</option>
                        </select>
                        @error('tenant_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Visitor Name --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Visitor Name <span class="text-danger">*</span></label>
                        <input type="text" name="visitor_name"
                            class="form-control @error('visitor_name') is-invalid @enderror"
                            value="{{ old('visitor_name') }}" placeholder="Enter visitor name">
                        @error('visitor_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Visitor Phone --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Visitor Phone <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="visitor_phone"
                            class="form-control @error('visitor_phone') is-invalid @enderror"
                            value="{{ old('visitor_phone') }}" placeholder="01XXXXXXXXX">
                        @error('visitor_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Purpose --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Purpose <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="purpose"
                            class="form-control @error('purpose') is-invalid @enderror"
                            value="{{ old('purpose') }}" placeholder="e.g. Family visit, Delivery">
                        @error('purpose') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- In Time --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>In Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="in_time"
                            class="form-control @error('in_time') is-invalid @enderror"
                            value="{{ old('in_time', now()->format('Y-m-d\TH:i')) }}">
                        @error('in_time') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Out Time --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Out Time <small class="text-muted">(Optional)</small></label>
                        <input type="datetime-local" name="out_time"
                            class="form-control @error('out_time') is-invalid @enderror"
                            value="{{ old('out_time') }}">
                        @error('out_time') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Employee --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Entry By <small class="text-muted">(Optional)</small></label>
                        <select name="employee_id"
                            class="form-control @error('employee_id') is-invalid @enderror">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} ({{ $emp->designation }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Note --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Note <small class="text-muted">(Optional)</small></label>
                        <textarea name="note" rows="2"
                            class="form-control @error('note') is-invalid @enderror"
                            placeholder="Any additional note">{{ old('note') }}</textarea>
                        @error('note') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save
                </button>
                <a href="{{ route('admin.visitor-logs.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function loadFloors(buildingId) {
    const flatSelect = document.getElementById('flat_id');
    flatSelect.innerHTML = '<option value="">Loading...</option>';
    document.getElementById('tenant_id').innerHTML = '<option value="">Select Flat First</option>';

    if (!buildingId) { flatSelect.innerHTML = '<option value="">Select Building First</option>'; return; }

    fetch(`/admin/floors/by-building/${buildingId}`)
        .then(r => r.json())
        .then(floors => {
            flatSelect.innerHTML = '<option value="">Select Flat</option>';
            floors.forEach(floor => {
                // Load flats for each floor
                fetch(`/admin/tenants/flats-by-floor/${floor.id}`)
                    .then(r => r.json())
                    .then(flats => {
                        flats.forEach(flat => {
                            flatSelect.innerHTML += `<option value="${flat.id}">${flat.flat_number}</option>`;
                        });
                    });
            });
        });
}

function loadTenants(flatId) {
    const tenantSelect = document.getElementById('tenant_id');
    tenantSelect.innerHTML = '<option value="">Loading...</option>';

    if (!flatId) { tenantSelect.innerHTML = '<option value="">Select Flat First</option>'; return; }

    fetch(`/admin/visitor-logs/tenants-by-flat/${flatId}`)
        .then(r => r.json())
        .then(tenants => {
            tenantSelect.innerHTML = '<option value="">Select Tenant</option>';
            tenants.forEach(t => {
                tenantSelect.innerHTML += `<option value="${t.id}">${t.name} (${t.phone})</option>`;
            });
        });
}
</script>
@endsection