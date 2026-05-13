@extends('layouts.app')

@section('title', 'Add Utility Bill')
@section('page-title', 'Add Utility Bill')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.utility-bills.index') }}">Utility Bills</a></li>
    <li class="breadcrumb-item active">Add Bill</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add Utility Bill</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.utility-bills.store') }}" method="POST">
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
                            onchange="loadFlatDetails(this.value)">
                            <option value="">Select Building First</option>
                        </select>
                        @error('flat_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Tenant --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tenant <span class="text-danger">*</span></label>
                        <input type="text" id="tenant_name" class="form-control" readonly placeholder="Auto-filled">
                        <input type="hidden" name="tenant_id" id="tenant_id">
                        @error('tenant_id') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Month --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Month <span class="text-danger">*</span></label>
                        <input type="month" name="month"
                            class="form-control @error('month') is-invalid @enderror"
                            value="{{ old('month', now()->format('Y-m')) }}">
                        @error('month') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Water Bill --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Water Bill (BDT) <small class="text-muted">(Optional)</small></label>
                        <input type="number" name="water_bill" id="water_bill"
                            class="form-control @error('water_bill') is-invalid @enderror"
                            value="{{ old('water_bill', 0) }}" oninput="calcTotal()">
                        @error('water_bill') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Electricity Type Info --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Electricity Type</label>
                        <input type="text" id="electricity_type_display" class="form-control" readonly placeholder="Auto-filled from flat">
                    </div>
                </div>

                {{-- Electricity Bill (prepaid) --}}
                <div class="col-md-4" id="electricity_manual_div">
                    <div class="form-group">
                        <label>Electricity Bill (BDT) <small class="text-muted">(Prepaid — Optional)</small></label>
                        <input type="number" name="electricity_bill" id="electricity_bill"
                            class="form-control @error('electricity_bill') is-invalid @enderror"
                            value="{{ old('electricity_bill', 0) }}" oninput="calcTotal()">
                        @error('electricity_bill') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Postpaid Reading --}}
                <div class="col-md-12" id="postpaid_div" style="display:none">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Previous Reading (Unit)</label>
                                <input type="number" name="previous_reading" id="previous_reading"
                                    class="form-control" value="{{ old('previous_reading') }}"
                                    oninput="calcElectricity()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Current Reading (Unit)</label>
                                <input type="number" name="current_reading" id="current_reading"
                                    class="form-control" value="{{ old('current_reading') }}"
                                    oninput="calcElectricity()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rate per Unit (BDT)</label>
                                <input type="number" name="rate_per_unit" id="rate_per_unit"
                                    class="form-control" value="{{ old('rate_per_unit') }}"
                                    step="0.01" oninput="calcElectricity()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Electricity Bill (Auto)</label>
                                <input type="number" name="electricity_bill" id="electricity_bill_postpaid"
                                    class="form-control" readonly value="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Other Bill --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Other Bill Title <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="other_bill_title"
                            class="form-control @error('other_bill_title') is-invalid @enderror"
                            value="{{ old('other_bill_title') }}" placeholder="e.g. Generator, Lift">
                        @error('other_bill_title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Other Bill Amount (BDT) <small class="text-muted">(Optional)</small></label>
                        <input type="number" name="other_bill" id="other_bill"
                            class="form-control @error('other_bill') is-invalid @enderror"
                            value="{{ old('other_bill', 0) }}" oninput="calcTotal()">
                        @error('other_bill') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Total --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Total Amount (BDT)</label>
                        <input type="number" id="total_display" class="form-control bg-light" readonly value="0">
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Bill
                </button>
                <a href="{{ route('admin.utility-bills.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
let electricityType = 'prepaid';

function loadFloors(buildingId) {
    const flatSelect = document.getElementById('flat_id');
    flatSelect.innerHTML = '<option value="">Loading...</option>';
    clearFlatDetails();

    if (!buildingId) { flatSelect.innerHTML = '<option value="">Select Building First</option>'; return; }

    fetch(`/admin/floors/by-building/${buildingId}`)
        .then(r => r.json())
        .then(floors => {
            flatSelect.innerHTML = '<option value="">Select Flat</option>';
            floors.forEach(floor => {
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

function loadFlatDetails(flatId) {
    clearFlatDetails();
    if (!flatId) return;

    fetch(`/admin/utility-bills/flat-details/${flatId}`)
        .then(r => r.json())
        .then(data => {
            if (data.tenant) {
                document.getElementById('tenant_name').value = data.tenant.name + ' (' + data.tenant.phone + ')';
                document.getElementById('tenant_id').value   = data.tenant.id;
            }
            document.getElementById('water_bill').value = data.water_bill ?? 0;
            electricityType = data.electricity_type;
            document.getElementById('electricity_type_display').value = electricityType.charAt(0).toUpperCase() + electricityType.slice(1);

            if (electricityType === 'postpaid') {
                document.getElementById('postpaid_div').style.display = 'block';
                document.getElementById('electricity_manual_div').style.display = 'none';
            } else {
                document.getElementById('postpaid_div').style.display = 'none';
                document.getElementById('electricity_manual_div').style.display = 'block';
            }
            calcTotal();
        });
}

function calcElectricity() {
    const prev = parseFloat(document.getElementById('previous_reading').value) || 0;
    const curr = parseFloat(document.getElementById('current_reading').value) || 0;
    const rate = parseFloat(document.getElementById('rate_per_unit').value) || 0;
    const bill = Math.max(0, curr - prev) * rate;
    document.getElementById('electricity_bill_postpaid').value = bill.toFixed(2);
    calcTotal();
}

function calcTotal() {
    const water = parseFloat(document.getElementById('water_bill').value) || 0;
    const elec  = electricityType === 'postpaid'
        ? parseFloat(document.getElementById('electricity_bill_postpaid').value) || 0
        : parseFloat(document.getElementById('electricity_bill').value) || 0;
    const other = parseFloat(document.getElementById('other_bill').value) || 0;
    document.getElementById('total_display').value = (water + elec + other).toFixed(2);
}

function clearFlatDetails() {
    document.getElementById('tenant_name').value = '';
    document.getElementById('tenant_id').value   = '';
    document.getElementById('electricity_type_display').value = '';
    document.getElementById('water_bill').value  = 0;
    document.getElementById('total_display').value = 0;
}
</script>
@endsection