<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {
  public function index() {
    return view('cart');
  }

  public function add(Request $request, Product $product) {
    $quantity   = max(1, (int) $request->input('quantity', 1));
    $cart       = session()->get('cart', []);
    $finalPrice = $product->discounted_price ?? $product->price;

    if (isset($cart[$product->id])) {
      $cart[$product->id]['quantity'] += $quantity;
    } else {
      $cart[$product->id] = [
        'id'           => $product->id,
        'brand'        => $product->brand,
        'name'         => $product->name,
        'display_size' => $product->display_size,
        'price'        => $finalPrice,
        'image'        => $product->image,
        'quantity'     => $quantity,
      ];
    }
    session()->put('cart', $cart);
    return redirect()->route('cart.index');
  }

  public function update(Request $request, $id) {
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
      $cart[$id]['quantity'] = max(1, (int) $request->input('quantity', 1));
      session()->put('cart', $cart);
    }
    return back();
  }

  public function remove($id) {
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
      unset($cart[$id]);
      session()->put('cart', $cart);
    }
    return back();
  }

  public function buyNow(Request $request, Product $product) {
    $this->add($request, $product);

    return redirect()->route('cart.index');
  }
}