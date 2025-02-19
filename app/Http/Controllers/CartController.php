<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $item = $request->all();
        $cart = session()->get('cart', []);
        $cart[] = $item;
        session()->put('cart', $cart);
        return response()->json(['success' => true]);
    }
}