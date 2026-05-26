@php
  $hasDiscount = $product->discount > 0;

  $finalPrice = $product->discounted_price ?? $product->price;

  $discountPercent = 0;

  if ($hasDiscount && $product->price > 0) {
      $discountPercent = round((($product->price - $finalPrice) / $product->price) * 100);
  }

  $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

<div>
  <div
    class="bg-white border border-neutral-100 rounded-3xl overflow-hidden hover:shadow-xl transition-all duration-300">
    <div
      class="grid grid-cols-1 lg:grid-cols-[160px_1fr_160px] xl:grid-cols-[240px_1fr_220px] gap-6 lg:gap-3 p-5 items-center">

      {{-- IMAGE ZONE --}}
      <a href="{{ route('products.show', $product) }}"
        class="block bg-neutral-50 rounded-2xl border border-neutral-100/60 overflow-hidden aspect-video relative group shrink-0">
        <img src="{{ $product->image ?: 'https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image' }}"
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
          <h2 class="text-xl font-black text-neutral-900 leading-snug hover:text-blue-600 transition truncate">
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
              <span class="px-2 py-0.5 rounded-lg bg-neutral-100 text-[10px] font-bold text-neutral-500">
                {{ $name }} X {{ $count }}
              </span>
            @endforeach
          @endif

        </div>
      </div>

      {{-- PRICE & ACTION ZONE --}}
      <div class="xl:border-l xl:border-neutral-100 xl:pl-6 flex flex-col justify-between h-full py-1">
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
                  <span class="material-symbols-outlined text-[20px] text-neutral-600 group-hover:text-neutral-900">
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
</div>