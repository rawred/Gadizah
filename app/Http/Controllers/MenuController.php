<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
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
