<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller ReportController
 * Menangani modul penyusunan dan pencetakan laporan keuangan bulanan & tahunan (Print/PDF).
 */
class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan keuangan.
     */
    public function index()
    {
        return view('user.reports');
    }
}
