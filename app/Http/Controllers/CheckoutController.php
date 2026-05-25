<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller {
  public function index() {
    $cart = session('cart', []);

    if (count($cart) === 0) {
      return redirect()->route('cart.index');
    }

    return view('checkout');
  }

  public function placeOrder(Request $request) {
    $request->validate([
      'first_name'     => ['nullable', 'string'],
      'last_name'      => ['nullable', 'string'],
      'phone'          => ['required', 'string'],
      'address'        => ['required', 'string'],
      'province'       => ['required', 'string'],
      'postal_code'    => ['required', 'string'],
      'payment_method' => ['required', 'string'],
    ]);

    $cart = session('cart', []);

    if (count($cart) === 0) {
      return redirect()->route('cart.index');
    }

    $subtotal = 0;

    foreach ($cart as $item) {
      $subtotal += $item['price'] * $item['quantity'];
    }

    $shipping = 0;
    $total    = $subtotal + $shipping;

    $fullName = trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? ''));

    $order = Order::create([
      'user_id'        => $request->user()?->id,
      'order_number'   => 'ORD-' . strtoupper(uniqid()),
      'subtotal'       => $subtotal,
      'shipping'       => $shipping,
      'total'          => $total,
      'status'         => 'pending',

      'full_name'      => $fullName ?: $request->user()?->name,
      'email'          => $request->user()?->email,
      'phone'          => $request->phone,

      'address'        => $request->address,
      'province'       => $request->province,
      'postal_code'    => $request->postal_code,

      'payment_method' => $request->payment_method,
    ]);

    foreach ($cart as $item) {
      OrderItem::create([
        'order_id'   => $order->id,
        'product_id' => $item['id'] ?? null,
        'brand'      => $item['brand'] ?? null,
        'name'       => $item['name'],
        'image'      => $item['image'] ?? null,
        'price'      => $item['price'],
        'quantity'   => $item['quantity'],
        'subtotal'   => $item['price'] * $item['quantity'],
      ]);
    }

    session()->forget('cart');

    return redirect()->route('order.success', $order);
  }
}