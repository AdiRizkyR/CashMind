<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page (Public)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Protected Routes (Must be logged in)
Route::middleware(['auth'])->group(function () {

    // Default Dashboard Router
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // USER SUB-PAGES
    Route::get('/user/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/user/income', function () { return view('user.income'); })->name('user.income');
    Route::get('/user/expenses', function () { return view('user.expenses'); })->name('user.expenses');
    Route::get('/user/categories', function () { return view('user.categories'); })->name('user.categories');
    Route::get('/user/reports', function () { return view('user.reports'); })->name('user.reports');

    // ADMIN SUB-PAGES
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/admin/users', function () { return view('admin.users'); })->name('admin.users');
    Route::get('/admin/logs', function () { return view('admin.logs'); })->name('admin.logs');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
