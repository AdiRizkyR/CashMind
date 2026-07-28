<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\IncomeController;
use App\Http\Controllers\User\ExpenseController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\GoalController;
use App\Http\Controllers\User\ReconciliationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes - CashMind Enterprise Financial System
|--------------------------------------------------------------------------
| Aturan Arsitektur: 1 Route Per Baris (Tanpa Group, Prefix, atau Middleware Closure)
| Pengecekan Middleware Auth dan Role dipasang langsung pada setiap deklarasi route.
|
*/

// Komentar Bahasa Indonesia: Route Publik Landing Page Utama
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Komentar Bahasa Indonesia: Route Router Dashboard Otomatis Berdasarkan Role User
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Komentar Bahasa Indonesia: Route User Workspace - Overview Dashboard
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route User Workspace - Pencatatan Pemasukan
Route::get('/user/income', [IncomeController::class, 'index'])->name('user.income')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route User Workspace - Pencatatan Pengeluaran
Route::get('/user/expenses', [ExpenseController::class, 'index'])->name('user.expenses')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route User Workspace - Pengaturan Kategori & Persentase Budget
Route::get('/user/categories', [CategoryController::class, 'index'])->name('user.categories')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route User Workspace - Target Tabungan & Financial Goals (MODUL BARU)
Route::get('/user/goals', [GoalController::class, 'index'])->name('user.goals')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route User Workspace - Rekonsiliasi & Audit Selisih Kas (MODUL BARU)
Route::get('/user/reconciliation', [ReconciliationController::class, 'index'])->name('user.reconciliation')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route User Workspace - Cetak Laporan Keuangan PDF
Route::get('/user/reports', [ReportController::class, 'index'])->name('user.reports')->middleware('auth', 'role:user');

// Komentar Bahasa Indonesia: Route Admin Console - Dashboard Trafik & Analytics
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth', 'role:admin');

// Komentar Bahasa Indonesia: Route Admin Console - Direktori User & Inspeksi Detail
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users')->middleware('auth', 'role:admin');

// Komentar Bahasa Indonesia: Route Admin Console - Audit Log Aktivitas System
Route::get('/admin/logs', [LogController::class, 'index'])->name('admin.logs')->middleware('auth', 'role:admin');

// Komentar Bahasa Indonesia: Route Otentikasi Bawaan Laravel Breeze
require __DIR__.'/auth.php';
