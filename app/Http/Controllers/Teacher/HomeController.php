<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('teachers.dashboard', ['user' => $user]);
    }
}
