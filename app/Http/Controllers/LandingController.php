<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller LandingController
 * Menangani tampilan halaman utama (Landing Page) publik aplikasi CashMind.
 */
class LandingController extends Controller
{
    /**
     * Menampilkan halaman utama publik.
     */
    public function index()
    {
        return view('welcome');
    }
}
