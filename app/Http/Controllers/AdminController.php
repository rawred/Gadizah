<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class AdminController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.dashboard', compact('menus'));

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    
        return view('admin.dashboard'); // Ensure the view exists in resources/views/admin/dashboard.blade.php
    }

    public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    });
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
