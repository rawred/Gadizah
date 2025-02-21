<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Notifications\OrderAccepted;
use App\Notifications\OrderRejected;


class OrderController extends Controller
{
// app/Http/Controllers/OrderController.php

public function index()
{
    $orders = Order::where('user_id', auth()->id())->get();
    return view('orders.index', compact('orders'));
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
    
    return redirect()->route('home')->with('success', 'Order placed successfully!');
}

// app/Http/Controllers/OrderController.php

public function indexAdmin()
{
    $orders = Order::with('user')->where('status', 'pending')->get();
    return view('admin.order', compact('orders'));
}

public function acceptOrder(Order $order)
{
    $order->update(['status' => 'accepted']);
    return response()->json(['success' => true]);
}

public function rejectOrder(Order $order)
{
    foreach(json_decode($order->items) as $item) {
        Menu::where('id', $item->id)->increment('stock', $item->quantity);
    }
    $order->delete();
    return response()->json(['success' => true]);
}

public function codCheckout(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255'
    ]);

    $cartItems = session()->get('cart', []);

    // Create the order
    $order = Order::create([
        'user_id' => auth()->id(),
        'items' => json_encode($cartItems),
        'address' => $request->address,
        'status' => 'pending'
    ]);

    // Clear the cart
    session()->forget('cart');

    return redirect()->route('welcome')->with('success', 'Order placed successfully! Waiting for admin approval.');
}

}
