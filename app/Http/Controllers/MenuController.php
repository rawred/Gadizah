<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
{
    $menus = Menu::all();
    return view('admin.dashboard', compact('menus'));
}


public function store(Request $request)
{
    $menu = Menu::create([
        'name' => $request->name,
        'price' => $request->price,
        'photo' => $request->file('photo')->store('menu_photos', 'public'),
    ]);

    return response()->json($menu);
}

public function destroy($id)
{
    Menu::findOrFail($id)->delete();
    return response()->json(['success' => true]);
}


    public function update(Request $request, $id)
{
    $menu = Menu::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'photo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('menu_photos', 'public');
        $menu->photo = $photoPath;
    }

    $menu->name = $validated['name'];
    $menu->price = $validated['price'];
    $menu->save();

    return redirect()->route('dashboard')->with('success', 'Menu updated successfully!');
}




}

