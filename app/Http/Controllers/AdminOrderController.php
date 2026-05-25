<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller {
  private function checkAdmin() {
    if (! Auth::check() || Auth::user()->role !== 'admin') {
      abort(403);
    }
  }

  public function index() {
    $this->checkAdmin();

    $orders = Order::with('user')
      ->latest()
      ->get();

    return view('admin.orders.index', compact('orders'));
  }

  public function show(Order $order) {
    $this->checkAdmin();

    $order->load(['user', 'items']);

    return view('admin.orders.show', compact('order'));
  }

  public function updateStatus(Request $request, Order $order) {
    $this->checkAdmin();

    $request->validate([
      'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
    ]);

    $order->update([
      'status' => $request->status,
    ]);

    return back()->with('success', 'Order status updated.');
  }
}