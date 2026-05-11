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

Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('admins', SuperAdminController::class);
    Route::patch('admins/{admin}/toggle-status', [SuperAdminController::class, 'toggleStatus'])
         ->name('admins.toggle-status');
});

// ── Admin ────────────────────────────────────────
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\FlatController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\OwnerController;

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
});

// ── Owner ────────────────────────────────────────
Route::prefix('owner')->name('owner.')->middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/dashboard', fn() => view('owner.dashboard'))->name('dashboard');
});

// ── Employee ─────────────────────────────────────
Route::prefix('employee')->name('employee.')->middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/dashboard', fn() => view('employee.dashboard'))->name('dashboard');
});

// ── Tenant ───────────────────────────────────────
Route::prefix('tenant')->name('tenant.')->middleware(['auth', 'role:tenant'])->group(function () {
    Route::get('/dashboard', fn() => view('tenant.dashboard'))->name('dashboard');
});