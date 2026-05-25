<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
  protected $fillable = [
    'user_id',
    'order_number',
    'subtotal',
    'shipping',
    'total',
    'status',
    'full_name',
    'email',
    'phone',
    'address',
    'city',
    'province',
    'postal_code',
    'country',
    'payment_method',
  ];

  public function items() {
    return $this->hasMany(OrderItem::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }
}