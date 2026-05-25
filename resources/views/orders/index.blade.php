<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-10">

      <h1 class="text-4xl font-black text-black">My Orders</h1>
      <p class="mt-2 text-neutral-500">View your order history.</p>

      <div class="mt-8 space-y-4">
        @forelse($orders as $order)
          <a href="{{ route('orders.show', $order) }}"
            class="block bg-white border border-neutral-200 rounded-3xl p-6 hover:shadow-lg transition">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <div>
                <p class="text-sm text-neutral-500 font-bold">Order Number</p>
                <h2 class="text-xl font-black">{{ $order->order_number }}</h2>
              </div>

              <div>
                <p class="text-sm text-neutral-500 font-bold">Date</p>
                <p class="font-bold">{{ $order->created_at->timezone('Asia/Bangkok')->format('d M Y · H:i') }}</p>
              </div>

              <div>
                <p class="text-sm text-neutral-500 font-bold">Status</p>
                <span
                  class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-black uppercase">
                  {{ $order->status }}
                </span>
              </div>

              <div class="text-left md:text-right">
                <p class="text-sm text-neutral-500 font-bold">Total</p>
                <p class="text-2xl font-black">${{ number_format($order->total, 2) }}</p>
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
