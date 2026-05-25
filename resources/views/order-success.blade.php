<x-app-layout>

  <div class="bg-white min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-20">
      <div class="text-center">

        {{-- 
          |--------------------------------------------------------------------------
          | ORDER HEADER
          |----------------------------------------------------------------------------
        --}}
        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-8">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h1 class="text-5xl font-black tracking-tight text-black">
          Order Confirmed
        </h1>
        <p class="mt-4 text-neutral-500 text-lg">
          Thank you for your purchase.
        </p>
      </div>

      {{-- 
          |--------------------------------------------------------------------------
          | ORDER CARD
          |----------------------------------------------------------------------------
        --}}
      <div class="mt-14 bg-white border border-neutral-200 rounded-3xl p-8 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-neutral-500 font-semibold">
              Order Number
            </p>
            <h2 class="text-xl font-black mt-1">
              {{ $order['order_number'] }}
            </h2>
          </div>
          <div class="text-right">
            <p class="text-sm text-neutral-500 font-semibold">
              Order Date
            </p>
            <p class="font-bold mt-1">
              {{ $order->created_at->timezone('Asia/Bangkok')->format('d M Y · H:i') }}
            </p>
          </div>
        </div>

        {{-- ORDER ITEMS --}}
        <div class="mt-8 space-y-5">

          @foreach ($order->items as $item)
            <div class="flex gap-4">
              <div class="w-24 h-20 rounded-2xl overflow-hidden border border-neutral-200 bg-white shrink-0">
                <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="font-black text-sm leading-tight">
                  {{ $item['brand'] ?? '' }}
                  {{ $item['name'] }}
                </h3>
                <p class="text-xs text-neutral-500 mt-1">
                  Qty: {{ $item['quantity'] }}
                </p>
              </div>
              <div class="text-right">
                <p class="font-black text-lg">
                  ${{ number_format($item['price'] * $item['quantity'], 2) }}
                </p>
              </div>
            </div>
          @endforeach

        </div>

        {{-- TOTAL --}}
        <div class="border-t border-neutral-200 mt-8 pt-6 flex justify-between items-end">
          <div>
            <p class="text-sm text-neutral-500 font-semibold">
              Total Paid
            </p>
            <h3 class="text-4xl font-black mt-1">
              ${{ number_format($order->total, 2) }}
            </h3>
          </div>
          <div class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-black">
            Paid
          </div>
        </div>
      </div>

      {{-- 
          |--------------------------------------------------------------------------
          | ORDER ACTIONS
          |----------------------------------------------------------------------------
        --}}
      <div class="mt-10 flex flex-col sm:flex-row gap-4">
        <a href="{{ route('products.index') }}"
          class="flex-1 text-center py-4 rounded-2xl bg-black text-white font-black hover:bg-neutral-800 transition">
          Continue Shopping
        </a>
        <a href="{{ route('orders.index') }}"
          class="flex-1 text-center py-4 rounded-2xl border border-neutral-200 font-black hover:bg-neutral-50 transition">
          My Orders
        </a>
      </div>
    </div>
  </div>
</x-app-layout>
