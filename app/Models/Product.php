<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
  protected $fillable = [
    'image',
    'brand',
    'name',
    'application',
    'display_size',
    'resolution',
    'refresh_rate',
    'panel_type',
    'aspect_ratio',
    'response_time',
    'screen_curvature',

    'brightness',
    'color_bit',
    'color_depth',
    'contrast_ratio',
    'accessory_in_box',
    'weight',

    'dimension_width',
    'dimension_height',
    'dimension_depth',

    'connection_types',
    'color_gamuts',

    'price',
    'discount',
    'discount_type',
    'discounted_price',
  ];

  protected $casts = [
    'connection_types' => 'array',
    'color_gamuts'     => 'array',
  ];
}