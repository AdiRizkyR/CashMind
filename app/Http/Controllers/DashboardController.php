<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller DashboardController
 * Menangani pengalihan utama /dashboard berdasarkan role pengguna (Admin -> admin.dashboard, User -> user.dashboard).
 */
class DashboardController extends Controller
{
    /**
     * Mengarahkan pengguna yang telah login ke dashboard sesuai role masing-masing.
     */
    public function index(Request $request)
    {
        return redirect()->route('user.dashboard');
    }
}
