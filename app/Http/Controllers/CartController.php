<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $cartItems = [];

        foreach ($cart as $itemId => $details) {
            $menuItem = Menu::find($itemId);
            if ($menuItem) {
                $cartItems[] = [
                    'id' => $itemId,
                    'name' => $menuItem->name,
                    'price' => $menuItem->price,
                    'photo' => $menuItem->photo,
                    'quantity' => $details['quantity'],
                    'stock' => $menuItem->stock,
                    'total' => $menuItem->price * $details['quantity']
                ];
                $total += $menuItem->price * $details['quantity'];
            }
        }

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
{
    $request->validate([
        'id' => 'required|exists:menus,id', // Ensure the id exists in the menus table
        'quantity' => 'nullable|integer|min:1' // Optional: Default to 1 if not provided
    ]);

    $menuItem = Menu::findOrFail($request->id);
    $quantity = $request->quantity ?? 1; // Default to 1 if quantity is not provided

    // Check stock
    if ($menuItem->stock < $quantity) {
        return response()->json(['success' => false, 'message' => 'Item out of stock']);
    }

    $cart = session()->get('cart', []);

    // Check if item already in cart
    if (isset($cart[$menuItem->id])) {
        $cart[$menuItem->id]['quantity'] += $quantity;
    } else {
        $cart[$menuItem->id] = [
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'price' => $menuItem->price,
            'photo' => $menuItem->photo,
            'quantity' => $quantity
        ];
    }

    // Decrease stock in the database
    $menuItem->stock -= $quantity;
    $menuItem->save();

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'message' => 'Item added to cart',
        'cart_count' => count($cart)
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $menuItem = Menu::findOrFail($id);
    $cart = session()->get('cart', []);

    if (!isset($cart[$id])) {
        return response()->json(['success' => false, 'message' => 'Item not found in cart']);
    }

    $oldQuantity = $cart[$id]['quantity'];
    $newQuantity = $request->quantity;
    $quantityDifference = $newQuantity - $oldQuantity;

    // Check if the new quantity is valid
    if ($quantityDifference > $menuItem->stock) {
        return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi']);
    }

    // Update cart
    $cart[$id]['quantity'] = $newQuantity;
    $cart[$id]['total'] = $menuItem->price * $newQuantity; // Update total for the item

    // Update stock
    $menuItem->stock -= $quantityDifference;
    $menuItem->save();

    // Update session cart
    session()->put('cart', $cart);

    // Recalculate the overall total
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['total'];
    }

    // Log for debugging
    \Log::info('Cart updated', [
        'cart' => $cart,
        'total' => $total,
        'menuItem' => $menuItem
    ]);

    return response()->json([
        'success' => true,
        'total' => $total
    ]);
}


public function removeFromCart($id)
{
    $cart = session()->get('cart', []);
    $menuItem = Menu::findOrFail($id);

    if (isset($cart[$id])) {
        // Return the stock to the database
        $menuItem->stock += $cart[$id]['quantity'];
        $menuItem->save();

        // Remove the item from the cart
        unset($cart[$id]);
    }

    // Update the session cart
    session()->put('cart', $cart);

    return response()->json(['success' => true, 'message' => 'Item removed from cart']);
}

public function storeCOD(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255'
    ]);

    $cartItems = session()->get('cart', []);

    $order = Order::create([
        'user_id' => auth()->id(),
        'items' => json_encode($cartItems),
        'address' => $request->address,
        'status' => 'pending'
    ]);

    session()->forget('cart');

    return redirect()->route('home')->with('success', 'Order placed successfully! Waiting for admin approval.');
}

}