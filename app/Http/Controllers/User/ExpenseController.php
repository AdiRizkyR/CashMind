<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller ExpenseController
 * Menangani modul transaksi pengeluaran harian (Cash & Transfer Bank/E-Wallet).
 */
class ExpenseController extends Controller
{
    /**
     * Menampilkan halaman pencatatan pengeluaran.
     */
    public function index()
    {
        return view('user.expenses');
    }
}
