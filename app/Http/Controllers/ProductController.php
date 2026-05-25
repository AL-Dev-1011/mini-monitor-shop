<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller {
  private function checkAdmin() {
    if (! Auth::check() || Auth::user()->role !== 'admin') {
      abort(403);
    }
  }

  public function index(Request $request) {
    $products = Product::query();

    // normal filters
    foreach ([
      'brand',
      'application',
      'resolution',
      'refresh_rate',
      'panel_type',
      'aspect_ratio',
    ] as $field) {
      if ($request->filled($field)) {
        $products->whereIn($field, (array) $request->input($field));
      }
    }

    // display size filter
    if ($request->filled('display_size')) {
      $products->where(function ($query) use ($request) {
        foreach ((array) $request->display_size as $range) {
          $query->orWhere(function ($subQuery) use ($range) {
            if ($range === 'less 24') {
              $subQuery->whereRaw('CAST(display_size AS DECIMAL(10,2)) <= 24');
            }

            if ($range === '23 - 24') {
              $subQuery->whereRaw('CAST(display_size AS DECIMAL(10,2)) BETWEEN 23 AND 24');
            }

            if ($range === '25 - 27') {
              $subQuery->whereRaw('CAST(display_size AS DECIMAL(10,2)) BETWEEN 25 AND 27');
            }
            if ($range === '30 - 32') {
              $subQuery->whereRaw('CAST(display_size AS DECIMAL(10,2)) BETWEEN 30 AND 32');
            }

            if ($range === '32 more') {
              $subQuery->whereRaw('CAST(display_size AS DECIMAL(10,2)) >= 32');
            }
          });
        }
      });
    }

    // response time filter
    if ($request->filled('response_time')) {
      $products->where(function ($query) use ($request) {
        foreach ((array) $request->response_time as $range) {
          $query->orWhere(function ($subQuery) use ($range) {
            if ($range === '1 ms or less') {
              $subQuery->whereRaw('CAST(response_time AS DECIMAL(10,2)) <= 1');
            }

            if ($range === '2 - 4 ms') {
              $subQuery->whereRaw('CAST(response_time AS DECIMAL(10,2)) BETWEEN 2 AND 4');
            }

            if ($range === '5 ms more') {
              $subQuery->whereRaw('CAST(response_time AS DECIMAL(10,2)) >= 5');
            }
          });
        }
      });
    }

    // price input filter
    if ($request->filled('min_price')) {
      $products->where('discounted_price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
      $products->where('discounted_price', '<=', $request->max_price);
    }

    // price range filter
    if ($request->filled('price_range')) {
      $products->where(function ($query) use ($request) {
        foreach ((array) $request->price_range as $range) {
          [$min, $max] = explode('-', $range);

          $query->orWhere(function ($subQuery) use ($min, $max) {
            $subQuery->where('discounted_price', '>=', $min);

            if ($max !== 'more') {
              $subQuery->where('discounted_price', '<=', $max);
            }
          });
        }
      });
    }

    // connection types filter
    if ($request->filled('connection_types')) {
      foreach ((array) $request->connection_types as $connection) {
        $products->whereRaw(
          "JSON_EXTRACT(connection_types, '$.\"$connection\"') IS NOT NULL"
        );
      }
    }

    // sort
    if ($request->sort === 'lowest') {
      $products->orderBy('discounted_price');
    } elseif ($request->sort === 'highest') {
      $products->orderByDesc('discounted_price');
    } else {
      $products->latest();
    }

    $products = $products
      ->paginate(22)
      ->withQueryString();

    $filterCounts = $this->getFilterCounts();

    return view('products.index', compact('products', 'filterCounts'));
  }

  public function create() {
    $this->checkAdmin();

    return view('products.create');
  }

  public function store(Request $request) {
    $this->checkAdmin();

    $data = $this->validateProduct($request);

    $data = $this->prepareProductData($request, $data);

    Product::create($data);

    return redirect()
      ->route('products.index')
      ->with('success', 'Product created successfully.');
  }

  public function show(Product $product) {
    return view('products.productdetail', compact('product'));
  }

  public function edit(Product $product) {
    $this->checkAdmin();

    return view('products.edit', compact('product'));
  }

  public function update(Request $request, Product $product) {
    $this->checkAdmin();

    $data = $this->validateProduct($request);

    $data = $this->prepareProductData($request, $data);

    $product->update($data);

    return redirect()
      ->route('products.index')
      ->with('success', 'Product updated successfully.');
  }

  public function destroy(Product $product) {
    $this->checkAdmin();

    $product->delete();

    return redirect()
      ->route('products.index')
      ->with('success', 'Product deleted successfully.');
  }

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

  private function prepareProductData(Request $request, array $data) {
    $data['connection_types'] = $this->prepareConnectionTypes($request);
    $data['color_gamuts']     = $this->prepareColorGamuts($request);

    $price        = (float) $request->input('price', 0);
    $discount     = (float) $request->input('discount', 0);
    $discountType = $request->input('discount_type', 'percent');

    if ($discount <= 0) {
      $discount        = 0;
      $discountedPrice = $price;
    } elseif ($discountType === 'percent') {
      $discountedPrice = $price - ($price * $discount / 100);
    } else {
      $discountedPrice = max(0, $price - $discount);
    }

    $data['price']            = $price;
    $data['discount']         = $discount;
    $data['discount_type']    = $discountType;
    $data['discounted_price'] = $discountedPrice;

    return $data;
  }

  private function prepareConnectionTypes(Request $request) {
    $ports = ['HDMI', 'DisplayPort', 'USB-C', 'Thunderbolt', 'VGA', 'USB', 'RJ45'];

    $connectionTypes = [];

    foreach ($ports as $port) {
      if ($request->has("connection_enable_$port")) {
        $connectionTypes[$port] = (int) $request->input("connection_count_$port", 1);
      }
    }

    return $connectionTypes;
  }

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

  private function getFilterCounts() {
    $allProducts = Product::all();

    $filterCounts = [];

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

    // display size counts
    $displayRanges = [
      'less 24' => [null, 24],
      '23 - 24' => [23, 24],
      '25 - 27' => [25, 27],
      '30 - 32' => [30, 32],
      '32 more' => [32, null],
    ];

    $filterCounts['display_size'] = [];

    foreach ($displayRanges as $key => [$min, $max]) {
      $filterCounts['display_size'][$key] = $allProducts
        ->filter(function ($product) use ($min, $max) {
          $value = (float) $product->display_size;

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

    // response time counts
    $responseRanges = [
      '1 ms or less' => [null, 1],
      '2 - 4 ms'     => [2, 4],
      '5 ms more'    => [5, null],
    ];

    $filterCounts['response_time'] = [];

    foreach ($responseRanges as $key => [$min, $max]) {
      $filterCounts['response_time'][$key] = $allProducts
        ->filter(function ($product) use ($min, $max) {
          $value = (float) $product->response_time;

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

    // price counts
    $priceRanges = [
      '61-80'    => [61, 80],
      '81-100'   => [81, 100],
      '101-200'  => [101, 200],
      '201-400'  => [201, 400],
      '401-600'  => [401, 600],
      '601-more' => [601, null],
    ];

    $filterCounts['price_range'] = [];

    foreach ($priceRanges as $key => [$min, $max]) {
      $filterCounts['price_range'][$key] = $allProducts
        ->filter(function ($product) use ($min, $max) {
          $price = $product->discounted_price ?? $product->price;

          if ($max === null) {
            return $price >= $min;
          }

          return $price >= $min && $price <= $max;
        })
        ->count();
    }

    // connection counts
    $filterCounts['connection_types'] = [];

    foreach ($allProducts as $product) {
      foreach (($product->connection_types ?? []) as $name => $count) {
        $filterCounts['connection_types'][$name] =
          ($filterCounts['connection_types'][$name] ?? 0) + 1;
      }
    }

    return $filterCounts;
  }
}

// อะไรบ้างที่ ควรลบจาก products/ index แล้วเอาไปใส่ใน productcontroller
// เอา productController มาทั้งหน้า