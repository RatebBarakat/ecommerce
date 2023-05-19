<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email,
        'password' => $request->password])) {
            $admin = Admin::where('email',$request->email)->first();
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect('/admin')->with('success','admin login successfull');
        }elseif (Auth::attempt(['email' => $request->email,
        'password' => $request->password])) {
            $user = User::where('email',$request->email)->first();
            Auth::login($user);
            $request->session()->regenerate();
            return back()->with('success','login successfull');
        }
        else {
            return back()->with('fail','incorrect data');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
