<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $menuItem = Menu::find($item['id']);
            if ($menuItem) {
                $cartItem = [
                    'id' => $menuItem->id,
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'photo' => $menuItem->photo,
                    'stock' => $menuItem->stock,
                    'quantity' => $item['quantity'],
                    'total' => $menuItem->price * $item['quantity']
                ];
                $cartItems[] = $cartItem;
                $total += $cartItem['total'];
            }
        }

        return view('cart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate(['id' => 'required|exists:menus,id']);
        
        $menuItem = Menu::findOrFail($request->id);
        
        // Check stock
        if ($menuItem->stock < 1) {
            return response()->json(['success' => false, 'message' => 'Item out of stock']);
        }
    
        $cart = session()->get('cart', []);
        
        // Check if item already in cart
        $exists = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $request->id) {
                if ($item['quantity'] >= $menuItem->stock) {
                    return response()->json(['success' => false, 'message' => 'Maximum stock reached']);
                }
                $item['quantity']++;
                $exists = true;
                break;
            }
        }
        
        if (!$exists) {
            $cart[] = [
                'id' => $menuItem->id,
                'quantity' => 1
            ];
        }
    
        // Decrease stock in the database
        $menuItem->stock -= 1;
        $menuItem->save();
    
        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }

    public function updateCart(Request $request, $id)
    {
        $menuItem = Menu::findOrFail($id);
        $cart = session()->get('cart', []);
    
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $oldQuantity = $item['quantity'];
                $newQuantity = $request->quantity;
    
                // Calculate the difference in quantity
                $quantityDifference = $newQuantity - $oldQuantity;
    
                // Check if the new quantity exceeds stock
                if ($quantityDifference > $menuItem->stock) {
                    return response()->json(['success' => false, 'message' => 'Quantity exceeds stock']);
                }
    
                // Update the quantity in the cart
                $item['quantity'] = $newQuantity;
    
                // Update the stock in the database
                $menuItem->stock -= $quantityDifference;
                $menuItem->save();
                break;
            }
        }
    
        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        $menuItem = Menu::findOrFail($id);
    
        foreach ($cart as $index => $item) {
            if ($item['id'] == $id) {
                // Increase stock in the database
                $menuItem->stock += $item['quantity'];
                $menuItem->save();
    
                // Remove the item from the cart
                unset($cart[$index]);
                break;
            }
        }
    
        session()->put('cart', array_values($cart));
        return response()->json(['success' => true]);
    }
}