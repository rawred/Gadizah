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
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15', // Ensure this matches your form input
    ]);

    $cartItems = session()->get('cart', []);

    // Create the order
    $order = Order::create([
        'user_id' => auth()->id(),
        'items' => json_encode($cartItems),
        'address' => $request->address,
        'phone' => $request->phone, // Ensure this is being saved
        'status' => 'pending',
    ]);

    // Clear the cart
    session()->forget('cart');

    return redirect()->route('home')->with('success', 'Order placed successfully! Waiting for admin approval.');
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

    // Notify the user
    $order->user->notify(new OrderAccepted());

    return response()->json(['success' => true]);
}

public function rejectOrder(Order $order)
{
    foreach(json_decode($order->items) as $item) {
        Menu::where('id', $item->id)->increment('stock', $item->quantity);
    }

    // Notify the user
    $order->user->notify(new OrderRejected());

    $order->delete();
    return response()->json(['success' => true]);
}


public function codCheckout(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:15', // Add phone validation
    ]);

    $cartItems = session()->get('cart', []);

    // Create the order
    $order = Order::create([
        'user_id' => auth()->id(),
        'items' => json_encode($cartItems),
        'address' => $request->address,
        'phone' => $request->phone, // Add phone field
        'status' => 'pending'
    ]);

    // Clear the cart
    session()->forget('cart');

    return redirect()->route('welcome')->with('success', 'Order placed successfully! Waiting for admin approval.');
}

}
