<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller AdminDashboardController
 * Menangani konsol utama monitoring analitik trafik, pengguna aktif, dan kesehatan server platform.
 */
class AdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard analitik admin.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
