<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Menu;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('welcome')->with('error', 'Access denied.');
        }

        $menus = Menu::all();
        return view('admin.dashboard', compact('menus'));
    }

    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        if (Auth::user()->role !== 'admin') {
            // Avoid unnecessary redirection loops
            if ($request->route()->getName() !== 'welcome') {
                return redirect()->route('welcome')->with('error', 'Unauthorized access.');
            }
        }

        return $next($request);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'photo' => 'required|image|max:2048',
        ]);

        $photoPath = $request->file('photo')->store('menu_photos', 'public');

        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Menu item added successfully!');
    }
}
