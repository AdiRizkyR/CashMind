<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    /**
     * Display landing page.
     */
    public function index()
    {
        return view('welcome');
    }
}
