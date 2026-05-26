<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-10">

      <h1 class="text-4xl font-black text-black">My Orders</h1>
      <p class="mt-2 text-neutral-500">View your order history.</p>

      <div class="mt-8 space-y-4">
        @forelse($orders as $order)
          @php
            $statusClass = match ($order->status) {
                'pending' => 'bg-yellow-100 text-yellow-700',
                'paid' => 'bg-blue-100 text-blue-700',
                'shipped' => 'bg-purple-100 text-purple-700',
                'completed' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
                default => 'bg-neutral-100 text-neutral-700',
            };
          @endphp

          <a href="{{ route('orders.show', $order) }}"
            class="block bg-white border border-neutral-200 rounded-3xl p-6 hover:shadow-lg transition">

            <div class="grid grid-cols-1 md:grid-cols-[1.5fr_1.2fr_0.8fr_0.7fr] gap-6 items-center">

              <div>
                <p class="text-sm text-neutral-500 font-bold">Order Number</p>
                <h2 class="text-xl font-black">{{ $order->order_number }}</h2>
              </div>

              <div>
                <p class="text-sm text-neutral-500 font-bold">Date</p>
                <p class="font-bold">
                  {{ $order->created_at->timezone('Asia/Bangkok')->format('d M Y · H:i') }}
                </p>
              </div>

              <div>
                <p class="text-sm text-neutral-500 font-bold">Status</p>
                <span class="inline-flex mt-1 px-3 py-1 rounded-full text-xs font-black uppercase {{ $statusClass }}">
                  {{ $order->status }}
                </span>
              </div>

              <div class="md:text-right">
                <p class="text-sm text-neutral-500 font-bold">Total</p>
                <p class="text-2xl font-black">
                  ${{ number_format($order->total, 2) }}
                </p>
              </div>

            </div>
          </a>
        @empty
          <div class="border border-neutral-200 rounded-3xl p-12 text-center">
            <h2 class="text-2xl font-black">No orders yet</h2>

            <a href="{{ route('products.index') }}"
              class="inline-flex mt-6 px-6 py-3 bg-black text-white rounded-2xl font-black">
              Start Shopping
            </a>
          </div>
        @endforelse
      </div>

    </div>
  </div>
</x-app-layout>
