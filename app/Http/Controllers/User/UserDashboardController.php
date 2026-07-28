<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller UserDashboardController
 * Menampilkan ringkasan eksekutif keuangan personal dan enterprise pengguna.
 */
class UserDashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama pengguna.
     */
    public function index()
    {
        return view('user.dashboard');
    }
}
