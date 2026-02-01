<?php

namespace App\Http\Controllers;

class MainDisplayController extends Controller
{
    public function index()
    {
        return view('frontend.display.index');
    }
}
