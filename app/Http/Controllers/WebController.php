<?php

namespace App\Http\Controllers;

class WebController extends Controller
{
    public function showHome()
    {
        return view('home');
    }
}
