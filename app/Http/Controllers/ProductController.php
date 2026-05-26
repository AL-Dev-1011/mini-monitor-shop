<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

  //  FILTER CONFIG
  private array $filters = [

    'brand'         => [
      'Dell',
      'LG',
      'Samsung',
      'ASUS',
      'AOC',
      'Acer',
      'MSI',
      'Gigabyte',
      'ViewSonic',
      'Xiaomi',
    ],

    'application'   => [
      'business / personal',
      'color grading',
      'gaming',
    ],

    'display_size'  => [
      'less 24',
      '25 - 27',
      '30 - 32',
      '32 more',
    ],

    'resolution'    => [
      '6144 x 2560' => '6K UW (6144 x 2560)',
      '5120 x 1440' => 'DQHD (5120 x 1440)',
      '3840 x 2160' => 'UHD 4K (3840 x 2160)',
      '3840 x 1080' => 'DFHD (3840 x 1080)',
      '3440 x 1440' => 'UWQHD (3440 x 1440)',
      '2560 x 1600' => 'WQXGA (2560 x 1600)',
      '2560 x 1440' => 'QHD (2560 x 1440)',
      '2560 x 1080' => 'WFHD (2560 x 1080)',
      '1920 x 1200' => 'WUXGA (1920 x 1200)',
      '1920 x 1080' => 'FHD (1920 x 1080)',
    ],

    'refresh_rate'  => [
      '500 Hz',
      '360 Hz',
      '290 Hz',
      '240 Hz',
      '180 Hz',
      '144 Hz',
      '120 Hz',
      '100 Hz',
      '60 Hz',
    ],

    'panel_type'    => [
      'OLED',
      'IPS',
      'TN',
      'VA',
    ],

    'aspect_ratio'  => [
      '16:9',
      '16:10',
      '21:9',
      '32:9',
    ],

    'response_time' => [
      '1 ms or less',
      '2 - 4 ms',
      '5 ms more',
    ],
  ];

  // CONNECTION TYPES
  private array $connections = [
    'HDMI',
    'DisplayPort',
    'USB-C',
    'Thunderbolt',
    'VGA',
    'USB',
    'RJ45',
  ];

  // PRICE RANGES
  private array $priceRanges = [
    '61-80'    => '$61 - $80',
    '81-100'   => '$81 - $100',
    '101-200'  => '$101 - $200',
    '201-400'  => '$201 - $400',
    '401-600'  => '$401 - $600',
    '601-more' => '$601 - more',
  ];

  // --------------------------------------------------------------------------
  // PRODUCT LIST PAGE
  // --------------------------------------------------------------------------

  public function index(Request $request) {
    $query = Product::query();

    // BASIC FILTERS
    foreach ([
      'brand',
      'application',
      'resolution',
      'refresh_rate',
      'panel_type',
      'aspect_ratio',
    ] as $field) {

      if ($request->filled($field)) {
        $query->whereIn($field, (array) $request->input($field));
      }
    }

    // DISPLAY SIZE FILTER
    if ($request->filled('display_size')) {
      $query->where(function ($q) use ($request) {
        foreach ((array) $request->display_size as $range) {
          $q->orWhere(function ($sub) use ($range) {
            if ($range === 'less 24') {
              $sub->whereRaw('CAST(display_size AS DECIMAL(10,2)) <= 24');
            }
            if ($range === '25 - 27') {
              $sub->whereRaw('CAST(display_size AS DECIMAL(10,2)) BETWEEN 25 AND 27');
            }
            if ($range === '30 - 32') {
              $sub->whereRaw('CAST(display_size AS DECIMAL(10,2)) BETWEEN 30 AND 32');
            }
            if ($range === '32 more') {
              $sub->whereRaw('CAST(display_size AS DECIMAL(10,2)) >= 32');
            }
          });
        }
      });
    }

    // RESPONSE TIME FILTER
    if ($request->filled('response_time')) {
      $query->where(function ($q) use ($request) {
        foreach ((array) $request->response_time as $range) {
          $q->orWhere(function ($sub) use ($range) {
            if ($range === '1 ms or less') {
              $sub->whereRaw('CAST(response_time AS DECIMAL(10,2)) <= 1');
            }
            if ($range === '2 - 4 ms') {
              $sub->whereRaw('CAST(response_time AS DECIMAL(10,2)) BETWEEN 2 AND 4');
            }
            if ($range === '5 ms more') {
              $sub->whereRaw('CAST(response_time AS DECIMAL(10,2)) >= 5');
            }
          });
        }
      });
    }

    // CUSTOM MIN / MAX PRICE
    if ($request->filled('min_price')) {
      $query->where('discounted_price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
      $query->where('discounted_price', '<=', $request->max_price);
    }

    //  PRICE RANGE FILTER
    if ($request->filled('price_range')) {
      $query->where(function ($q) use ($request) {
        foreach ((array) $request->price_range as $range) {
          [$min, $max] = explode('-', $range);
          $q->orWhere(function ($sub) use ($min, $max) {
            $sub->where('discounted_price', '>=', $min);
            if ($max !== 'more') {
              $sub->where('discounted_price', '<=', $max);
            }
          });
        }
      });
    }

    //  CONNECTION TYPE FILTER
    if ($request->filled('connection_types')) {
      foreach ((array) $request->connection_types as $connection) {
        $query->whereRaw(
          "JSON_EXTRACT(connection_types, '$.\"$connection\"') IS NOT NULL"
        );
      }
    }

    //  SORTING

    if ($request->sort === 'lowest') {
      $query->orderBy('discounted_price');
    } elseif ($request->sort === 'highest') {
      $query->orderByDesc('discounted_price');
    } else {
      $query->latest();
    }

    //  PAGINATION
    $products = $query
      ->paginate(28)
      ->withQueryString();

    // FILTER COUNTS
    $filterCounts = $this->getFilterCounts();

    // CURRENT VIEW MODE
    $currentView = $request->input('view', 'grid');

    // ACTIVE FILTERS
    $activeFilters = $request->except(['sort', 'page', 'min_price', 'max_price', 'view', 'delete']);

    // CHECK ACTIVE FILTERS
    $hasActiveFilters = $this->hasActiveFilters(
      $request,
      $activeFilters
    );

    // RETURN VIEW
    return view('products.index', [
      'products'         => $products,
      'filters'          => $this->filters,
      'connections'      => $this->connections,
      'priceRanges'      => $this->priceRanges,
      'filterCounts'     => $filterCounts,
      'currentView'      => $currentView,
      'activeFilters'    => $activeFilters,
      'hasActiveFilters' => $hasActiveFilters,
    ]);
  }

  // --------------------------------------------------------------------------
  // SHOW PRODUCT DETAIL
  // --------------------------------------------------------------------------

  public function show(Product $product) {
    return view('products.productdetail', compact('product'));
  }

  // --------------------------------------------------------------------------
  // CREATE PRODUCT PAGE
  // --------------------------------------------------------------------------

  public function create() {
    $this->checkAdmin();

    return view('products.create');
  }

  // --------------------------------------------------------------------------
  // STORE PRODUCT
  // --------------------------------------------------------------------------

  public function store(Request $request) {
    $this->checkAdmin();

    $validated = $this->validateProduct($request);

    $data = $this->prepareProductData(
      $request,
      $validated
    );

    Product::create($data);

    return redirect()
      ->route('products.index')
      ->with('success', 'Product created successfully.');
  }

  // --------------------------------------------------------------------------
  // EDIT PRODUCT PAGE
  // --------------------------------------------------------------------------

  public function edit(Product $product) {
    $this->checkAdmin();

    return view('products.edit', compact('product'));
  }

  // --------------------------------------------------------------------------
  // UPDATE PRODUCT
  // --------------------------------------------------------------------------

  public function update(Request $request, Product $product) {
    $this->checkAdmin();

    $validated = $this->validateProduct($request);

    $data = $this->prepareProductData(
      $request,
      $validated
    );

    $product->update($data);

    return redirect()
      ->route('products.index')
      ->with('success', 'Product updated successfully.');
  }

  // --------------------------------------------------------------------------
  // DELETE PRODUCT
  // --------------------------------------------------------------------------

  public function destroy(Product $product) {
    $this->checkAdmin();

    $product->delete();

    return redirect()
      ->route('products.index')
      ->with('success', 'Product deleted successfully.');
  }

  // --------------------------------------------------------------------------
  // VALIDATE PRODUCT DATA
  // --------------------------------------------------------------------------

  private function validateProduct(Request $request) {
    return $request->validate([
      'image'            => ['nullable', 'string'],
      'brand'            => ['required', 'string'],
      'name'             => ['required', 'string'],
      'application'      => ['nullable', 'string'],
      'display_size'     => ['nullable', 'string'],
      'resolution'       => ['nullable', 'string'],
      'refresh_rate'     => ['nullable', 'string'],
      'panel_type'       => ['nullable', 'string'],
      'aspect_ratio'     => ['nullable', 'string'],
      'response_time'    => ['nullable', 'string'],
      'screen_curvature' => ['nullable', 'string'],
      'brightness'       => ['nullable', 'string'],
      'color_bit'        => ['nullable', 'string'],
      'color_depth'      => ['nullable', 'string'],
      'contrast_ratio'   => ['nullable', 'string'],
      'accessory_in_box' => ['nullable', 'string'],
      'weight'           => ['nullable', 'string'],
      'dimension_width'  => ['nullable', 'numeric'],
      'dimension_height' => ['nullable', 'numeric'],
      'dimension_depth'  => ['nullable', 'numeric'],
      'price'            => ['required', 'numeric', 'min:0'],
      'discount_type'    => ['nullable', 'in:percent,fixed'],
      'discount'         => ['nullable', 'numeric', 'min:0'],
    ]);
  }

  //  --------------------------------------------------------------------------
  //  PREPARE PRODUCT DATA
  //  --------------------------------------------------------------------------

  private function prepareProductData(
    Request $request,
    array $data
  ) {
    $data['connection_types'] = $this->prepareConnectionTypes($request);

    $data['color_gamuts'] = $this->prepareColorGamuts($request);

    // DISCOUNT CALCULATION
    $price = (float) $request->input('price', 0);

    $discount = (float) $request->input('discount', 0);

    $discountType = $request->input('discount_type', 'percent');

    if ($discount <= 0) {

      $discount = 0;

      $discountedPrice = $price;

    } elseif ($discountType === 'percent') {

      $discountedPrice = $price - ($price * $discount / 100);

    } else {

      $discountedPrice = max(0, $price - $discount);
    }

    $data['price'] = $price;

    $data['discount'] = $discount;

    $data['discount_type'] = $discountType;

    $data['discounted_price'] = $discountedPrice;

    return $data;
  }

  // --------------------------------------------------------------------------
  // PREPARE CONNECTION TYPES
  // --------------------------------------------------------------------------

  private function prepareConnectionTypes(Request $request) {
    $connectionTypes = [];

    foreach ($this->connections as $port) {

      if ($request->has("connection_enable_$port")) {

        $connectionTypes[$port] =
        (int) $request->input("connection_count_$port", 1);
      }
    }

    return $connectionTypes;
  }

  // --------------------------------------------------------------------------
  // PREPARE COLOR GAMUTS
  // --------------------------------------------------------------------------

  private function prepareColorGamuts(Request $request) {
    $gamuts = [
      'sRGB'             => 'sRGB',
      'Adobe_RGB'        => 'Adobe RGB',
      'DCI_P3'           => 'DCI-P3',
      'Rec_2020_BT_2020' => 'Rec. 2020 / BT. 2020',
    ];

    $colorGamuts = [];

    foreach ($gamuts as $formKey => $dbKey) {

      if ($request->has("gamut_enable_$formKey")) {

        $percent = $request->input("gamut_percent_$formKey");

        if ($percent !== null && $percent !== '') {

          $colorGamuts[$dbKey] = (float) $percent;
        }
      }
    }

    return $colorGamuts;
  }

  // --------------------------------------------------------------------------
  // CHECK ACTIVE FILTERS
  // --------------------------------------------------------------------------

  private function hasActiveFilters(
    Request $request,
    array $activeFilters
  ) {
    foreach ($activeFilters as $key => $values) {

      foreach ((array) $values as $value) {

        if (
          $value !== null &&
          $value !== '' &&
          $value !== '1' &&
          $key !== '_token' &&
          $key !== 'delete' &&
          strtolower($value) !== 'delete' &&
          strlen($value) < 40
        ) {
          return true;
        }
      }
    }

    return;
    $request->filled('min_price') |
    $request->filled('max_price');
  }

  // --------------------------------------------------------------------------
  // FILTER COUNTS
  // --------------------------------------------------------------------------

  private function getFilterCounts() {
    $allProducts = Product::all();

    $filterCounts = [];

    // NORMAL FILTER COUNTS
    foreach ([
      'brand',
      'application',
      'resolution',
      'refresh_rate',
      'panel_type',
      'aspect_ratio',
    ] as $field) {

      $filterCounts[$field] = $allProducts
        ->groupBy($field)
        ->map(fn($items) => $items->count())
        ->toArray();
    }

    // DISPLAY SIZE COUNTS
    $filterCounts['display_size'] = $this->countRange(
      $allProducts,
      [
        'less 24' => [null, 24],
        '25 - 27' => [25, 27],
        '30 - 32' => [30, 32],
        '32 more' => [32, null],
      ],
      'display_size'
    );

    // RESPONSE TIME COUNTS
    $filterCounts['response_time'] = $this->countRange(
      $allProducts,
      [
        '1 ms or less' => [null, 1],
        '2 - 4 ms'     => [2, 4],
        '5 ms more'    => [5, null],
      ],
      'response_time'
    );

    // PRICE RANGE COUNTS
    $filterCounts['price_range'] = $this->countRange(
      $allProducts,
      [
        '61-80'    => [61, 80],
        '81-100'   => [81, 100],
        '101-200'  => [101, 200],
        '201-400'  => [201, 400],
        '401-600'  => [401, 600],
        '601-more' => [601, null],
      ],
      'discounted_price'
    );

    // CONNECTION TYPE COUNTS;
    $filterCounts['connection_types'] = [];

    foreach ($allProducts as $product) {

      foreach (($product->connection_types ?? []) as $name => $count) {

        $filterCounts['connection_types'][$name] =
          ($filterCounts['connection_types'][$name] ?? 0) + 1;
      }
    }

    return $filterCounts;
  }

  //--------------------------------------------------------------------------
  // RANGE COUNT HELPER
  //--------------------------------------------------------------------------

  private function countRange(
    $products,
    array $ranges,
    string $field
  ) {
    $counts = [];

    foreach ($ranges as $key => [$min, $max]) {

      $counts[$key] = $products
        ->filter(function ($product) use (
          $field,
          $min,
          $max
        ) {
          $value = (float) ($product->$field ?? 0);

          if ($min !== null && $value < $min) {
            return false;
          }

          if ($max !== null && $value > $max) {
            return false;
          }

          return true;
        })
        ->count();
    }
    return $counts;
  }

  //--------------------------------------------------------------------------
  // ADMIN CHECK
  //--------------------------------------------------------------------------

  private function checkAdmin() {
    $user = \Illuminate\Support\Facades\Auth::user();
    if (! $user || $user->role !== 'admin') {
      abort(403);
    }
  }
}