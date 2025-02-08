<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
    
            $redirectRoute = Auth::user()->role === 'admin' ? 'admin.dashboard' : 'welcome';
    
            return redirect()->route($redirectRoute)->with('success', 'Login successful');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
