<x-app-layout>
  @php
    $finalPrice = $product->discounted_price ?? $product->price;
    $hasDiscount = $finalPrice < $product->price;
    $colorGamuts = $product->color_gamuts ?? [];
    $connections = $product->connection_types ?? [];
    $colorText = [];

    if ($product->color_bit) {
        $colorText[] = $product->color_bit;
    }

    if ($product->color_depth) {
        $colorText[] = $product->color_depth;
    }

    $shortDetail = collect([
        $product->display_size ? $product->display_size . '"' : null,
        $product->panel_type,
        $product->refresh_rate,
        $product->aspect_ratio,
        $product->resolution,
    ])
        ->filter()
        ->join(' | ');
  @endphp

  <div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      {{-- Back Button --}}
      <a href="{{ route('products.index') }}"
        class="inline-flex items-center gap-2 mb-6 text-sm font-bold text-gray-500 hover:text-black transition">
        ← Back to products
      </a>

      {{-- Layout Grid --}}
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- LEFT LAYOUT --}}
        <div class="lg:col-span-8 space-y-8">

          {{-- IMAGE CARD --}}
          <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden relative">
            <div class="bg-gray-50 p-6 flex items-center justify-center min-h-[400px] lg:min-h-[500px]">
              <img src="{{ $product->image ?: 'https://placehold.co/900x600/f3f4f6/a3a3a3?text=No+Image' }}"
                class="w-full rounded-3xl object-contain max-h-[620px]">

              {{-- ป้ายลดราคาแบบสีจาง (Soft Tone) ย้ายมาอยู่บนรูปภาพเหมือนหน้าแรก --}}
              @if ($hasDiscount)
                <span
                  class="absolute top-6 right-6 px-3 py-1 bg-red-50/90 text-red-600 border border-red-100 text-xs rounded-full font-black tracking-wide shadow-sm">
                  @if ($product->discount_type === 'percent')
                    -{{ number_format($product->discount, 0) }}%
                  @else
                    -${{ number_format($product->discount, 2) }}
                  @endif
                </span>
              @endif
            </div>
          </div>

          {{-- SPECIFICATIONS TABLE --}}
          <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 bg-gray-50 border-b border-gray-100">
              <h2 class="text-2xl font-black text-gray-900">
                Specifications
              </h2>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse text-sm">
                <tbody class="divide-y divide-gray-100">
                  <tr>
                    <td class="p-4 font-bold text-gray-600 w-1/3">Brand</td>
                    <td class="p-4 text-gray-800">{{ $product->brand }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Monitor Name</td>
                    <td class="p-4 text-gray-800">{{ $product->name }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Application</td>
                    <td class="p-4 text-gray-800">{{ $product->application ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Display Size</td>
                    <td class="p-4 text-gray-800">{{ $product->display_size ? $product->display_size . '"' : '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Resolution</td>
                    <td class="p-4 text-gray-800">{{ $product->resolution ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Refresh Rate</td>
                    <td class="p-4 text-gray-800">{{ $product->refresh_rate ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Panel Type</td>
                    <td class="p-4 text-gray-800">{{ $product->panel_type ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Aspect Ratio</td>
                    <td class="p-4 text-gray-800">{{ $product->aspect_ratio ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Response Time</td>
                    <td class="p-4 text-gray-800">{{ $product->response_time ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Screen Curvature</td>
                    <td class="p-4 text-gray-800">{{ $product->screen_curvature ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Brightness</td>
                    <td class="p-4 text-gray-800">{{ $product->brightness ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Display Color</td>
                    <td class="p-4 text-gray-800">{{ count($colorText) ? implode(' / ', $colorText) : '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600 align-top">Connectivity</td>
                    <td class="p-4 text-gray-800">
                      @forelse($connections as $name => $count)
                        <div class="flex items-center gap-2 mb-1">
                          <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                          {{ $count }} x {{ $name }}
                        </div>
                      @empty
                        -
                      @endforelse
                    </td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Color Gamut</td>
                    <td class="p-4 text-gray-800">
                      @forelse($colorGamuts as $name => $percent)
                        {{ $percent }}% {{ str_replace('_', ' ', $name) }}
                        @if (!$loop->last)
                          <span class="text-gray-300 mx-1">/</span>
                        @endif
                      @empty
                        -
                      @endforelse
                    </td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Dimension (W x H x D)</td>
                    <td class="p-4 text-gray-800">
                      @if ($product->dimension_width || $product->dimension_height || $product->dimension_depth)
                        {{ $product->dimension_width ?? 0 }} x {{ $product->dimension_height ?? 0 }} x
                        {{ $product->dimension_depth ?? 0 }} cm
                      @else
                        -
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Accessory in box</td>
                    <td class="p-4 text-gray-800">{{ $product->accessory_in_box ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td class="p-4 font-bold text-gray-600">Weight</td>
                    <td class="p-4 text-gray-800">{{ $product->weight ?? '-' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- RIGHT LAYOUT (Sticky Sidebar ลอยตามเมื่อเลื่อนจอลงไป) --}}
        <div class="lg:col-span-4 lg:sticky lg:top-8">
          <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-6">

            {{-- HEADER INFO --}}
            <div>
              <div class="flex flex-wrap gap-2 mb-2">
                <p class="text-xs font-bold uppercase tracking-widest text-blue-600">
                  {{ $product->brand }}
                </p>
                <span class="text-xs text-gray-300">|</span>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                  {{ $product->application }}
                </p>
              </div>
              <h1 class="text-3xl font-black text-gray-900 leading-tight">
                {{ $product->display_size }}" {{ $product->brand }} {{ $product->name }}
              </h1>
              <p class="mt-3 text-sm font-semibold text-gray-500">
                {{ $shortDetail }}
              </p>
            </div>

            {{-- PRICE ZONE (แก้ไข @else และนำป้ายลดราคา Soft Tone กลับมาแล้ว) --}}
            <div class="border-t border-gray-100 pt-6">
              @if ($hasDiscount)
                <div class="flex items-baseline gap-3">
                  <span class="text-4xl font-black text-gray-900 tracking-tight">
                    ${{ number_format($finalPrice, 2) }}
                  </span>
                  <span class="text-lg text-gray-400 line-through font-medium">
                    ${{ number_format($product->price, 2) }}
                  </span>
                </div>

                {{-- ป้ายแสดงจำนวนที่ลดราคา แบบสีแดงจางละมุน (Soft Tone) --}}
                <div
                  class="mt-2 inline-flex px-3 py-1 bg-red-50/80 text-red-600 border border-red-100/50 rounded-full text-xs font-black">
                  @if ($product->discount_type === 'percent')
                    -{{ number_format($product->discount, 0) }}%
                  @else
                    -${{ number_format($product->discount, 2) }}
                  @endif
                </div>
              @else
                <span class="text-4xl font-black text-gray-900 tracking-tight">
                  ${{ number_format($product->price, 2) }}
                </span>
              @endif
            </div>

            {{-- ACTIONS ZONE --}}
            <div class="space-y-5">

              {{-- ADD TO CART FORM --}}
              <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">
                    Quantity
                  </label>
                  <div class="flex items-center border border-gray-200 rounded-2xl overflow-hidden w-40">
                    <button type="button" onclick="decreaseQty()"
                      class="w-12 h-12 text-xl font-black hover:bg-gray-50 transition">
                      -
                    </button>
                    <input id="quantity" name="quantity" type="number" min="1" value="1"
                      class="w-16 h-12 text-center border-0 focus:ring-0 font-bold">
                    <button type="button" onclick="increaseQty()"
                      class="w-12 h-12 text-xl font-black hover:bg-gray-50 transition">
                      +
                    </button>
                  </div>
                </div>
                <button type="submit"
                  class="w-full bg-gray-800 hover:bg-gray-400 text-white hover:text-black py-4 mt-4 rounded-2xl font-black shadow-lg transition active:scale-95">
                  Add to Cart
                </button>
              </form>

              {{-- ADMIN CONTROLS --}}
              @auth
                @if (auth()->user()->role === 'admin')
                  <div
                    class="mt-5 pt-4 border-t border-gray-100 flex flex-col xl:flex-row items-stretch xl:items-center gap-2 xl:gap-3">

                    <a href="{{ route('products.edit', $product) }}"
                      class="flex-1 text-center px-4 py-2.5 bg-blue-50/60 hover:bg-blue-600 text-blue-600 hover:text-white rounded-2xl text-xs font-bold tracking-wider uppercase transition-all duration-200 active:scale-95">
                      Edit Spec
                    </a>

                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="w-full xl:flex-1 flex"
                      onsubmit="return confirm('Delete this product?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="w-full px-4 py-2.5 bg-red-50/60 hover:bg-red-500 text-red-600 hover:text-white rounded-2xl text-xs font-bold tracking-wider uppercase transition-all duration-200 active:scale-95">
                        Delete Product
                      </button>
                    </form>

                  </div>
                @endif
              @endauth

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  {{-- QUANTITY SCRIPT --}}
  <script>
    function increaseQty() {
      const input = document.getElementById('quantity');
      input.value = Number(input.value || 1) + 1;
    }

    function decreaseQty() {
      const input = document.getElementById('quantity');
      const current = Number(input.value || 1);
      if (current > 1) {
        input.value = current - 1;
      }
    }
  </script>
</x-app-layout>
