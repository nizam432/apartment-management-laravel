@extends('layouts.app')

@section('title', 'Employees')
@section('page-title', 'Employee Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Employees</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Employees</h3>
        <div class="card-tools">
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Add Employee
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Building</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($employee->photo)
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                 alt="{{ $employee->name }}" width="40" height="40"
                                 class="rounded-circle">
                        @else
                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                        @endif
                    </td>
                    <td><span class="badge badge-secondary">{{ $employee->employee_code }}</span></td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->building->name ?? '—' }}</td>
                    <td>{{ $employee->department->name ?? '—' }}</td>
                    <td>{{ $employee->designation }}</td>
                    <td>{{ ucfirst($employee->work_shift ?? '—') }}</td>
                    <td>
                        @if($employee->employment_status === 'active')
                            <span class="badge badge-success">Active</span>
                        @elseif($employee->employment_status === 'resigned')
                            <span class="badge badge-warning">Resigned</span>
                        @else
                            <span class="badge badge-danger">Terminated</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.employees.show', $employee->id) }}"
                           class="btn btn-sm btn-secondary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.employees.edit', $employee->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.employees.destroy', $employee->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center">No employees found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $employees->links() }}
    </div>
</div>
@endsection