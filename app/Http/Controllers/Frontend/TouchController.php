<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class TouchController extends Controller
{
    public function index()
    {
        $services = Service::active()->latest()->get();
        
        return view('frontend.touch.index', compact('services'));
    }
}
