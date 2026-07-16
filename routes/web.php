<?php

use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Technician\ItemController as TechnicianItemController;
use App\Http\Controllers\Technician\LoanController as TechnicianLoanController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('items', AdminItemController::class)
            ->only(['index', 'store', 'update', 'destroy']);
        Route::resource('technicians', TechnicianController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::get('/loans', [AdminLoanController::class, 'index'])->name('loans.index');
        Route::post('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])->name('loans.approve');
        Route::post('/loans/{loan}/reject', [AdminLoanController::class, 'reject'])->name('loans.reject');
        Route::post('/loans/{loan}/return', [AdminLoanController::class, 'returnLoan'])->name('loans.return');

        Route::resource('maintenances', MaintenanceController::class)
            ->only(['index', 'store', 'destroy']);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });

    Route::prefix('teknisi')->middleware('role:teknisi')->name('teknisi.')->group(function (): void {
        Route::get('/items', [TechnicianItemController::class, 'index'])->name('items.index');
        Route::get('/loans', [TechnicianLoanController::class, 'index'])->name('loans.index');
        Route::post('/loans', [TechnicianLoanController::class, 'store'])->name('loans.store');
    });
});
