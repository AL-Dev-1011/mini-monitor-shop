<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-10">

      <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <a href="{{ route('admin.orders.index') }}"
            class="text-sm font-bold text-neutral-500 hover:text-black">
            ← Back to Orders
          </a>

          <h1 class="mt-3 text-4xl font-black text-black">
            Order Detail
          </h1>

          <p class="mt-2 text-neutral-500 font-semibold">
            {{ $order->order_number }}
          </p>
        </div>

      </div>

      @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
          {{ session('success') }}
        </div>
      @endif

      <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-8 items-start">

        {{-- LEFT --}}
        <div class="space-y-6">

          {{-- ORDER ITEMS --}}
          <div class="bg-white border border-neutral-200 rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-neutral-200">
              <h2 class="text-2xl font-black">
                Ordered Products
              </h2>
            </div>

            <div class="divide-y divide-neutral-200">
              @foreach($order->items as $item)
                <div class="p-6 flex gap-5">
                  <div class="w-28 h-24 rounded-2xl overflow-hidden border border-neutral-200 bg-neutral-50 shrink-0">
                    <img src="{{ $item->image ?: 'https://placehold.co/300x200' }}"
                      class="w-full h-full object-contain">
                  </div>

                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-black uppercase tracking-widest text-blue-600">
                      {{ $item->brand }}
                    </p>

                    <h3 class="mt-1 text-xl font-black text-black">
                      {{ $item->product_name }}
                    </h3>

                    <p class="mt-2 text-sm text-neutral-500">
                      ${{ number_format($item->price, 2) }}
                      ×
                      {{ $item->quantity }}
                    </p>
                  </div>

                  <div class="text-right">
                    <p class="text-xl font-black">
                      ${{ number_format($item->subtotal, 2) }}
                    </p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          {{-- CUSTOMER --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white border border-neutral-200 rounded-3xl p-6">
              <h2 class="text-xl font-black mb-4">
                Customer Information
              </h2>

              <div class="space-y-3 text-sm">
                <div>
                  <p class="text-neutral-500 font-bold">Name</p>
                  <p class="font-black">{{ $order->full_name }}</p>
                </div>

                <div>
                  <p class="text-neutral-500 font-bold">Email</p>
                  <p class="font-black">{{ $order->email }}</p>
                </div>

                <div>
                  <p class="text-neutral-500 font-bold">Phone</p>
                  <p class="font-black">{{ $order->phone }}</p>
                </div>
              </div>
            </div>

            <div class="bg-white border border-neutral-200 rounded-3xl p-6">
              <h2 class="text-xl font-black mb-4">
                Shipping Address
              </h2>

              <div class="text-sm font-semibold text-neutral-700 leading-7">
                {{ $order->address }}<br>
                {{ $order->city }}<br>
                {{ $order->province }} {{ $order->postal_code }}
              </div>
            </div>

          </div>

        </div>

        {{-- RIGHT --}}
        <aside class="lg:sticky lg:top-8 space-y-6">

          {{-- SUMMARY --}}
          <div class="bg-neutral-50 border border-neutral-200 rounded-3xl p-6">
            <h2 class="text-2xl font-black mb-6">
              Order Summary
            </h2>

            <div class="space-y-4 text-sm">
              <div class="flex justify-between">
                <span class="text-neutral-500 font-bold">Order Date</span>
                <span class="font-black">{{ $order->created_at->format('d M Y') }}</span>
              </div>

              <div class="flex justify-between">
                <span class="text-neutral-500 font-bold">Status</span>
                <span class="px-3 py-1 rounded-full bg-white border border-neutral-200 font-black">
                  {{ ucfirst($order->status) }}
                </span>
              </div>

              <div class="flex justify-between">
                <span class="text-neutral-500 font-bold">Payment</span>
                <span class="font-black">{{ $order->payment_method ?? '-' }}</span>
              </div>
            </div>

            <div class="border-t border-neutral-200 mt-6 pt-6 space-y-4 text-sm">
              <div class="flex justify-between">
                <span class="text-neutral-500 font-bold">Subtotal</span>
                <span class="font-black">${{ number_format($order->subtotal, 2) }}</span>
              </div>

              <div class="flex justify-between">
                <span class="text-neutral-500 font-bold">Shipping</span>
                <span class="font-black">${{ number_format($order->shipping, 2) }}</span>
              </div>
            </div>

            <div class="border-t border-neutral-200 mt-6 pt-6 flex justify-between items-end">
              <span class="text-neutral-500 font-bold">Total</span>
              <span class="text-4xl font-black">
                ${{ number_format($order->total, 2) }}
              </span>
            </div>
          </div>

        </aside>

      </div>

    </div>
  </div>
</x-app-layout>