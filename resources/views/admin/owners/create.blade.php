@extends('layouts.app')

@section('title', 'Add Owner')
@section('page-title', 'Add New Owner')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.owners.index') }}">Owners</a></li>
    <li class="breadcrumb-item active">Add Owner</li>
@endsection

@section('content')
<form action="{{ route('admin.owners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Account Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user mr-2"></i>Account Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Name --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter full name">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Phone --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" placeholder="01XXXXXXXXX">
                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email <small class="text-muted">(Optional)</small></label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="example@email.com">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 6 characters">
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Confirm Password --}}
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

    {{-- Personal Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-id-card mr-2"></i>Personal Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- NID Number --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="nid_number"
                            class="form-control @error('nid_number') is-invalid @enderror"
                            value="{{ old('nid_number') }}" placeholder="Enter NID number">
                        @error('nid_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Present Address --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Present Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="present_address"
                            class="form-control @error('present_address') is-invalid @enderror"
                            value="{{ old('present_address') }}" placeholder="Enter present address">
                        @error('present_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Permanent Address --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Permanent Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="permanent_address"
                            class="form-control @error('permanent_address') is-invalid @enderror"
                            value="{{ old('permanent_address') }}" placeholder="Enter permanent address">
                        @error('permanent_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Payment Info <small class="text-muted">(Optional)</small></label>
                        <textarea name="payment_info" rows="2"
                            class="form-control @error('payment_info') is-invalid @enderror"
                            placeholder="e.g. bKash: 01XXXXXXXXX, Bank: ABC Bank, Account: XXXX">{{ old('payment_info') }}</textarea>
                        @error('payment_info') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Notes --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Notes <small class="text-muted">(Optional)</small></label>
                        <textarea name="notes" rows="2"
                            class="form-control @error('notes') is-invalid @enderror"
                            placeholder="Any additional notes">{{ old('notes') }}</textarea>
                        @error('notes') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
            <i class="fas fa-save mr-1"></i> Save Owner
        </button>
        <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-times mr-1"></i> Cancel
        </a>
    </div>
</form>
@endsection