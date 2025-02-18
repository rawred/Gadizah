<?php

namespace App\Http\Controllers;
use App\Models\Menu;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // WelcomeController.php
public function welcome()
{
    $foodItems = Menu::where('category', 'FOOD')->get();
    $beverageItems = Menu::where('category', 'BEVERAGE')->get();
    return view('welcome', compact('foodItems', 'beverageItems'));
}
}
