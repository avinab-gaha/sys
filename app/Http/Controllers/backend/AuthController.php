<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\SysUser;

class AuthController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Email not valid',
                'password.required' => 'Password is required'
            ];

            $this->validate($request, $rules, $customMessages);
            $credentials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->route('admin_dashboard');
            } else {
                return redirect()->route('admin_login')->withErrors('error_message', 'Invalid email or password');
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return view('admin.login');
    }
}

