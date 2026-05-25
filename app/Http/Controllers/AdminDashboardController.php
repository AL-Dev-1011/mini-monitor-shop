<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller {
  private function checkAdmin() {
    if (! auth()->guard()->check() || auth()->guard()->user()->role !== 'admin') {
      abort(403);
    }
  }

  public function index() {
    $this->checkAdmin();

    $totalProducts = Product::count();

    $totalOrders = Order::count();

    $totalUsers = User::count();

    $totalSales = Order::whereIn('status', ['paid', 'shipped', 'completed'])
      ->sum('total');

    $latestOrders = Order::latest()
      ->take(5)
      ->get();

    return view('admin.dashboard', compact(
      'totalProducts',
      'totalOrders',
      'totalUsers',
      'totalSales',
      'latestOrders'
    ));
  }
}