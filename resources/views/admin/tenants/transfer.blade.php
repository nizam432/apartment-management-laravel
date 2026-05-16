@extends('layouts.app')

@section('title', 'Transfer Flat')
@section('page-title', 'Transfer Flat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item active">Transfer Flat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title text-white">
                    <i class="fas fa-exchange-alt mr-2"></i>Transfer Flat — {{ $tenant->name }}
                </h3>
            </div>
            <div class="card-body">
                {{-- Current Info --}}
                <div class="alert alert-info">
                    <b>Current:</b>
                    {{ $tenant->building->name }} →
                    {{ $tenant->floor->floor_name ?? 'Floor ' . $tenant->floor->floor_number }} →
                    Flat <b>{{ $tenant->flat->flat_number }}</b> |
                    Rent: <b>৳{{ number_format($tenant->monthly_rent) }}</b>
                </div>

                <form action="{{ route('admin.tenants.transfer.store', $tenant->id) }}" method="POST">
                    @csrf @method('PATCH')

                    {{-- Floor --}}
                    <div class="form-group">
                        <label>New Floor <span class="text-danger">*</span></label>
                        <select id="floor_id" class="form-control" onchange="loadVacantFlats(this.value)">
                            <option value="">Select Floor</option>
                            @foreach($floors as $floor)
                                <option value="{{ $floor->id }}">
                                    {{ $floor->floor_name ?? 'Floor ' . $floor->floor_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- New Flat --}}
                    <div class="form-group">
                        <label>New Flat <span class="text-danger">*</span></label>
                        <select name="to_flat_id" id="to_flat_id"
                            class="form-control @error('to_flat_id') is-invalid @enderror"
                            onchange="setNewRent(this)">
                            <option value="">Select Floor First</option>
                        </select>
                        @error('to_flat_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    {{-- New Rent --}}
                    <div class="form-group">
                        <label>New Rent Amount (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="new_rent" id="new_rent"
                            class="form-control @error('new_rent') is-invalid @enderror"
                            value="{{ old('new_rent', $tenant->monthly_rent) }}"
                            placeholder="Auto-filled from flat">
                        @error('new_rent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    {{-- Transfer Date --}}
                    <div class="form-group">
                        <label>Transfer Date <span class="text-danger">*</span></label>
                        <input type="date" name="transfer_date"
                            class="form-control @error('transfer_date') is-invalid @enderror"
                            value="{{ old('transfer_date', now()->format('Y-m-d')) }}">
                        @error('transfer_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    {{-- Reason --}}
                    <div class="form-group">
                        <label>Reason <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="reason"
                            class="form-control @error('reason') is-invalid @enderror"
                            value="{{ old('reason') }}"
                            placeholder="e.g. Bigger flat needed, Floor preference">
                        @error('reason') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle mr-2"></i>
                        Old flat will become <b>Vacant</b>. New flat will become <b>Occupied</b>.
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-info"
                            onclick="return confirm('Are you sure you want to transfer this tenant?')">
                            <i class="fas fa-exchange-alt mr-1"></i> Confirm Transfer
                        </button>
                        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const flatsByFloorUrl = "{{ route('admin.tenants.flats-by-floor', ['floor' => '__ID__']) }}".replace('__ID__', '');

function loadVacantFlats(floorId) {
    const flatSelect = document.getElementById('to_flat_id');
    flatSelect.innerHTML = '<option value="">Loading...</option>';

    if (!floorId) { flatSelect.innerHTML = '<option value="">Select Floor First</option>'; return; }

    fetch(flatsByFloorUrl + floorId)
        .then(r => r.json())
        .then(flats => {
            flatSelect.innerHTML = '<option value="">Select Flat</option>';
            flats.forEach(f => {
                // Exclude current flat
                if (f.id != {{ $tenant->flat_id }}) {
                    flatSelect.innerHTML += `<option value="${f.id}" data-rent="${f.rent_amount}">${f.flat_number} — ৳${f.rent_amount}</option>`;
                }
            });
        });
}

function setNewRent(select) {
    const rent = select.options[select.selectedIndex]?.dataset.rent;
    if (rent) document.getElementById('new_rent').value = rent;
}
</script>
@endsection