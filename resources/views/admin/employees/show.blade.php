@extends('layouts.app')

@section('title', 'Employee Details')
@section('page-title', 'Employee Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Employees</a></li>
    <li class="breadcrumb-item active">{{ $employee->name }}</li>
@endsection

@section('content')
<div class="row">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}"
                             alt="{{ $employee->name }}"
                             class="profile-user-img img-fluid img-circle"
                             style="width:100px;height:100px;object-fit:cover;">
                    @else
                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                    @endif
                </div>
                <h3 class="profile-username text-center mt-2">{{ $employee->name }}</h3>
                <p class="text-muted text-center">{{ $employee->designation }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Employee Code</b>
                        <span class="float-right badge badge-secondary">{{ $employee->employee_code }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <span class="float-right">{{ $employee->phone }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <span class="float-right">{{ $employee->email ?? '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Department</b> <span class="float-right">{{ $employee->department->name ?? '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Building</b> <span class="float-right">{{ $employee->building->name ?? '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Work Shift</b> <span class="float-right">{{ ucfirst($employee->work_shift ?? '—') }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">
                            @if($employee->employment_status === 'active')
                                <span class="badge badge-success">Active</span>
                            @elseif($employee->employment_status === 'resigned')
                                <span class="badge badge-warning">Resigned</span>
                            @else
                                <span class="badge badge-danger">Terminated</span>
                            @endif
                        </span>
                    </li>
                </ul>

                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-info btn-block">
                    <i class="fas fa-edit mr-1"></i> Edit Employee
                </a>
            </div>
        </div>
    </div>

    {{-- Details --}}
    <div class="col-md-8">
        {{-- Job Info --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-briefcase mr-2"></i>Job Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>Salary</b></td>
                                <td>৳{{ number_format($employee->salary) }}</td>
                            </tr>
                            <tr>
                                <td><b>Join Date</b></td>
                                <td>{{ $employee->join_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td><b>Resign Date</b></td>
                                <td>{{ $employee->resign_date?->format('d M Y') ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><b>NID Number</b></td>
                                <td>{{ $employee->nid_number ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td><b>Present Address</b></td>
                                <td>{{ $employee->present_address ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td><b>Permanent Address</b></td>
                                <td>{{ $employee->permanent_address ?? '—' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Emergency & Payment --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-phone mr-2"></i>Emergency Contact & Payment</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><b>Emergency Contact</b></td>
                        <td>{{ $employee->emergency_contact_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Emergency Phone</b></td>
                        <td>{{ $employee->emergency_contact_phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><b>Payment Info</b></td>
                        <td>{{ $employee->payment_info ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Documents --}}
        @if($documents->count())
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Documents</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $doc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doc->document_name }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $doc->file_path) }}"
                                   target="_blank" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-download"></i> View
                                </a>
                                <form action="{{ route('admin.employees.documents.delete', $doc->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this document?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection