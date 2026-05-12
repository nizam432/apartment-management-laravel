@extends('layouts.app')

@section('title', 'Edit Owner')
@section('page-title', 'Edit Owner')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.owners.index') }}">Owners</a></li>
    <li class="breadcrumb-item active">Edit Owner</li>
@endsection

@section('content')
<form action="{{ route('admin.owners.update', $owner->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    {{-- Account Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user mr-2"></i>Account Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $owner->user->name) }}">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $owner->user->phone) }}">
                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email <small class="text-muted">(Optional)</small></label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $owner->user->email) }}">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                        <input type="password" name="password" autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 6 characters">
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="form-control" placeholder="Repeat new password">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="nid_number"
                            class="form-control @error('nid_number') is-invalid @enderror"
                            value="{{ old('nid_number', $owner->nid_number) }}">
                        @error('nid_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Present Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="present_address"
                            class="form-control @error('present_address') is-invalid @enderror"
                            value="{{ old('present_address', $owner->present_address) }}">
                        @error('present_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Permanent Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="permanent_address"
                            class="form-control @error('permanent_address') is-invalid @enderror"
                            value="{{ old('permanent_address', $owner->permanent_address) }}">
                        @error('permanent_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Payment Info <small class="text-muted">(Optional)</small></label>
                        <textarea name="payment_info" rows="2"
                            class="form-control @error('payment_info') is-invalid @enderror">{{ old('payment_info', $owner->payment_info) }}</textarea>
                        @error('payment_info') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Notes <small class="text-muted">(Optional)</small></label>
                        <textarea name="notes" rows="2"
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $owner->notes) }}</textarea>
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
                        @if($owner->picture)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $owner->picture) }}"
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
                        @if($owner->nid_front)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $owner->nid_front) }}"
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
                        @if($owner->nid_back)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $owner->nid_back) }}"
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
            <i class="fas fa-save mr-1"></i> Update Owner
        </button>
        <a href="{{ route('admin.owners.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-times mr-1"></i> Cancel
        </a>
    </div>
</form>
@endsection