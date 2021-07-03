<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        // chua dang nhap ? tiep tuc : dashboard
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:teacher')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    public function showTeacherLoginForm()
    {
        return view('auth.login');
    }

    public function adminLogin(LoginRequest $request)
    {
        $validated = $request->validated();
        $remember = isset($request->remember) ? true : false;
        
        if (Auth::guard('admin')->attempt($validated, $remember)) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login.admin')->with('msg', 'not found');
    }

    public function teacherLogin(LoginRequest $request)
    {
        $validated = $request->validated();
        $remember = isset($request->remember) ? true : false;
        
        if (Auth::guard('teacher')->attempt($validated, $remember)) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login.teacher')->with('msg', 'not found');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login.teacher');
    }
}
