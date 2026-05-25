<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-10">

      <a href="{{ route('orders.index') }}" class="text-sm font-bold text-neutral-500 hover:text-black">
        ← Back to My Orders
      </a>

      <div class="mt-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
          <h1 class="text-4xl font-black text-black">{{ $order->order_number }}</h1>
          <p class="mt-2 text-neutral-500">{{ $order->created_at->timezone('Asia/Bangkok')->format('d M Y · H:i') }}</p>
        </div>

        <span class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-black uppercase">
          {{ $order->status }}
        </span>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8 mt-8">

        <div class="space-y-4">
          @foreach ($order->items as $item)
            <div class="flex gap-4 border border-neutral-200 rounded-3xl p-5">
              <img src="{{ $item->image ?: 'https://placehold.co/120x90' }}"
                class="w-28 h-20 object-cover rounded-2xl border">

              <div class="flex-1">
                <h2 class="font-black">
                  {{ $item->brand }} {{ $item->name }}
                </h2>

                <p class="text-sm text-neutral-500 mt-1">
                  Qty: {{ $item->quantity }}
                </p>
              </div>

              <p class="font-black">
                ${{ number_format($item->subtotal, 2) }}
              </p>
            </div>
          @endforeach
        </div>

        <aside class="border border-neutral-200 rounded-3xl p-6 h-fit">
          <h2 class="text-xl font-black">Order Summary</h2>

          <div class="mt-5 space-y-3 text-sm">
            <div class="flex justify-between">
              <span>Subtotal</span>
              <strong>${{ number_format($order->subtotal, 2) }}</strong>
            </div>

            <div class="flex justify-between">
              <span>Shipping</span>
              <strong>Free</strong>
            </div>
          </div>

          <div class="border-t mt-5 pt-5 flex justify-between items-end">
            <span class="font-bold">Total</span>
            <span class="text-3xl font-black">${{ number_format($order->total, 2) }}</span>
          </div>

          <div class="border-t mt-6 pt-6">
            <h3 class="font-black">Shipping Address</h3>
            <p class="mt-2 text-sm text-neutral-600 leading-relaxed">
              {{ $order->full_name }}<br>
              {{ $order->phone }}<br>
              {{ $order->address }}<br>
              {{ $order->province }} {{ $order->postal_code }}<br>
            </p>
          </div>
        </aside>

      </div>

    </div>
  </div>
</x-app-layout>
