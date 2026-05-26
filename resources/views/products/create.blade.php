<x-app-layout>
  <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">

    <div class="mb-8">
      <h1 class="text-3xl font-black text-gray-900 tracking-tight">Monitor Management</h1>
      <p class="text-sm text-gray-500 mt-1">Create and preview your monitor product specifications in real-time.</p>
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

      {{-- Product Form (Left Layout) --}}
      <form action="{{ route('products.store') }}" method="POST" id="product-form"
        class="lg:col-span-7 xl:col-span-8 space-y-6">
        @csrf <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span> Basic Information
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Brand</label>
              <select name="brand"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>Dell</option>
                <option>LG</option>
                <option>Samsung</option>
                <option>ASUS</option>
                <option>AOC</option>
                <option>Acer</option>
                <option>MSI</option>
                <option>Gigabyte</option>
                <option>ViewSonic</option>
                <option>Xiaomi</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Monitor Name</label>
              <input type="text" name="name" placeholder="UltraSharp U2723QE"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Image URL</label>
            <input type="text" name="image" placeholder="https://example.com/image.jpg"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
          </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Display Specifications
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Resolution</label>
              <select name="resolution"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>6144 x 2560</option>
                <option>5120 x 1440</option>
                <option>3840 x 2160</option>
                <option>3440 x 1440</option>
                <option>2560 x 1600</option>
                <option>2560 x 1440</option>
                <option>1920 x 1200</option>
                <option>1920 x 1080</option>

              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Refresh Rate</label>
              <select name="refresh_rate"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>500 Hz</option>
                <option>360 Hz</option>
                <option>240 Hz</option>
                <option>180 Hz</option>
                <option>144 Hz</option>
                <option>100 Hz</option>
                <option>120 Hz</option>
                <option>100 Hz</option>
                <option>60 Hz</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Panel Type</label>
              <select name="panel_type"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>OLED</option>
                <option>IPS</option>
                <option>IPS Black</option>
                <option>TN</option>
                <option>VA</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Application</label>
              <select name="application"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>business / personal</option>
                <option>color grading</option>
                <option>gaming</option>
                <option>dual mode</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Display Size
                (Inches)</label>
              <input type="text" name="display_size" placeholder="24, 27, 34.5"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Aspect Ratio</label>
              <select name="aspect_ratio"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>16:9</option>
                <option>16:10</option>
                <option>21:9</option>
                <option>32:9</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Response Time</label>
              <input type="text" name="response_time" placeholder=" 1, 0.5, 4"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Screen
                Curvature</label>
              <select name="screen_curvature"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
                <option>flat screen</option>
                <option>curved</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Brightness</label>
              <input type="text" name="brightness" placeholder="400 nits or 400 cd/m²"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">
                Color Bit
              </label>

              <select name="color_bit" id="color_bit"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">

                <option value="">Select color bit</option>

                <option value="8-bit" @selected(old('color_bit', $product->color_bit ?? '') === '8-bit')>
                  8-bit
                </option>

                <option value="10-bit" @selected(old('color_bit', $product->color_bit ?? '') === '10-bit')>
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
                class="w-full rounded-2xl border-gray-200 bg-gray-100 py-3 px-4">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Contrast Ratio</label>
              <input type="text" name="contrast_ratio" placeholder="1000:1"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Weight</label>
              <input type="text" name="weight" placeholder="6.2 kg"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Accessory in Box</label>
            <input type="text" name="accessory_in_box" placeholder="e.g. HDMI cable, Power cable"
              class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
          </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-4">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Connection Types
          </h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach (['HDMI', 'DisplayPort', 'USB-C', 'Thunderbolt', 'VGA', 'USB', 'RJ45'] as $port)
              <div
                class="flex items-center justify-between border border-gray-100 rounded-2xl p-4 bg-gray-50/30 hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                  <input type="checkbox" name="connection_enable_{{ $port }}"
                    class="rounded text-blue-600 focus:ring-blue-500 border-gray-300 w-5 h-5">
                  <span class="font-semibold text-sm text-gray-700">{{ $port }}</span>
                </div>
                <input type="number" min="1" value="1" name="connection_count_{{ $port }}"
                  class="w-16 rounded-xl border-gray-200 text-center py-1.5 px-2 bg-white">
              </div>
            @endforeach
          </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-4">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Color Gamut
          </h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach (['sRGB', 'Adobe_RGB', 'DCI_P3', 'Rec_2020_BT_2020'] as $gamut)
              <div
                class="flex flex-col gap-3 border border-gray-100 rounded-2xl p-4 bg-gray-50/30 hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                  <input type="checkbox" name="gamut_enable_{{ $gamut }}"
                    class="rounded text-blue-600 focus:ring-blue-500 border-gray-300 w-5 h-5">
                  <span class="font-semibold text-xs text-gray-700 truncate">{{ str_replace('_', ' ', $gamut) }}</span>
                </div>
                <div class="relative mt-1">
                  <input type="number" min="0" max="100" placeholder="0"
                    name="gamut_percent_{{ $gamut }}"
                    class="w-full rounded-xl border-gray-200 pr-8 py-1.5 text-sm">
                  <span class="absolute right-3 top-2 text-gray-400 text-xs">%</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-4">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Dimension (W x H x D)
          </h2>
          <div class="grid grid-cols-3 gap-4">
            <div>
              <input type="number" step="0.01" name="dimension_width" placeholder="Width (mm)"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>
            <div>
              <input type="number" step="0.01" name="dimension_height" placeholder="Height (mm)"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>
            <div>
              <input type="number" step="0.01" name="dimension_depth" placeholder="Depth (mm)"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition" required>
            </div>
          </div>
        </div>

        {{-- <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
          <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
            Pricing & Discounts
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Base Price ($)</label>
              <input type="number" step="0.01" name="price" placeholder="0.00"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Discount Type</label>
              <select name="discount_type" class="w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 px-4">
                <option value="percent">Percent (%)</option>
                <option value="fixed">Fixed Amount ($)</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-2">Discount Value</label>
              <input type="number" step="0.01" name="discount" placeholder="0"
                class="w-full rounded-2xl border-gray-200 bg-gray-50/50 focus:border-blue-500 focus:ring-blue-500 py-3 px-4 transition">
            </div>
          </div>
        </div> --}}

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
          class="w-full sm:w-auto px-10 py-4 bg-gray-900 hover:bg-gray-800 text-white rounded-2xl font-bold shadow-lg shadow-gray-900/10 transition-all transform active:scale-95">
          Save Monitor Product
        </button>
      </form>

      {{-- Live Preview (Right Layout) --}}
      <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-6">

        {{-- Card Preview --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Live Card Preview</span>
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
          </div>

          <div class="p-6">
            <div
              class="relative bg-gray-50 rounded-2xl overflow-hidden aspect-video mb-5 border border-gray-100 flex items-center justify-center">
              <img id="preview-image" src="https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image"
                class="w-full h-full object-cover transition-all duration-300">
              <span id="preview-discount"
                class="absolute top-4 right-4 hidden px-3 py-1 bg-red-500 text-white text-xs rounded-full font-black shadow-sm">
                -0%
              </span>
            </div>

            <div class="space-y-1">
              <div class="flex flex-wrap gap-2">
                <p id="preview-brand" class="text-xs font-bold uppercase tracking-widest text-blue-600">BRAND</p>
                <span class="text-xs text-gray-300">|</span>
                <p id="preview-application" class="text-xs font-bold uppercase tracking-widest text-gray-500">business
                  / personal</p>
              </div>

              <div class="flex flex-wrap items-baseline gap-x-1.5 text-xl font-extrabold text-gray-900 line-clamp-1">
                <span id="preview-size-text">24"</span>
                {{-- <span id="preview-brand-text">Dell</span> --}}
                <span id="preview-name">U2426G</span>
              </div>
            </div>

            <div class="my-5 pt-4 border-t border-dashed border-gray-100">
              <div class="grid grid-cols-2 gap-y-4 gap-x-2 text-left">
                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Resolution</span>
                  <span id="preview-resolution" class="text-sm font-bold text-gray-800 block mt-0.5 truncate">-</span>
                </div>
                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Refresh Rate</span>
                  <span id="preview-refresh" class="text-sm font-bold text-gray-800 block mt-0.5 truncate">-</span>
                </div>
                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Aspect Ratio</span>
                  <span id="preview-aspect-ratio"
                    class="text-sm font-bold text-gray-800 block mt-0.5 truncate">-</span>
                </div>
                <div class="border-l-2 border-gray-200 pl-2.5">
                  <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Panel Type</span>
                  <span id="preview-panel" class="text-sm font-bold text-gray-800 block mt-0.5 truncate">-</span>
                </div>
                {{-- <div class="col-span-2 border-l-2 border-blue-500 bg-blue-50/40 p-2.5 rounded-r-xl">
                  <span class="block text-[10px] text-blue-600 font-bold uppercase tracking-wider">Color Gamut</span>
                  <span id="preview-color-gamut"
                    class="text-sm font-extrabold text-gray-800 block mt-0.5 truncate">-</span>
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
          <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Product Specifications</span>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
              <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600 w-1/3">Brands</td>
                  <td id="table-brand" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Monitor Name</td>
                  <td id="table-name" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Display Size</td>
                  <td id="table-display-size" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Resolution</td>
                  <td id="table-resolution" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Refresh Rate</td>
                  <td id="table-refresh" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Panel Type</td>
                  <td id="table-panel" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Aspect Ratio</td>
                  <td id="table-aspect-ratio" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Response Time</td>
                  <td id="table-response-time" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Screen Curvature</td>
                  <td id="table-curvature" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Brightness</td>
                  <td id="table-brightness" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Display Color</td>
                  <td id="table-color" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600 align-top">Connectivity</td>
                  <td id="table-connectivity" class="p-4 text-gray-800 space-y-0.5">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Color Gamut</td>
                  <td id="table-gamut" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Dimension (W x H x D)</td>
                  <td id="table-dimension" class="p-4 text-gray-800">-</td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition">
                  <td class="p-4 font-bold text-gray-600">Accessory in box</td>
                  <td id="table-accessory" class="p-4 text-gray-800">-</td>
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
