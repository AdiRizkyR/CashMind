<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\MasterDataController;
use App\Http\Controllers\User\ReconciliationController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - CashMind v2 System (Strictly 5 Core System Menus)
|--------------------------------------------------------------------------
| 1. Dashboard (/app/dashboard)
| 2. Income & Expenses (/app/income-expenses)
| 3. Master Data (/app/master-data)
| 4. Usage Summary (/app/usage-summary)
| 5. Missing Budget (/app/missing-budget)
|
*/

// Public Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Automatic Role Router
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// ==================== USER WORKSPACE (/app/...) ====================

// 1. Dashboard (Overview Periode Aktif)
Route::get('/app/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard')->middleware('auth', EnsureUserIsActive::class);
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->middleware('auth', EnsureUserIsActive::class);

// 2. Income & Expenses (Tab Income, Tab Expenses, Transfer Dana)
Route::get('/app/income-expenses', [TransactionController::class, 'index'])->name('user.transactions.index')->middleware('auth', EnsureUserIsActive::class);
Route::get('/app/transactions', [TransactionController::class, 'index'])->middleware('auth', EnsureUserIsActive::class);
Route::post('/app/transactions', [TransactionController::class, 'store'])->name('user.transactions.store')->middleware('auth', EnsureUserIsActive::class);
Route::put('/app/transactions/{transaction}', [TransactionController::class, 'update'])->name('user.transactions.update')->middleware('auth', EnsureUserIsActive::class);
Route::delete('/app/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('user.transactions.destroy')->middleware('auth', EnsureUserIsActive::class);

// Category Budget Allocation inside Income & Expenses
Route::post('/app/budget', [\App\Http\Controllers\User\TransactionController::class, 'storeBudget'])->name('user.budget.store')->middleware('auth', EnsureUserIsActive::class);

// 3. Master Data (Kategori Income, Kategori Expenses, Dompet Digital, Rekening Bank)
Route::get('/app/master-data', [MasterDataController::class, 'index'])->name('user.master-data.index')->middleware('auth', EnsureUserIsActive::class);
Route::post('/app/categories', [CategoryController::class, 'store'])->name('user.categories.store')->middleware('auth', EnsureUserIsActive::class);
Route::post('/app/categories/{category}/toggle-system', [CategoryController::class, 'toggleSystem'])->name('user.categories.toggle-system')->middleware('auth', EnsureUserIsActive::class);
Route::put('/app/categories/{category}', [CategoryController::class, 'update'])->name('user.categories.update')->middleware('auth', EnsureUserIsActive::class);
Route::delete('/app/categories/{category}', [CategoryController::class, 'destroy'])->name('user.categories.destroy')->middleware('auth', EnsureUserIsActive::class);

Route::post('/app/accounts', [AccountController::class, 'store'])->name('user.accounts.store')->middleware('auth', EnsureUserIsActive::class);
Route::put('/app/accounts/{account}', [AccountController::class, 'update'])->name('user.accounts.update')->middleware('auth', EnsureUserIsActive::class);
Route::delete('/app/accounts/{account}', [AccountController::class, 'destroy'])->name('user.accounts.destroy')->middleware('auth', EnsureUserIsActive::class);

// 4. Usage Summary (Analisis Bulanan, Poin Positif, Poin Perhatian, Cash vs Transfer, Export)
Route::get('/app/usage-summary', [ReportController::class, 'index'])->name('user.reports.index')->middleware('auth', EnsureUserIsActive::class);
Route::get('/app/reports/csv', [ReportController::class, 'exportCsv'])->name('user.reports.csv')->middleware('auth', EnsureUserIsActive::class);

// 5. Missing Budget (Deteksi Selisih Saldo & Rekonsiliasi)
Route::get('/app/missing-budget', [ReconciliationController::class, 'index'])->name('user.reconciliation.index')->middleware('auth', EnsureUserIsActive::class);
Route::post('/app/missing-budget', [ReconciliationController::class, 'store'])->name('user.reconciliation.store')->middleware('auth', EnsureUserIsActive::class);

// User Profile
Route::get('/app/profile', [UserProfileController::class, 'index'])->name('user.profile.index')->middleware('auth', EnsureUserIsActive::class);
Route::post('/app/profile', [UserProfileController::class, 'update'])->name('user.profile.update')->middleware('auth', EnsureUserIsActive::class);

// Laravel Breeze Auth Routes
require __DIR__.'/auth.php';
