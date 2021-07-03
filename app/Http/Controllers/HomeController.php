<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', ['user' => $user]);
    }
}
