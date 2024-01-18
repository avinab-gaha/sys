<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;

class AdminController extends Controller
{

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    //     $credentials = $request->only('email', 'password');
    //     if (Auth::guard('admin')->attempt($credentials)) {
    //         $user = Admin::where('email', $request->input('email'))->first();
    //         Auth::guard('admin')->login($user);
    //         return view(route('admin.dashboard'));
    //     } else {
    //         return view(route('admin.login'));
    //     }
    // }

    // public function logout()
    // {
    //     Auth::guard('admin')->logout();
    //     return redirect()->route('admin.login')->with('success', 'logout successfully');
    // }
}
