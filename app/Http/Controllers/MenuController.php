<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Middleware to ensure only admins can access these methods
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is logged in
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('welcome')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    // Display the admin dashboard
    public function index()
    {
        $menus = Menu::all();
        return view('admin.dashboard', compact('menus'));
    }


    // Show edit form
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    // Handle update request
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'required|in:FOOD,BEVERAGE',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0', // Add stock validation
        ]);
    
        try {
            $menu = Menu::findOrFail($id);
            $imageName = $menu->photo;
    
            // Handle new file upload
            if ($request->hasFile('photo')) {
                // Delete old image
                Storage::delete('public/uploads/' . $menu->photo);
    
                // Upload new image
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads', $imageName);
            }
    
            // Update database
            $menu->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'category' => $request->category,
                'photo' => $imageName,
                'stock' => $request->stock, // Add stock
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Menu updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error updating menu: ' . $e->getMessage()], 500);
        }
    }

    // Handle form submission to add a new menu item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'required|in:FOOD,BEVERAGE',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0', // Add stock validation
        ]);
    
        try {
            // Handle file upload
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads', $imageName);
            } else {
                throw new \Exception('No image file uploaded.');
            }
    
            // Insert into database
            Menu::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'category' => $request->category,
                'photo' => $imageName,
                'stock' => $request->stock, // Add stock
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Menu added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error adding menu: ' . $e->getMessage()], 500);
        }
    }

    // Fetch menu items for the welcome page
    public function welcome()
    {
        $foodItems = Menu::where('category', 'FOOD')->get();
        $beverageItems = Menu::where('category', 'BEVERAGE')->get();
        return view('welcome', compact('foodItems', 'beverageItems'));
    }

    // hapus
    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            Storage::delete('public/uploads/' . $menu->photo); // Delete the image
            $menu->delete();
            return response()->json(['status' => 'success', 'message' => 'Menu deleted!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    
}