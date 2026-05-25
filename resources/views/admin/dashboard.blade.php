<x-app-layout>
  <div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-8">
      <h1 class="text-4xl font-black text-black">
        Admin Dashboard
      </h1>

      <p class="mt-2 text-neutral-500">
        Store overview and latest activity.
      </p>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-10">

      <div class="bg-white border border-neutral-200 rounded-3xl p-6">
        <p class="text-sm font-bold text-neutral-500">
          Total Products
        </p>

        <h2 class="text-4xl font-black mt-3">
          {{ $totalProducts }}
        </h2>
      </div>

      <div class="bg-white border border-neutral-200 rounded-3xl p-6">
        <p class="text-sm font-bold text-neutral-500">
          Total Orders
        </p>

        <h2 class="text-4xl font-black mt-3">
          {{ $totalOrders }}
        </h2>
      </div>

      <div class="bg-white border border-neutral-200 rounded-3xl p-6">
        <p class="text-sm font-bold text-neutral-500">
          Total Users
        </p>

        <h2 class="text-4xl font-black mt-3">
          {{ $totalUsers }}
        </h2>
      </div>

      <div class="bg-white border border-neutral-200 rounded-3xl p-6">
        <p class="text-sm font-bold text-neutral-500">
          Total Sales
        </p>

        <h2 class="text-4xl font-black mt-3">
          ${{ number_format($totalSales, 2) }}
        </h2>
      </div>

    </div>

    {{-- LATEST ORDERS --}}
    <div class="bg-white border border-neutral-200 rounded-3xl overflow-hidden">

      <div class="p-6 border-b border-neutral-200 flex justify-between items-center">
        <div>
          <h2 class="text-2xl font-black">
            Latest Orders
          </h2>

          <p class="text-sm text-neutral-500 mt-1">
            Recent customer purchases.
          </p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
          class="px-5 py-3 rounded-2xl bg-black text-white text-sm font-black hover:bg-neutral-800">
          View All Orders
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-neutral-50 border-b border-neutral-200">
            <tr>
              <th class="p-4 text-left">Order</th>
              <th class="p-4 text-left">Customer</th>
              <th class="p-4 text-left">Total</th>
              <th class="p-4 text-left">Status</th>
              <th class="p-4 text-left">Date</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-neutral-200">
            @forelse($latestOrders as $order)
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

              <tr>
                <td class="p-4 font-black">
                  {{ $order->order_number }}
                </td>

                <td class="p-4">
                  {{ $order->full_name }}
                  <br>
                  <span class="text-neutral-500">
                    {{ $order->email }}
                  </span>
                </td>

                <td class="p-4 font-black">
                  ${{ number_format($order->total, 2) }}
                </td>

                <td class="p-4">
                  <span class="px-3 py-1 rounded-full text-xs font-black {{ $statusClass }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>

                <td class="p-4 text-neutral-500">
                  {{ $order->created_at->format('d M Y') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="p-8 text-center text-neutral-500 font-bold">
                  No orders yet.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>

  </div>
</x-app-layout>
