<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Controller LogController
 * Menangani inspeksi catatan jejak audit (audit trail) dan aktivitas pengguna di seluruh sistem.
 */
class LogController extends Controller
{
    /**
     * Menampilkan log audit sistem.
     */
    public function index()
    {
        return view('admin.logs');
    }
}
