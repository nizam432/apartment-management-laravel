@extends('layouts.app')

@section('title', 'Add Employee')
@section('page-title', 'Add New Employee')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Employees</a></li>
    <li class="breadcrumb-item active">Add Employee</li>
@endsection

@section('content')
<form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Basic Information --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user mr-2"></i>Basic Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Building <span class="text-danger">*</span></label>
                        <select name="building_id" class="form-control @error('building_id') is-invalid @enderror">
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
                        <label>Department <span class="text-danger">*</span></label>
                        <select name="department_id" class="form-control @error('department_id') is-invalid @enderror">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

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
                        <label>Designation <span class="text-danger">*</span></label>
                        <input type="text" name="designation"
                            class="form-control @error('designation') is-invalid @enderror"
                            value="{{ old('designation') }}" placeholder="e.g. Security Guard">
                        @error('designation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Salary (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="salary"
                            class="form-control @error('salary') is-invalid @enderror"
                            value="{{ old('salary') }}" placeholder="e.g. 10000">
                        @error('salary') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Join Date <span class="text-danger">*</span></label>
                        <input type="date" name="join_date"
                            class="form-control @error('join_date') is-invalid @enderror"
                            value="{{ old('join_date') }}">
                        @error('join_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Work Shift <small class="text-muted">(Optional)</small></label>
                        <select name="work_shift" class="form-control @error('work_shift') is-invalid @enderror">
                            <option value="">Select Shift</option>
                            <option value="morning" {{ old('work_shift') == 'morning' ? 'selected' : '' }}>Morning</option>
                            <option value="evening" {{ old('work_shift') == 'evening' ? 'selected' : '' }}>Evening</option>
                            <option value="night" {{ old('work_shift') == 'night' ? 'selected' : '' }}>Night</option>
                        </select>
                        @error('work_shift') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Employment Status <span class="text-danger">*</span></label>
                        <select name="employment_status" class="form-control @error('employment_status') is-invalid @enderror">
                            <option value="active" {{ old('employment_status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="resigned" {{ old('employment_status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                            <option value="terminated" {{ old('employment_status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                        </select>
                        @error('employment_status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>NID Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="nid_number"
                            class="form-control @error('nid_number') is-invalid @enderror"
                            value="{{ old('nid_number') }}" placeholder="Enter NID number">
                        @error('nid_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Photo <small class="text-muted">(Optional)</small></label>
                        <input type="file" name="photo"
                            class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Present Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="present_address"
                            class="form-control @error('present_address') is-invalid @enderror"
                            value="{{ old('present_address') }}">
                        @error('present_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Permanent Address <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="permanent_address"
                            class="form-control @error('permanent_address') is-invalid @enderror"
                            value="{{ old('permanent_address') }}">
                        @error('permanent_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
                            value="{{ old('emergency_contact_name') }}">
                        @error('emergency_contact_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Phone <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="emergency_contact_phone"
                            class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                            value="{{ old('emergency_contact_phone') }}">
                        @error('emergency_contact_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Payment Info <small class="text-muted">(Optional)</small></label>
                        <textarea name="payment_info" rows="2"
                            class="form-control @error('payment_info') is-invalid @enderror"
                            placeholder="e.g. bKash: 01XXXXXXXXX">{{ old('payment_info') }}</textarea>
                        @error('payment_info') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Documents --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Documents <small class="text-muted">(Optional)</small></h3>
        </div>
        <div class="card-body">
            <div id="documents-wrapper">
                <div class="row document-row mb-2">
                    <div class="col-md-5">
                        <input type="text" name="document_names[]"
                            class="form-control" placeholder="Document name (e.g. NID, Certificate)">
                    </div>
                    <div class="col-md-6">
                        <input type="file" name="documents[]" class="form-control">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-doc" style="display:none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-document">
                <i class="fas fa-plus mr-1"></i> Add More Document
            </button>
        </div>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Save Employee
        </button>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary ml-2">
            <i class="fas fa-times mr-1"></i> Cancel
        </a>
    </div>
</form>

<script>
document.getElementById('add-document').addEventListener('click', function () {
    const wrapper = document.getElementById('documents-wrapper');
    const row = document.createElement('div');
    row.className = 'row document-row mb-2';
    row.innerHTML = `
        <div class="col-md-5">
            <input type="text" name="document_names[]" class="form-control" placeholder="Document name">
        </div>
        <div class="col-md-6">
            <input type="file" name="documents[]" class="form-control">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-doc">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    wrapper.appendChild(row);
    row.querySelector('.remove-doc').addEventListener('click', () => row.remove());
});
</script>
@endsection