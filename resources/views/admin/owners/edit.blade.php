@extends('layouts.app')

@section('title', 'Edit Tenant')
@section('page-title', 'Edit Tenant')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tenants.index') }}">Tenants</a></li>
    <li class="breadcrumb-item active">Edit Tenant</li>
@endsection

@section('content')
<form action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

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
                            value="{{ old('name', $tenant->name) }}">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $tenant->phone) }}">
                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email <small class="text-muted">(Optional)</small></label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $tenant->email) }}">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date of Birth <small class="text-muted">(Optional)</small></label>
                        <input type="date" name="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth', $tenant->date_of_birth?->format('Y-m-d')) }}">
                        @error('date_of_birth') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gender <small class="text-muted">(Optional)</small></label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $tenant->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $tenant->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $tenant->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Profession <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="profession"
                            class="form-control @error('profession') is-invalid @enderror"
                            value="{{ old('profession', $tenant->profession) }}">
                        @error('profession') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label>Permanent Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="permanent_address"
                            class="form-control @error('permanent_address') is-invalid @enderror"
                            value="{{ old('permanent_address', $tenant->permanent_address) }}">
                        @error('permanent_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Notes <small class="text-muted">(Optional)</small></label>
                        <textarea name="notes" rows="2"
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $tenant->notes) }}</textarea>
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
                            value="{{ old('emergency_contact_name', $tenant->emergency_contact_name) }}">
                        @error('emergency_contact_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Phone <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="emergency_contact_phone"
                            class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                            value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}">
                        @error('emergency_contact_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Flat & Rent --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-home mr-2"></i>Flat & Rent Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Building</label>
                        <input type="text" class="form-control"
                            value="{{ $tenant->building->name }}" readonly>
                        <input type="hidden" name="building_id" value="{{ $tenant->building_id }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Floor</label>
                        <input type="text" class="form-control"
                            value="{{ $tenant->floor->floor_name ?? 'Floor ' . $tenant->floor->floor_number }}" readonly>
                        <input type="hidden" name="floor_id" value="{{ $tenant->floor_id }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Flat</label>
                        <input type="text" class="form-control"
                            value="{{ $tenant->flat->flat_number }}" readonly>
                        <input type="hidden" name="flat_id" value="{{ $tenant->flat_id }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Monthly Rent (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="monthly_rent"
                            class="form-control @error('monthly_rent') is-invalid @enderror"
                            value="{{ old('monthly_rent', $tenant->monthly_rent) }}">
                        @error('monthly_rent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Advance Amount (BDT) <small class="text-muted">(Optional)</small></label>
                        <input type="number" name="advance_amount"
                            class="form-control @error('advance_amount') is-invalid @enderror"
                            value="{{ old('advance_amount', $tenant->advance_amount) }}">
                        @error('advance_amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Move In Date <span class="text-danger">*</span></label>
                        <input type="date" name="move_in_date"
                            class="form-control @error('move_in_date') is-invalid @enderror"
                            value="{{ old('move_in_date', $tenant->move_in_date->format('Y-m-d')) }}">
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
                        @if($tenant->picture)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $tenant->picture) }}"
                                     alt="Picture" height="60" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="picture"
                            class="form-control @error('picture') is-invalid @enderror" accept="image/*">
                        @error('picture') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Front</label>
                        @if($tenant->nid_front)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $tenant->nid_front) }}"
                                     alt="NID Front" height="60" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="nid_front"
                            class="form-control @error('nid_front') is-invalid @enderror" accept="image/*">
                        @error('nid_front') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Back</label>
                        @if($tenant->nid_back)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $tenant->nid_back) }}"
                                     alt="NID Back" height="60" class="rounded">
                            </div>
                        @endif
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
            <i class="fas fa-save mr-1"></i> Update Tenant
        </button>
        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-times mr-1"></i> Cancel
        </a>
    </div>
</form>
@endsection