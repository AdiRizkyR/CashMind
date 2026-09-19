<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\SecurityLogController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\BudgetController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\GoalController;
use App\Http\Controllers\User\ReconciliationController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - CashMind v2 Financial Management System
|--------------------------------------------------------------------------
| Aturan Arsitektur: 1 Route Per Baris
| Pengecekan Middleware Auth, Active Status, dan Role dipasang pada setiap route.
|
*/

// Public Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Automatic Role Router
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// ==================== USER WORKSPACE (/app/...) ====================
Route::get('/app/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class); // Alias

// Transactions
Route::get('/app/transactions', [TransactionController::class, 'index'])->name('user.transactions.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/transactions', [TransactionController::class, 'store'])->name('user.transactions.store')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::put('/app/transactions/{transaction}', [TransactionController::class, 'update'])->name('user.transactions.update')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::delete('/app/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('user.transactions.destroy')->middleware('auth', 'role:user', EnsureUserIsActive::class);

// Accounts / Wallets
Route::get('/app/accounts', [AccountController::class, 'index'])->name('user.accounts.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/accounts', [AccountController::class, 'store'])->name('user.accounts.store')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::put('/app/accounts/{account}', [AccountController::class, 'update'])->name('user.accounts.update')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::delete('/app/accounts/{account}', [AccountController::class, 'destroy'])->name('user.accounts.destroy')->middleware('auth', 'role:user', EnsureUserIsActive::class);

// Budget Planning
Route::get('/app/budget', [BudgetController::class, 'index'])->name('user.budget.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/budget', [BudgetController::class, 'store'])->name('user.budget.store')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::delete('/app/budget/{budget}', [BudgetController::class, 'destroy'])->name('user.budget.destroy')->middleware('auth', 'role:user', EnsureUserIsActive::class);

// Categories
Route::get('/app/categories', [CategoryController::class, 'index'])->name('user.categories.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/categories', [CategoryController::class, 'store'])->name('user.categories.store')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/categories/{category}/toggle-system', [CategoryController::class, 'toggleSystem'])->name('user.categories.toggle-system')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::put('/app/categories/{category}', [CategoryController::class, 'update'])->name('user.categories.update')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::delete('/app/categories/{category}', [CategoryController::class, 'destroy'])->name('user.categories.destroy')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/user/categories', [CategoryController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class); // Alias

// Financial Goals
Route::get('/app/goals', [GoalController::class, 'index'])->name('user.goals.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/goals', [GoalController::class, 'store'])->name('user.goals.store')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/goals/{goal}/contribute', [GoalController::class, 'contribute'])->name('user.goals.contribute')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::delete('/app/goals/{goal}', [GoalController::class, 'destroy'])->name('user.goals.destroy')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/user/goals', [GoalController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class); // Alias

// Account Reconciliation
Route::get('/app/reconciliation', [ReconciliationController::class, 'index'])->name('user.reconciliation.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::post('/app/reconciliation', [ReconciliationController::class, 'store'])->name('user.reconciliation.store')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/user/reconciliation', [ReconciliationController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class); // Alias

// Financial Reports
Route::get('/app/reports', [ReportController::class, 'index'])->name('user.reports.index')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/app/reports/csv', [ReportController::class, 'exportCsv'])->name('user.reports.csv')->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/user/reports', [ReportController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class); // Alias

// Legacy aliases for income & expenses pages -> redirecting to unified transactions view
Route::get('/user/income', [TransactionController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class);
Route::get('/user/expenses', [TransactionController::class, 'index'])->middleware('auth', 'role:user', EnsureUserIsActive::class);

// ==================== ADMIN CONSOLE (/admin/...) ====================
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth', 'role:admin');
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('auth', 'role:admin');
Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show')->middleware('auth', 'role:admin');
Route::post('/admin/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status')->middleware('auth', 'role:admin');
Route::post('/admin/users/{user}/reset-link', [AdminUserController::class, 'sendResetLink'])->name('admin.users.reset-link')->middleware('auth', 'role:admin');

Route::get('/admin/master-data', [MasterDataController::class, 'index'])->name('admin.master.index')->middleware('auth', 'role:admin');
Route::post('/admin/master-data/institution', [MasterDataController::class, 'storeInstitution'])->name('admin.master.institution.store')->middleware('auth', 'role:admin');
Route::post('/admin/master-data/promote-institution', [MasterDataController::class, 'promoteInstitution'])->name('admin.master.institution.promote')->middleware('auth', 'role:admin');
Route::put('/admin/master-data/institution/{institution}', [MasterDataController::class, 'updateInstitution'])->name('admin.master.institution.update')->middleware('auth', 'role:admin');
Route::delete('/admin/master-data/institution/{institution}', [MasterDataController::class, 'destroyInstitution'])->name('admin.master.institution.destroy')->middleware('auth', 'role:admin');
Route::post('/admin/master-data/category-template', [MasterDataController::class, 'storeCategoryTemplate'])->name('admin.master.category.store')->middleware('auth', 'role:admin');
Route::post('/admin/master-data/promote-category', [MasterDataController::class, 'promoteCategoryTemplate'])->name('admin.master.category.promote')->middleware('auth', 'role:admin');
Route::delete('/admin/master-data/category-template/{category}', [MasterDataController::class, 'destroyCategoryTemplate'])->name('admin.master.category.destroy')->middleware('auth', 'role:admin');

Route::get('/admin/features', [FeatureController::class, 'index'])->name('admin.features.index')->middleware('auth', 'role:admin');
Route::post('/admin/features/{feature}/toggle', [FeatureController::class, 'toggle'])->name('admin.features.toggle')->middleware('auth', 'role:admin');

Route::get('/admin/logs', [SecurityLogController::class, 'index'])->name('admin.logs.index')->middleware('auth', 'role:admin');

// Laravel Breeze Auth Routes
require __DIR__.'/auth.php';
