<x-app-layout>
  @php
    $connections = $product->connection_types ?? [];
    $gamuts = $product->color_gamuts ?? [];

    $brands = ['Dell', 'LG', 'Samsung', 'ASUS', 'AOC', 'Acer', 'MSI', 'Gigabyte', 'ViewSonic', 'Xiaomi'];
    $applications = ['business / personal', 'color grading', 'gaming', 'dual mode'];
    $resolutions = [
        '6144 x 2560',
        '5120 x 1440',
        '3840 x 2160',
        '3840 x 1080',
        '3440 x 1440',
        '2560 x 1600',
        '2560 x 1440',
        '2560 x 1080',
        '1920 x 1200',
        '1920 x 1080',
    ];
    $refreshRates = ['500 Hz', '360 Hz', '290 Hz', '240 Hz', '180 Hz', '144 Hz', '120 Hz', '100 Hz', '60 Hz'];
    $panelTypes = ['OLED', 'IPS', 'IPS Black', 'TN', 'VA'];
    $aspectRatios = ['16:9', '16:10', '21:9', '32:9'];
    $curvatures = ['flat screen', 'curved'];
  @endphp

  <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">

    <div class="mb-8 flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">
          Edit Monitor Product
        </h1>
        <p class="text-sm text-gray-500 mt-1">
          Update monitor product specifications.
        </p>
      </div>

      <a href="{{ route('products.index') }}" class="px-5 py-3 bg-white border rounded-2xl text-sm font-bold">
        Back
      </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700">
          <p class="font-black mb-2">
            Please check required fields:
          </p>

          <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('products.update', $product) }}" method="POST" id="product-form"
        class="lg:col-span-7 xl:col-span-8 space-y-6">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Basic Information
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Brand</label>
              <select name="brand" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($brands as $brand)
                  <option value="{{ $brand }}" @selected(old('brand', $product->brand) === $brand)>
                    {{ $brand }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Monitor Name</label>
              <input type="text" name="name" value="{{ old('name', $product->name) }}"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Image URL</label>
            <input type="text" name="image" value="{{ old('image', $product->image) }}"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
          </div>
        </div>

        {{-- Display Specifications --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Display Specifications
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Resolution</label>
              <select name="resolution" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($resolutions as $resolution)
                  <option value="{{ $resolution }}" @selected(old('resolution', $product->resolution) === $resolution)>
                    {{ $resolution }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Refresh Rate</label>
              <select name="refresh_rate" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($refreshRates as $refreshRate)
                  <option value="{{ $refreshRate }}" @selected(old('refresh_rate', $product->refresh_rate) === $refreshRate)>
                    {{ $refreshRate }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Panel Type</label>
              <select name="panel_type" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($panelTypes as $panelType)
                  <option value="{{ $panelType }}" @selected(old('panel_type', $product->panel_type) === $panelType)>
                    {{ $panelType }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Application</label>
              <select name="application" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($applications as $application)
                  <option value="{{ $application }}" @selected(old('application', $product->application) === $application)>
                    {{ $application }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                Display Size
              </label>
              <input type="text" name="display_size" value="{{ old('display_size', $product->display_size) }}"
                placeholder="e.g. 24, 27, 34.5" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4"
                required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Aspect Ratio</label>
              <select name="aspect_ratio" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($aspectRatios as $aspectRatio)
                  <option value="{{ $aspectRatio }}" @selected(old('aspect_ratio', $product->aspect_ratio) === $aspectRatio)>
                    {{ $aspectRatio }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Response Time</label>
              <input type="text" name="response_time" value="{{ old('response_time', $product->response_time) }}"
                placeholder="e.g. 1 ms" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Screen
                Curvature</label>
              <select name="screen_curvature" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                @foreach ($curvatures as $curvature)
                  <option value="{{ $curvature }}" @selected(old('screen_curvature', $product->screen_curvature) === $curvature)>
                    {{ $curvature }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Brightness</label>
              <input type="text" name="brightness" value="{{ old('brightness', $product->brightness) }}"
                placeholder="e.g. 400 nits" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                Color Bit
              </label>

              @php
                $currentColorBit = old('color_bit', $product->color_bit ?? '');

                $normalizedColorBit = match (strtolower(str_replace(' ', '', $currentColorBit))) {
                    '8bit' => '8-bit',
                    '10bit' => '10-bit',
                    default => $currentColorBit,
                };
              @endphp

              <select name="color_bit" id="color_bit"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">

                <option value="">Select color bit</option>

                <option value="8-bit" @selected($normalizedColorBit === '8-bit')>
                  8-bit
                </option>

                <option value="10-bit" @selected($normalizedColorBit === '10-bit')>
                  10-bit
                </option>

              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                Color Depth
              </label>

              <input type="text" name="color_depth" id="color_depth"
                value="{{ old('color_depth', $product->color_depth ?? '') }}" readonly
                class="w-full rounded-2xl border-gray-200 bg-gray-100 py-3 px-4" required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Contrast Ratio</label>
              <input type="text" name="contrast_ratio" value="{{ old('contrast_ratio', $product->contrast_ratio) }}"
                placeholder="e.g. 1000:1" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Weight</label>
              <input type="text" name="weight" value="{{ old('weight', $product->weight) }}"
                placeholder="e.g. 6.2 kg" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Accessory in Box</label>
            <input type="text" name="accessory_in_box"
              value="{{ old('accessory_in_box', $product->accessory_in_box) }}"
              placeholder="e.g. HDMI cable, Power cable"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
          </div>
        </div>

        {{-- Connection Types --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-4">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Connection Types
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach (['HDMI', 'DisplayPort', 'USB-C', 'Thunderbolt', 'VGA', 'USB', 'RJ45'] as $port)
              <div class="flex items-center justify-between border border-gray-100 rounded-2xl p-4 bg-gray-50/30">
                <div class="flex items-center gap-3">
                  <input type="checkbox" name="connection_enable_{{ $port }}" @checked(isset($connections[$port]))
                    class="rounded text-blue-600 border-gray-300 w-5 h-5">

                  <span class="font-semibold text-sm text-gray-700">
                    {{ $port }}
                  </span>
                </div>

                <input type="number" min="1" name="connection_count_{{ $port }}"
                  value="{{ old('connection_count_' . $port, $connections[$port] ?? 1) }}"
                  class="w-16 rounded-xl border-gray-200 text-center py-1.5 px-2 bg-white">
              </div>
            @endforeach
          </div>
        </div>

        {{-- Color Gamut --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-4">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Color Gamut
          </h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach ([
        'sRGB' => 'sRGB',
        'Adobe_RGB' => 'Adobe RGB',
        'DCI_P3' => 'DCI-P3',
        'Rec_2020_BT_2020' => 'Rec. 2020 / BT. 2020',
    ] as $formKey => $dbKey)
              <div class="flex flex-col gap-3 border border-gray-100 rounded-2xl p-4 bg-gray-50/30">
                <div class="flex items-center gap-3">
                  <input type="checkbox" name="gamut_enable_{{ $formKey }}" @checked(isset($gamuts[$dbKey]))
                    class="rounded text-blue-600 border-gray-300 w-5 h-5">

                  <span class="font-semibold text-xs text-gray-700 truncate">
                    {{ $dbKey }}
                  </span>
                </div>

                <div class="relative mt-1">
                  <input type="number" min="0" max="100" name="gamut_percent_{{ $formKey }}"
                    value="{{ old('gamut_percent_' . $formKey, $gamuts[$dbKey] ?? '') }}"
                    class="w-full rounded-xl border-gray-200 pr-8 py-1.5 text-sm">

                  <span class="absolute right-3 top-2 text-gray-400 text-xs">%</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Dimension --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-4">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Dimension (W x H x D)
          </h2>

          <div class="grid grid-cols-3 gap-4">
            <input type="number" step="0.01" name="dimension_width"
              value="{{ old('dimension_width', $product->dimension_width) }}" placeholder="Width (cm)"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>

            <input type="number" step="0.01" name="dimension_height"
              value="{{ old('dimension_height', $product->dimension_height) }}" placeholder="Height (cm)"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>

            <input type="number" step="0.01" name="dimension_depth"
              value="{{ old('dimension_depth', $product->dimension_depth) }}" placeholder="Depth (cm)"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4" required>
          </div>
        </div>

        {{-- Pricing --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Pricing & Discounts
          </h2>

          <input type="hidden" name="discount_type" value="fixed">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                Base Price ($) <span class="text-red-500">*</span>
              </label>

              <input type="number" step="0.01" min="0" name="price"
                value="{{ old('price', $product->price ?? '') }}" placeholder="0.00" required
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                Discount Amount ($)
              </label>

              <input type="number" step="0.01" min="0" name="discount"
                value="{{ old('discount', $product->discount ?? 0) }}" placeholder="Example: 50"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">

              <p class="mt-2 text-xs text-gray-400 font-semibold">
                Fixed discount only. Example: 50 = $50 off.
              </p>
            </div>
          </div>
        </div>

        <button
          class="w-full sm:w-auto px-10 py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-2xl font-bold shadow-lg">
          Update Monitor Product
        </button>
      </form>

      {{-- Live Preview --}}
      <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-6">

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Live Card Preview</span>
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
          </div>

          <div class="p-6">
            <div class="relative bg-gray-50 rounded-2xl overflow-hidden aspect-video mb-5 border border-gray-100">
              <img id="preview-image"
                src="{{ $product->image ?: 'https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image' }}"
                class="w-full h-full object-cover">

              <span id="preview-discount"
                class="absolute top-4 right-4 hidden px-3 py-1 bg-red-500 text-white text-xs rounded-full font-black">
                -0%
              </span>
            </div>

            <div class="space-y-1">
              <div class="flex flex-wrap gap-2">
                <p id="preview-brand" class="text-xs font-bold uppercase tracking-widest text-blue-600">BRAND</p>
                <span class="text-xs text-gray-300">|</span>
                <p id="preview-application" class="text-xs font-bold uppercase tracking-widest text-gray-500">
                  business / personal
                </p>
              </div>

              <div class="flex flex-wrap items-baseline gap-x-1.5 text-xl font-extrabold text-gray-900">
                <span id="preview-size-text">Monitor size</span>
                <span id="preview-brand-text">Monitor brand</span>
                <span id="preview-name">Monitor name</span>
              </div>
            </div>

            <div class="my-5 pt-4 border-t border-dashed border-gray-100">
              <div class="grid grid-cols-2 gap-y-4 gap-x-2 text-left">
                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase">Resolution</span>
                  <span id="preview-resolution" class="text-sm font-bold text-gray-800">-</span>
                </div>

                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase">Refresh Rate</span>
                  <span id="preview-refresh" class="text-sm font-bold text-gray-800">-</span>
                </div>

                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase">Aspect Ratio</span>
                  <span id="preview-aspect-ratio" class="text-sm font-bold text-gray-800">-</span>
                </div>

                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase">Panel Type</span>
                  <span id="preview-panel" class="text-sm font-bold text-gray-800">-</span>
                </div>

                {{-- <div class="col-span-2 border-l-2 border-blue-500 bg-blue-50/40 p-2.5 rounded-r-xl">
                  <span class="block text-[10px] text-blue-600 font-bold uppercase">Color Gamut</span>
                  <span id="preview-color-gamut" class="text-sm font-extrabold text-gray-800">-</span>
                </div> --}}
              </div>
            </div>

            <div class="flex items-baseline gap-2 mt-4">
              <span id="preview-price" class="text-3xl font-black text-gray-900">$0.00</span>
              <span id="preview-original-price" class="text-sm text-gray-400 line-through hidden">$0.00</span>
            </div>
          </div>
        </div>

        {{-- Specifications Preview --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="p-4 bg-gray-50 border-b border-gray-100">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">
              Product Specifications
            </span>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
              <tbody class="divide-y divide-gray-100">
                <tr>
                  <td class="p-4 font-bold text-gray-600">Brand</td>
                  <td id="table-brand" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Monitor Name</td>
                  <td id="table-name" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Display Size</td>
                  <td id="table-display-size" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Resolution</td>
                  <td id="table-resolution" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Refresh Rate</td>
                  <td id="table-refresh" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Panel Type</td>
                  <td id="table-panel" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Aspect Ratio</td>
                  <td id="table-aspect-ratio" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Response Time</td>
                  <td id="table-response-time" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Screen Curvature</td>
                  <td id="table-curvature" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Brightness</td>
                  <td id="table-brightness" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Display Color</td>
                  <td id="table-color" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Connectivity</td>
                  <td id="table-connectivity" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Color Gamut</td>
                  <td id="table-gamut" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Dimension</td>
                  <td id="table-dimension" class="p-4">-</td>
                </tr>
                <tr>
                  <td class="p-4 font-bold text-gray-600">Accessory</td>
                  <td id="table-accessory" class="p-4">-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  @vite(['resources/js/product.js'])
</x-app-layout>
