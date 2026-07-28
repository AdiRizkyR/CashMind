<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller IncomeController
 * Menangani modul pencatatan dan pengelolaan sumber pemasukan mandiri pengguna.
 */
class IncomeController extends Controller
{
    /**
     * Menampilkan halaman pencatatan pemasukan.
     */
    public function index()
    {
        return view('user.income');
    }
}
