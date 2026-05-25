<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return redirect()->route('products.index');
});

/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/products', [ProductController::class, 'index'])
  ->name('products.index');

/*
|--------------------------------------------------------------------------
| PUBLIC CART ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
  ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
  ->name('cart.add');

Route::post('/cart/buy-now/{product}', [CartController::class, 'buyNow'])
  ->name('cart.buyNow');

Route::post('/cart/update/{id}', [CartController::class, 'update'])
  ->name('cart.update');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
  ->name('cart.remove');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', function () {
    return redirect()->route('products.index');
  })->name('dashboard');

  Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

  Route::post('/checkout', [CheckoutController::class, 'placeOrder'])
    ->name('checkout.placeOrder');

  Route::get('/order-success/{order}', function (Order $order) {
    abort_if($order->user_id !== auth()->id(), 403);

    $order->load('items');

    return view('order-success', compact('order'));
  })->name('order.success');

  Route::get('/my-orders', [OrderController::class, 'index'])
    ->name('orders.index');

  Route::get('/my-orders/{order}', [OrderController::class, 'show'])
    ->name('orders.show');

  Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

  Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

  Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

  /*
    |--------------------------------------------------------------------------
    | ADMIN PRODUCT ROUTES
    |--------------------------------------------------------------------------
    */

  Route::get('/products/create', [ProductController::class, 'create'])
    ->name('products.create');

  Route::post('/products', [ProductController::class, 'store'])
    ->name('products.store');

  Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

  Route::put('/products/{product}', [ProductController::class, 'update'])
    ->name('products.update');

  Route::patch('/products/{product}', [ProductController::class, 'update']);

  Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy');

  /*
    |--------------------------------------------------------------------------
    | ADMIN ORDER ROUTES
    |--------------------------------------------------------------------------
    */

  Route::get('/admin/orders', [AdminOrderController::class, 'index'])
    ->name('admin.orders.index');

  Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
    ->name('admin.orders.updateStatus');

  /*
    |--------------------------------------------------------------------------
    | ADMIN ฏASHBOARD ROUTES
    |--------------------------------------------------------------------------
    */

  Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| PRODUCT DETAIL ต้องอยู่หลัง /products/create เสมอ
|--------------------------------------------------------------------------
*/

Route::get('/products/{product}', [ProductController::class, 'show'])
  ->name('products.show');

require __DIR__ . '/auth.php';