<x-app-layout>
  @php
    $currentView = request('view', 'grid');

    $filters = [
        'brand' => ['Dell', 'LG', 'Samsung', 'ASUS', 'AOC', 'Acer', 'MSI', 'Gigabyte', 'ViewSonic', 'Xiaomi'],
        'application' => ['business / personal', 'color grading', 'gaming'],
        'display_size' => ['less 24', '25 - 27', '30 - 32', '32 more'],
        'resolution' => [
            '6144 x 2560' => '6K UW (6144 x 2560)',
            '5120 x 1440' => 'DQHD (5120 x 1440)',
            '3840 x 2160' => 'UHD 4K (3840 x 2160)',
            '3840 x 1080' => 'DFHD (3840 x 1080)',
            '3440 x 1440' => 'UWQHD (3440 x 1440)',
            '2560 x 1600' => 'WQXGA (2560 x 1600)', // 16:10
            '2560 x 1440' => 'QHD (2560 x 1440)',
            '2560 x 1080' => 'WFHD (2560 x 1080)',
            '1920 x 1200' => 'WUXGA (1920 x 1200)', // 16:10
            '1920 x 1080' => 'FHD (1920 x 1080)',
        ],
        'refresh_rate' => ['500 Hz', '360 Hz', '290 Hz', '240 Hz', '180 Hz', '144 Hz', '120 Hz', '100 Hz', '60 Hz'],
        'panel_type' => ['OLED', 'IPS', 'TN', 'VA'],
        'aspect_ratio' => ['16:9', '16:10', '21:9', '32:9'],
        'response_time' => ['1 ms or less', '2 - 4 ms', '5 ms more'],
    ];

    $connections = ['HDMI', 'DisplayPort', 'USB-C', 'Thunderbolt', 'VGA', 'USB', 'RJ45'];

    $priceRanges = [
        '61-80' => '$61 - $80',
        '81-100' => '$81 - $100',
        '101-200' => '$101 - $200',
        '201-400' => '$201 - $400',
        '401-600' => '$401 - $600',
        '601-more' => '$601 - more',
    ];

    $activeFilters = request()->except(['sort', 'page', 'min_price', 'max_price', '_token', 'view', 'delete']);

    $hasActiveFilters = false;

    foreach ($activeFilters as $key => $values) {
        foreach ((array) $values as $value) {
            if ($value !== null && $value !== '' && $value !== '1' && $key !== '_token' && strlen($value) < 40) {
                $hasActiveFilters = true;
            }
        }
    }

    if (request('min_price') || request('max_price')) {
        $hasActiveFilters = true;
    }

    function removeFilterUrl($key, $removeValue = null)
    {
        $query = request()->query();

        if ($removeValue === null) {
            unset($query[$key]);
        } else {
            $values = (array) ($query[$key] ?? []);

            $values = array_values(
                array_filter($values, function ($value) use ($removeValue) {
                    return $value !== $removeValue;
                }),
            );

            if (count($values)) {
                $query[$key] = $values;
            } else {
                unset($query[$key]);
            }
        }

        return route('products.index', $query);
    }
  @endphp

  <div class="bg-white min-h-screen">
    <div class="max-w-[1600px] mx-auto px-4 py-8">

      @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
          {{ session('success') }}
        </div>
      @endif

      <form method="GET" id="filter-form">
        <input type="hidden" name="view" value="{{ $currentView }}">
        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] xl:grid-cols-[240px_1fr] gap-6 items-start">

          {{-- /*
          |--------------------------------------------------------------------------
          | FILTER SIDEBAR
          |--------------------------------------------------------------------------
          */ --}}
          <aside class="space-y-3 lg:sticky lg:top-6">

            {{-- FILTER HEADER --}}
            <div class="flex items-center gap-3">
              <h2 class="text-2xl font-black text-black">
                Filters
              </h2>

              @if ($hasActiveFilters)
                <a href="{{ route('products.index') }}" class="text-sm font-bold text-blue-600 hover:underline">
                  Clear All
                </a>
              @endif
            </div>

            {{-- ACTIVE TAGS --}}
            @if ($hasActiveFilters)
              <div class="flex flex-wrap gap-2">

                @foreach ($activeFilters as $key => $values)
                  @foreach ((array) $values as $value)
                    @if (
                        $value !== null &&
                            $value !== '' &&
                            $value !== '1' &&
                            $key !== '_token' &&
                            $key !== 'delete' &&
                            strtolower($value) !== 'delete' &&
                            strlen($value) < 40)
                      @php
                        $tagLabel = $value;

                        if ($key === 'price_range') {
                            $tagLabel = $priceRanges[$value] ?? $value;
                        }

                        if ($key === 'resolution') {
                            $tagLabel = $filters['resolution'][$value] ?? $value;
                        }
                      @endphp

                      <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-300 text-blue-700 text-xs font-bold rounded-lg">

                        {{ $tagLabel }}

                        <a href="{{ removeFilterUrl($key, $value) }}" class="text-blue-700 hover:text-black">
                          ×
                        </a>
                      </span>
                    @endif
                  @endforeach
                @endforeach

                @if (request('min_price') || request('max_price'))
                  <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-300 text-blue-700 text-xs font-bold rounded-lg">

                    ${{ request('min_price') ?? 0 }}
                    -
                    ${{ request('max_price') ?? 'more' }}

                    <a href="{{ route('products.index', request()->except(['min_price', 'max_price'])) }}"
                      class="text-blue-700 hover:text-black">
                      ×
                    </a>
                  </span>
                @endif

              </div>
            @endif

            {{-- PRICE FILTER --}}
            <details open class="bg-white border border-neutral-200 rounded-2xl overflow-hidden ">
              <summary class="cursor-pointer p-4 font-black flex justify-between items-center">
                Price
                <span>⌄</span>
              </summary>

              <div class="p-4 space-y-3 border-t border-neutral-200">

                @foreach ($priceRanges as $value => $label)
                  <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="price_range[]" value="{{ $value }}" @checked(in_array($value, request('price_range', [])))
                      onchange="document.getElementById('filter-form').submit()"
                      class="rounded border-neutral-300 text-blue-600">

                    <span>
                      {{ $label }} ({{ $filterCounts['price_range'][$value] ?? 0 }})
                    </span>
                  </label>
                @endforeach

                <div class="grid grid-cols-2 gap-2 pt-3">
                  <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                    class="rounded-xl border-neutral-200 text-sm">

                  <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                    class="rounded-xl border-neutral-200 text-sm">
                </div>

                <button type="submit" class="w-full py-2.5 bg-black text-white rounded-xl text-sm font-black">
                  Apply Price
                </button>

              </div>
            </details>

            {{-- NORMAL FILTERS --}}
            @foreach ($filters as $field => $options)
              <details open class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
                <summary class="cursor-pointer p-4 font-black flex justify-between items-center capitalize">
                  {{ str_replace('_', ' ', $field) }}
                  <span>⌄</span>
                </summary>

                <div class="p-4 space-y-3 border-t border-neutral-200">

                  @foreach ($options as $value => $label)
                    @php
                      if (is_int($value)) {
                          $value = $label;
                      }
                    @endphp

                    <label class="flex items-center gap-3 text-sm">
                      <input type="checkbox" name="{{ $field }}[]" value="{{ $value }}"
                        @checked(in_array($value, request($field, []))) onchange="document.getElementById('filter-form').submit()"
                        class="rounded border-neutral-300 text-blue-600">

                      <span>
                        {{ $label }} ({{ $filterCounts[$field][$value] ?? 0 }})
                      </span>
                    </label>
                  @endforeach

                </div>
              </details>
            @endforeach

            {{-- CONNECTION TYPES --}}
            <details open class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
              <summary class="cursor-pointer p-4 font-black flex justify-between items-center">
                Connection Types
                <span>⌄</span>
              </summary>

              <div class="p-4 space-y-3 border-t border-neutral-200">

                @foreach ($connections as $connection)
                  <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="connection_types[]" value="{{ $connection }}"
                      @checked(in_array($connection, request('connection_types', []))) onchange="document.getElementById('filter-form').submit()"
                      class="rounded border-neutral-300 text-blue-600">

                    <span>
                      {{ $connection }} ({{ $filterCounts['connection_types'][$connection] ?? 0 }})
                    </span>
                  </label>
                @endforeach

              </div>
            </details>

          </aside>


          {{-- /*
          |--------------------------------------------------------------------------
          | MAIN AREA
          |--------------------------------------------------------------------------
          */ --}}
          <main>

            {{-- TOP BAR --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

              <div>
                <h1 class="text-3xl font-black text-black">
                  Monitor Products
                </h1>
              </div>

              <div class="flex items-center gap-4">

                @php
                  $currentView = request('view', 'grid');
                @endphp

                <div class="flex items-center gap-2">
                  <a href="{{ route('products.index', array_merge(request()->query(), ['view' => 'grid'])) }}"
                    class="relative inline-flex items-center justify-center w-11 h-11 rounded-2xl 
                    {{ $currentView === 'grid' ? ' bg-gray-100 hover:bg-gray-200 text-gray-700' : 'bg-white text-gray-700 border-neutral-200' }}">
                    <span class="material-symbols-outlined text-[22px]">
                      grid_view
                    </span>
                  </a>

                  <a href="{{ route('products.index', array_merge(request()->query(), ['view' => 'list'])) }}"
                    class="relative inline-flex items-center justify-center w-11 h-11 rounded-2xl 
                    {{ $currentView === 'list' ? 'bg-gray-100 hover:bg-gray-200 text-gray-700' : 'bg-white text-gray-700 border-neutral-200' }}">
                    <span class="material-symbols-outlined text-[22px] ">
                      view_list
                    </span>
                  </a>

                </div>
                <div>
                  <select name="sort" onchange="document.getElementById('filter-form').submit()"
                    class="rounded-xl border-neutral-300 text-sm">
                    <option value="">Newest</option>
                    <option value="lowest" @selected(request('sort') === 'lowest')>
                      Lowest Price
                    </option>
                    <option value="highest" @selected(request('sort') === 'highest')>
                      Highest Price
                    </option>
                  </select>
                </div>

              </div>
            </div>

            {{-- 
            |--------------------------------------------------------------------------
            | MAIN CONTENT 
            |-------------------------------------------------------------------------- --}}

            @if ($products->count())
              <div
                class="
                {{ request('view', 'grid') === 'list'
                    ? 'space-y-3'
                    : 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-3' }}">

                @foreach ($products as $product)
                  @php
                    $finalPrice = $product->discounted_price ?? $product->price;
                    $hasDiscount = $finalPrice < $product->price;
                    $colorGamuts = $product->color_gamuts ?? [];
                    $resolutionLabel = $filters['resolution'][$product->resolution] ?? $product->resolution;
                  @endphp

                  @if (request('view', 'grid') === 'list')
                    {{-- LIST CARD --}}
                    <div
                      class="bg-white border border-neutral-100 rounded-3xl overflow-hidden hover:shadow-xl transition-all duration-300">
                      <div
                        class="grid grid-cols-1 lg:grid-cols-[160px_1fr_160px] xl:grid-cols-[240px_1fr_220px] gap-6 lg:gap-3 p-5 items-center">

                        {{-- IMAGE ZONE --}}
                        <a href="{{ route('products.show', $product) }}"
                          class="block bg-neutral-50 rounded-2xl border border-neutral-100/60 overflow-hidden aspect-video relative group shrink-0">
                          <img
                            src="{{ $product->image ?: 'https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image' }}"
                            class="w-full h-full object-contain group-hover:scale-105 transition duration-300">

                          @if ($hasDiscount)
                            <span
                              class="absolute top-3 right-3 px-2.5 py-0.5 bg-red-50 text-red-600 text-[11px] rounded-lg font-black border border-red-100/80 shadow-xs">
                              @if ($product->discount_type === 'percent')
                                -{{ number_format($product->discount, 0) }}%
                              @else
                                -${{ number_format($product->discount, 2) }}
                              @endif
                            </span>
                          @endif
                        </a>

                        {{-- PRODUCT INFO ZONE --}}
                        <div class="min-w-0 py-1">
                          {{-- BRAND & CATEGORY --}}
                          <div class="flex items-center gap-2 mb-1.5">
                            <p class="text-[11px] font-black uppercase tracking-wider text-blue-600">
                              {{ $product->brand }}
                            </p>
                            <span class="text-neutral-200 text-xs">/</span>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-neutral-400">
                              {{ $product->application }}
                            </p>
                          </div>

                          {{-- TITLE --}}
                          <a href="{{ route('products.show', $product) }}">
                            <h2
                              class="text-xl font-black text-neutral-900 leading-snug hover:text-blue-600 transition truncate">
                              {{ $product->display_size }}" {{ $product->brand }} {{ $product->name }}
                            </h2>
                          </a>

                          {{-- TECH SPECS BADGES --}}
                          <div class="flex flex-wrap gap-1.5 mt-3">
                            <span
                              class="px-2.5 py-1 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-600">
                              {{ $product->resolution ?? '-' }}
                            </span>
                            <span
                              class="px-2.5 py-1 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-600">
                              {{ $product->refresh_rate ?? '-' }}
                            </span>
                            <span
                              class="px-2.5 py-1 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-600">
                              {{ $product->panel_type ?? '-' }}
                            </span>
                            <span
                              class="px-2.5 py-1 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-600">
                              {{ $product->response_time . ' ms' ?? '-' }}
                            </span>
                            @if (!empty($product->color_gamuts))
                              @foreach ($product->color_gamuts as $name => $value)
                                <span
                                  class="px-2.5 py-1 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-500">
                                  {{ $name }} {{ $value }}%
                                </span>
                              @endforeach
                            @endif
                            @if ($product->brightness)
                              <span
                                class="px-2.5 py-1 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-medium text-neutral-500">
                                {{ $product->brightness }}
                              </span>
                            @endif
                          </div>

                          {{-- CONNECTIONS & COLOR GAMUT --}}
                          <div class="flex flex-wrap items-center gap-1.5 mt-2.5">
                            {{-- Connections --}}
                            @if (!empty($product->connection_types))
                              @foreach ($product->connection_types as $name => $count)
                                <span
                                  class="px-2 py-0.5 rounded-lg bg-neutral-100 text-[10px] font-bold text-neutral-500">
                                  {{ $name }} X {{ $count }}
                                </span>
                              @endforeach
                            @endif

                          </div>
                        </div>

                        {{-- PRICE & ACTION ZONE --}}
                        <div
                          class="xl:border-l xl:border-neutral-100 xl:pl-6 flex flex-col justify-between h-full py-1">
                          {{-- PRICE TAG --}}
                          <div class="xl:text-right">
                            <div class="flex items-baseline gap-2 xl:justify-end">
                              <p class="text-2xl font-black text-neutral-900">
                                ${{ number_format($finalPrice, 2) }}
                              </p>
                              @if ($hasDiscount)
                                <p class="text-xs text-neutral-400 line-through">
                                  ${{ number_format($product->price, 2) }}
                                </p>
                              @endif
                            </div>
                            @if ($hasDiscount)
                              <p class="text-[11px] font-black text-green-600 mt-0.5">
                                @if ($product->discount_type === 'percent')
                                  Save {{ number_format($product->discount, 0) }}%
                                @else
                                  Save ${{ number_format($product->discount, 2) }}
                                @endif
                              </p>
                            @endif
                          </div>

                          {{-- BUTTON ACTIONS --}}
                          <div class="mt-4 space-y-2">

                            @if (!auth()->check() || auth()->user()->role !== 'admin')
                              <div class="grid grid-cols-[48px_1fr] gap-2">
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                                  @csrf
                                  <input type="hidden" name="quantity" value="1">
                                  <button
                                    class="w-full h-11 rounded-xl bg-neutral-50 hover:bg-neutral-100 border border-neutral-200/60 transition flex items-center justify-center group active:scale-95">
                                    <span
                                      class="material-symbols-outlined text-[20px] text-neutral-600 group-hover:text-neutral-900">
                                      shopping_cart
                                    </span>
                                  </button>
                                </form>
                                <form action="{{ route('cart.buyNow', $product) }}" method="POST" class="w-full">
                                  @csrf
                                  <input type="hidden" name="quantity" value="1">
                                  <button
                                    class="w-full h-11 rounded-xl bg-neutral-900 text-white text-xs font-black hover:bg-neutral-800 transition active:scale-95 shadow-xs">
                                    Buy Now
                                  </button>
                                </form>
                              </div>
                            @endif

                            {{-- ADMIN CONTROLS --}}
                            @auth
                              @if (auth()->user()->role === 'admin')
                                <div class="grid grid-cols-2 gap-2 pt-1 border-t border-neutral-100">
                                  <a href="{{ route('products.edit', $product) }}"
                                    class="text-center py-1.5 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-bold text-neutral-600 hover:bg-neutral-100 transition">
                                    Edit
                                  </a>
                                  <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Delete this product?')" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                      class="w-full py-1.5 rounded-xl bg-red-50 text-red-600 border border-red-100 text-xs font-bold hover:bg-red-100 transition">
                                      Delete
                                    </button>
                                  </form>
                                </div>
                              @endif
                            @endauth
                          </div>

                        </div>

                      </div>
                    </div>
                  @else
                    {{-- 
                    |--------------------------------------------------------------------------
                    | PUBLIC CART ROUTES
                    |-------------------------------------------------------------------------- --}}

                    <div
                      class="bg-white rounded-3xl border border-neutral-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                      {{-- CLICKABLE AREA --}}
                      <a href="{{ route('products.show', $product) }}" class="block">

                        <div class="p-4">

                          {{-- IMAGE --}}
                          <div
                            class="relative bg-neutral-50 rounded-2xl overflow-hidden aspect-video mb-4 border border-neutral-100 flex items-center justify-center">

                            <img
                              src="{{ $product->image ?: 'https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image' }}"
                              class="w-full h-full object-contain transition-all duration-300">

                            @if ($hasDiscount)
                              <span
                                class="absolute top-3 right-3 px-2.5 py-1 bg-red-500 text-white text-[11px] rounded-full font-black tracking-wide shadow-sm">

                                @if ($product->discount_type === 'percent')
                                  -{{ number_format($product->discount, 0) }}%
                                @else
                                  -${{ number_format($product->discount, 2) }}
                                @endif

                              </span>
                            @endif

                          </div>

                          {{-- TITLE --}}
                          <div class="space-y-1">
                            <div class="flex flex-wrap gap-2">
                              <p class="text-[11px] font-bold uppercase tracking-widest text-blue-600">
                                {{ $product->brand }}
                              </p>
                              <span class="text-xs text-neutral-300">|</span>
                              <p class="text-[11px] font-bold uppercase tracking-widest text-neutral-500">
                                {{ $product->application }}
                              </p>
                            </div>
                            <div
                              class="flex flex-wrap items-baseline gap-x-1.5 text-lg font-extrabold text-black leading-tight">
                              <span>
                                {{ $product->display_size }}"
                              </span>
                              <span>
                                {{ $product->name }}
                              </span>
                            </div>
                          </div>

                          {{-- SPECS --}}
                          <div class="my-4 pt-4 border-t border-dashed border-neutral-200">
                            <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-left">

                              <div class="border-l-2 border-neutral-200 pl-2">
                                <span class="block text-[9px] text-neutral-400 font-bold uppercase tracking-wider">
                                  Resolution
                                </span>
                                <span class="text-xs font-bold text-neutral-800 block mt-0.5 truncate">
                                  {{ $resolutionLabel ?? '-' }}
                                </span>
                              </div>

                              <div class="border-l-2 border-neutral-200 pl-2">
                                <span class="block text-[9px] text-neutral-400 font-bold uppercase tracking-wider">
                                  Refresh Rate
                                </span>
                                <span class="text-xs font-bold text-neutral-800 block mt-0.5 truncate">
                                  {{ $product->refresh_rate ?? '-' }}
                                </span>
                              </div>

                              <div class="border-l-2 border-neutral-200 pl-2">
                                <span class="block text-[9px] text-neutral-400 font-bold uppercase tracking-wider">
                                  Aspect Ratio
                                </span>
                                <span class="text-xs font-bold text-neutral-800 block mt-0.5 truncate">
                                  {{ $product->aspect_ratio ?? '-' }}
                                </span>
                              </div>

                              <div class="border-l-2 border-neutral-200 pl-2">
                                <span class="block text-[9px] text-neutral-400 font-bold uppercase tracking-wider">
                                  Panel Type
                                </span>
                                <span class="text-xs font-bold text-neutral-800 block mt-0.5 truncate">
                                  {{ $product->panel_type ?? '-' }}
                                </span>
                              </div>

                            </div>
                          </div>

                          {{-- PRICE --}}
                          <div class="flex items-baseline gap-2 mt-3">
                            <span class="text-2xl font-black text-black">
                              ${{ number_format($finalPrice, 2) }}
                            </span>

                            @if ($hasDiscount)
                              <span class="text-xs text-neutral-400 line-through">
                                ${{ number_format($product->price, 2) }}
                              </span>
                            @endif

                          </div>

                        </div>
                      </a>

                      {{-- CARD ACTIONS --}}
                      <div class="px-4 pb-4 space-y-3">

                        @if (!auth()->check() || auth()->user()->role !== 'admin')
                          <div class="grid grid-cols-[52px_1fr] gap-3">

                            <form action="{{ route('cart.add', $product) }}" method="POST">
                              @csrf

                              <input type="hidden" name="quantity" value="1">

                              <button
                                class="w-full h-12 rounded-2xl bg-neutral-100 text-neutral-700 border border-neutral-200 text-sm font-black hover:bg-neutral-200 transition flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">
                                  shopping_cart
                                </span>
                              </button>
                            </form>

                            <form action="{{ route('cart.buyNow', $product) }}" method="POST">
                              @csrf

                              <input type="hidden" name="quantity" value="1">

                              {{-- <button
                                class="w-full h-12 rounded-2xl bg-black text-white text-sm font-black hover:bg-neutral-800 transition">
                                Buy Now
                              </button> --}}
                              <button
                                class="w-full h-12  text-center py-1.5 rounded-xl bg-neutral-100 border border-neutral-200 text-sm font-bold text-neutral-700 hover:bg-neutral-200 transition">
                                Buy Now
                              </button>
                            </form>

                          </div>
                        @endif

                        {{-- ADMIN CONTROLS --}}
                        @auth
                          @if (auth()->user()->role === 'admin')
                            <div class="grid grid-cols-2 gap-2 pt-1 border-t border-neutral-100">
                              <a href="{{ route('products.edit', $product) }}"
                                class="text-center py-1.5 rounded-xl bg-neutral-50 border border-neutral-100 text-xs font-bold text-neutral-600 hover:bg-neutral-100 transition">
                                Edit
                              </a>
                              <form action="{{ route('products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Delete this product?')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button
                                  class="w-full py-1.5 rounded-xl bg-red-50 text-red-600 border border-red-100 text-xs font-bold hover:bg-red-100 transition">
                                  Delete
                                </button>
                              </form>
                            </div>
                          @endif
                        @endauth

                      </div>

                    </div>
                  @endif
                @endforeach


              </div>

              <div class="mt-10">
                {{ $products->links() }}
              </div>
            @else
              <div class="bg-white border border-neutral-200 rounded-3xl p-12 text-center">
                <h2 class="text-2xl font-black text-black">
                  No products found
                </h2>

                <p class="mt-2 text-neutral-500">
                  Try clearing filters or changing your search options.
                </p>

                <a href="{{ route('products.index') }}"
                  class="inline-flex mt-6 px-6 py-3 bg-black text-white rounded-2xl font-black">
                  Clear Filters
                </a>
              </div>
            @endif

          </main>

        </div>
      </form>

    </div>
  </div>
</x-app-layout>
