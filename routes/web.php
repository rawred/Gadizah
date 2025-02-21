<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all will be assigned
| to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Signup Routes
Route::get('/signup', [RegisterController::class, 'showSignUpForm'])->name('signup');
Route::post('/signup', [RegisterController::class, 'register']);

// Register Route (if needed)
Route::get('/register', [RegisterController::class, 'showSignUpForm'])->name('register');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/settings', function () {
        return view('profile.settings');
    })->name('profile.settings');
});

// Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [MenuController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::delete('/admin/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
});


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout/cod', [OrderController::class, 'codCheckout'])->name('checkout.cod');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Admin routes
Route::get('/admin/orders', [OrderController::class, 'indexAdmin'])->name('admin.orders');
Route::post('/admin/orders/{order}/accept', [OrderController::class, 'acceptOrder'])->name('orders.accept');
Route::post('/admin/orders/{order}/reject', [OrderController::class, 'rejectOrder'])->name('orders.reject');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');