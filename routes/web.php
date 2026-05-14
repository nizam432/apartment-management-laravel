<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ── Public ──────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login',   [LoginController::class, 'showForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\SuperAdmin\AdminController as SuperAdminController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\DepartmentController;

Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('admins', SuperAdminController::class);
    Route::patch('admins/{admin}/toggle-status', [SuperAdminController::class, 'toggleStatus'])
         ->name('admins.toggle-status');
    Route::resource('departments', DepartmentController::class)->except(['show']);
});

// ── Admin ────────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\FlatController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\OwnerController;
use App\Http\Controllers\Admin\RentPaymentController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UtilityBillController;
use App\Http\Controllers\Admin\VisitorLogController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Building management
    Route::resource('buildings', BuildingController::class);
    Route::patch('buildings/{building}/toggle-status', [BuildingController::class, 'toggleStatus'])
         ->name('buildings.toggle-status');

    // Floor management
    Route::get('floors/by-building/{building}', [FloorController::class, 'byBuilding'])
         ->name('floors.by-building');
    Route::resource('floors', FloorController::class)->except(['show']);

    // Flat management
    Route::resource('flats', FlatController::class)->except(['show']);

    // Tenant management
    Route::get('tenants/flats-by-floor/{floor}', [TenantController::class, 'flatsByFloor'])
         ->name('tenants.flats-by-floor');
    Route::resource('tenants', TenantController::class);

    // Owner management
    Route::resource('owners', OwnerController::class);
    Route::patch('owners/{owner}/toggle-status', [OwnerController::class, 'toggleStatus'])
         ->name('owners.toggle-status');

    // Employee management
    Route::resource('employees', EmployeeController::class);
    Route::delete('employees/documents/{document}', [EmployeeController::class, 'deleteDocument'])
         ->name('employees.documents.delete');

    // Complaint management
    Route::resource('complaints', ComplaintController::class)->only(['index', 'show', 'update', 'destroy']);

    // Visitor log management
    Route::get('visitor-logs/tenants-by-flat/{flat}', [VisitorLogController::class, 'tenantsByFlat'])
         ->name('visitor-logs.tenants-by-flat');
    Route::resource('visitor-logs', VisitorLogController::class)->except(['edit', 'show']);

    // Notice management
    Route::resource('notices', NoticeController::class)->except(['show']);

    // Rent payment management
    Route::get('rent-payments/tenant-by-flat/{flat}', [RentPaymentController::class, 'tenantByFlat'])
         ->name('rent-payments.tenant-by-flat');
    Route::get('rent-payments/tenant/{tenant}/history', [RentPaymentController::class, 'tenantHistory'])
         ->name('rent-payments.tenant-history');
    Route::resource('rent-payments', RentPaymentController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    // Utility bill management
    Route::get('utility-bills/flat-details/{flat}', [UtilityBillController::class, 'flatDetails'])
         ->name('utility-bills.flat-details');
    Route::patch('utility-bills/{utilityBill}/mark-paid', [UtilityBillController::class, 'markPaid'])
         ->name('utility-bills.mark-paid');
    Route::resource('utility-bills', UtilityBillController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
});

// ── Owner ────────────────────────────────────────
use App\Http\Controllers\Owner\DashboardController as OwnerDashboard;
use App\Http\Controllers\Owner\ProfileController as OwnerProfile;
use App\Http\Controllers\Owner\OwnerPanelController;

Route::prefix('owner')->name('owner.')->middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/dashboard',     [OwnerDashboard::class, 'index'])->name('dashboard');
    Route::get('/flats',         [OwnerPanelController::class, 'flats'])->name('flats');
    Route::get('/tenants',       [OwnerPanelController::class, 'tenants'])->name('tenants');
    Route::get('/rent-payments', [OwnerPanelController::class, 'rentPayments'])->name('rent-payments');
    Route::get('/utility-bills', [OwnerPanelController::class, 'utilityBills'])->name('utility-bills');
    Route::get('/complaints',    [OwnerPanelController::class, 'complaints'])->name('complaints');
    Route::get('/visitor-logs',  [OwnerPanelController::class, 'visitorLogs'])->name('visitor-logs');
    Route::get('/notices',       [OwnerPanelController::class, 'notices'])->name('notices');
    Route::get('/profile',       [OwnerProfile::class, 'index'])->name('profile');
    Route::put('/profile',       [OwnerProfile::class, 'update'])->name('profile.update');
});

// ── Employee ─────────────────────────────────────
Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard', fn() => view('employee.dashboard'))->name('dashboard');
});

// ── Tenant ───────────────────────────────────────
Route::prefix('tenant')->name('tenant.')->middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/dashboard', fn() => view('tenant.dashboard'))->name('dashboard');
});