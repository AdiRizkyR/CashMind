<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller CategoryController
 * Menangani modul pengaturan kategori pemasukan & pengeluaran kustom serta target persentase alokasi budget.
 */
class CategoryController extends Controller
{
    /**
     * Menampilkan halaman pengelolaan kategori & budget.
     */
    public function index()
    {
        return view('user.categories');
    }
}
