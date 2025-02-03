<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function welcome()
    {
        $menus = Menu::all(); // Fetch menu items
        return view('welcome', compact('menus')); // Pass the variable
    }
    

    public function login(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log in with the provided credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Check the user's role
            if (Auth::user()->role === 'admin') {
                // Redirect to the admin dashboard for admins
                return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
            }

            // Redirect to the welcome page for regular users
            return redirect()->route('welcome')->with('success', 'Login successful');
        }

        // If login fails, redirect back with an error
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout()
    {
        // Log out the user and redirect to the login page
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
