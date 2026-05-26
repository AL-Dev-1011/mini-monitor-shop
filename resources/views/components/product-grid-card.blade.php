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
    class="bg-white rounded-3xl border border-neutral-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

    {{-- CLICKABLE AREA --}}
    <a href="{{ route('products.show', $product) }}" class="block">

      <div class="p-4">

        {{-- IMAGE --}}
        <div
          class="relative bg-neutral-50 rounded-2xl overflow-hidden aspect-video mb-4 border border-neutral-100 flex items-center justify-center">

          <img src="{{ $product->image ?: 'https://placehold.co/600x400/f3f4f6/a3a3a3?text=No+Image' }}"
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
          <div class="flex flex-wrap items-baseline gap-x-1.5 text-lg font-extrabold text-black leading-tight">
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

            <button
              class="w-full h-12  text-center py-1.5 rounded-xl bg-neutral-100 border border-neutral-200 text-sm font-bold text-neutral-700 hover:bg-neutral-200 transition">
              Buy Now
            </button>
          </form>

        </div>
      @endif

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
