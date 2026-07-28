<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Komentar Bahasa Indonesia: Menampilkan Halaman Target Tabungan & Financial Goals
     */
    public function index()
    {
        return view('user.goals');
    }
}
