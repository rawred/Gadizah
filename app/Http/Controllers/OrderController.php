<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;


class OrderController extends Controller
{
// app/Http/Controllers/OrderController.php

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
    
    return redirect()->route('home')->with('success', 'Order placed successfully!');
}

public function indexAdmin()
{
    $orders = Order::with('user')->where('status', 'pending')->get();
    return view('admin.orders', compact('orders'));
}

public function acceptOrder(Order $order)
{
    $order->update(['status' => 'accepted']);
    // Send notification to user
    return response()->json(['success' => true]);
}

public function rejectOrder(Order $order)
{
    // Restore stock
    foreach(json_decode($order->items) as $item) {
        Menu::where('id', $item->id)->increment('stock', $item->quantity);
    }
    
    $order->delete();
    // Send notification to user
    return response()->json(['success' => true]);
}
}
