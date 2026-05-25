<x-app-layout>
  @php
    $cart = session('cart', []);
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
  @endphp

  <div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

      {{-- HEADER --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
        <div>
          <h1 class="text-4xl font-black tracking-tight text-gray-900">
            Shopping Cart
          </h1>
          <p class="mt-2 text-gray-500">
            Review your selected monitor products.
          </p>
        </div>
        <a href="{{ route('products.index') }}"
          class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-white border border-gray-200 font-bold text-sm hover:bg-gray-100 transition">
          Continue Shopping
        </a>
      </div>

      @if (count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

          {{-- CART ITEMS --}}
          <div class="lg:col-span-8 space-y-4">
            @foreach ($cart as $item)
              @php
                $subtotal = $item['price'] * $item['quantity'];
              @endphp

              <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-4 relative">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">

                  {{-- IMAGE --}}
                  <div
                    class="w-full md:w-32 h-20 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 shrink-0 flex items-center justify-center p-2">
                    <img src="{{ $item['image'] ?: 'https://placehold.co/150x150/f3f4f6/a3a3a3?text=No+Image' }}"
                      class="w-full h-full object-contain">
                  </div>

                  {{-- CONTENT --}}
                  <div class="flex-1 flex flex-col justify-between w-full min-w-0 self-stretch">
                    <div class="pr-8">
                      <h2 class="text-lg font-extrabold text-gray-900 tracking-tight truncate">
                        {{ $item['brand'] ?? '-' }} {{ $item['display_size'] ?? '-' }}" {{ $item['name'] }}
                      </h2>
                      <p class="mt-0.5 text-xs font-semibold text-gray-400">
                        Product ID: {{ $item['id'] }}
                      </p>
                    </div>

                    {{-- ACTIONS & PRICE ZONE --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4 md:mt-0">

                      {{-- QUANTITY CONTROLS --}}
                      <form action="{{ route('cart.update', $item['id']) }}" method="POST"
                        class="flex items-center gap-2">
                        @csrf
                        <div
                          class="flex items-center border border-gray-200/80 rounded-xl overflow-hidden bg-gray-50/40 h-9">
                          <button type="button" onclick="decreaseQty(this)"
                            class="w-9 h-full text-lg font-black text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition">
                            -
                          </button>
                          <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                            class="w-12 h-full text-center border-0 p-0 focus:ring-0 text-sm font-bold bg-transparent text-gray-800 quantity-input">
                          <button type="button" onclick="increaseQty(this)"
                            class="w-9 h-full text-lg font-black text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition">
                            +
                          </button>
                        </div>

                        {{-- Update --}}
                        <button
                          class="px-4 h-9 rounded-xl bg-gray-100/80 hover:bg-gray-900 text-gray-800 hover:text-white font-black text-xs tracking-wider uppercase transition-all duration-200">
                          Update
                        </button>
                      </form>

                      {{-- PRICE DISPLAY --}}
                      <div class="flex flex-col items-start sm:items-end justify-center">
                        <span class="text-xs text-gray-400 font-medium">
                          ${{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}
                        </span>
                        <span class="text-xl font-black text-gray-900 tracking-tight">
                          ${{ number_format($subtotal, 2) }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- REMOVE BUTTON --}}
                <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="absolute top-4 right-4">
                  @csrf
                  @method('DELETE')
                  <button aria-label="Remove item"
                    class="w-8 h-8 rounded-xl bg-red-50/60 hover:bg-red-500 text-red-500 hover:text-white flex items-center justify-center transition-all duration-200 active:scale-90 border border-red-100/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </form>

              </div>
            @endforeach

          </div>

          {{-- SUMMARY --}}
          <div class="lg:col-span-4">
            <div class="lg:sticky lg:top-8 bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6">
              <div>
                <h2 class="text-2xl font-black text-gray-900">Order Summary</h2>
                <p class="mt-1 text-sm text-gray-500">Final pricing overview.</p>
              </div>
              <div class="space-y-4 border-y border-gray-100 py-5">
                <div class="flex justify-between items-center text-sm">
                  <span class="text-gray-500 font-semibold">Total Items</span>
                  <span class="font-black text-gray-900">{{ count($cart) }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                  <span class="text-gray-500 font-semibold">Shipping</span>
                  <span class="font-black text-green-600">Free</span>
                </div>
              </div>

              <div class="flex justify-between items-end">
                <div>
                  <p class="text-sm text-gray-500 font-semibold">Total Price</p>
                  <h3 class="text-4xl font-black text-gray-900 mt-1">
                    ${{ number_format($total, 2) }}
                  </h3>
                </div>
              </div>

              @auth
                <a href="{{ route('checkout.index') }}"
                  class="block w-full text-center py-4 rounded-2xl bg-black hover:bg-neutral-800 text-white font-black shadow-lg transition">
                  Proceed to Checkout
                </a>
              @else
                <a href="{{ route('login') }}"
                  class="block w-full text-center py-4 rounded-2xl bg-black hover:bg-neutral-800 text-white font-black shadow-lg transition">
                  Login to Checkout
                </a>
              @endauth

            </div>
          </div>
        </div>
      @else
        {{-- EMPTY CART --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm py-20 px-10 text-center">
          <h2 class="text-3xl font-black text-gray-900">Your cart is empty</h2>
          <p class="mt-3 text-gray-500">Add monitor products to start shopping.</p>
          <a href="{{ route('products.index') }}"
            class="inline-flex items-center justify-center mt-8 px-8 py-4 rounded-2xl bg-gray-900 text-white font-bold hover:bg-gray-800 transition">
            Browse Products
          </a>
        </div>
      @endif
    </div>
  </div>

  <script>
    function increaseQty(button) {
      const input = button.parentElement.querySelector('.quantity-input');
      input.value = Number(input.value || 1) + 1;
    }

    function decreaseQty(button) {
      const input = button.parentElement.querySelector('.quantity-input');
      const current = Number(input.value || 1);
      if (current > 1) {
        input.value = current - 1;
      }
    }
  </script>
</x-app-layout>
