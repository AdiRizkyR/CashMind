<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller UserController
 * Menangani direktori pengguna terdaftar, inspeksi statistik kas pengguna, serta pengelolaan role dan status akun.
 */
class UserController extends Controller
{
    /**
     * Menampilkan direktori pengguna.
     */
    public function index()
    {
        return view('admin.users');
    }
}
