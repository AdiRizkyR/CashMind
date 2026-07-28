<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReconciliationController extends Controller
{
    /**
     * Komentar Bahasa Indonesia: Menampilkan Halaman Rekonsiliasi Kas & Audit Selisih
     */
    public function index()
    {
        return view('user.reconciliation');
    }
}
