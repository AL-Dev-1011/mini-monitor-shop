<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-10">

      {{-- HEADER --}}
      <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">

        <div>
          <h1 class="text-4xl font-black text-black">
            Admin Orders
          </h1>

          <p class="mt-2 text-neutral-500">
            Manage customer orders and update order status.
          </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
          class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-black text-white text-sm font-black hover:bg-neutral-800 transition">
          Dashboard
        </a>

      </div>

      {{-- SUCCESS --}}
      @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
          {{ session('success') }}
        </div>
      @endif

      {{-- TABLE --}}
      <div class="bg-white border border-neutral-200 rounded-3xl overflow-hidden shadow-sm">

        <div class="overflow-x-auto">

          <table class="w-full text-sm">

            {{-- HEAD --}}
            <thead class="bg-neutral-50 border-b border-neutral-200">
              <tr>
                <th class="p-4 text-left font-black text-neutral-600">
                  Order
                </th>

                <th class="p-4 text-left font-black text-neutral-600">
                  Customer
                </th>

                <th class="p-4 text-left font-black text-neutral-600">
                  Total
                </th>

                <th class="p-4 text-left font-black text-neutral-600">
                  Status
                </th>

                <th class="p-4 text-left font-black text-neutral-600">
                  Date
                </th>

                <th class="p-4 text-left font-black text-neutral-600">
                  Action
                </th>
              </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-neutral-200">

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

                <tr class="hover:bg-neutral-50 transition">

                  {{-- ORDER --}}
                  <td class="p-4 align-top">

                    <a href="{{ route('admin.orders.show', $order) }}"
                      class="font-black text-black hover:text-blue-600 transition">

                      {{ $order->order_number }}

                    </a>

                    <p class="mt-1 text-xs text-neutral-500">
                      ID: {{ $order->id }}
                    </p>

                  </td>

                  {{-- CUSTOMER --}}
                  <td class="p-4 align-top">

                    <p class="font-black text-black">
                      {{ $order->full_name }}
                    </p>

                    <p class="text-neutral-500 mt-1">
                      {{ $order->email }}
                    </p>

                    <p class="text-neutral-400 mt-1 text-xs">
                      {{ $order->phone }}
                    </p>

                  </td>

                  {{-- TOTAL --}}
                  <td class="p-4 align-top font-black text-black">
                    ${{ number_format($order->total, 2) }}
                  </td>

                  {{-- STATUS --}}
                  <td class="p-4 align-top">

                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-black {{ $statusClass }}">
                      {{ ucfirst($order->status) }}
                    </span>

                  </td>

                  {{-- DATE --}}
                  <td class="p-4 align-top text-neutral-500 font-semibold">

                    {{ $order->created_at->format('d M Y') }}

                    <br>

                    <span class="text-xs text-neutral-400">
                      {{ $order->created_at->format('H:i') }}
                    </span>

                  </td>

                  {{-- ACTION --}}
                  <td class="p-4 align-top">

                    <div class="flex flex-col xl:flex-row gap-2">

                      {{-- VIEW --}}
                      <a href="{{ route('admin.orders.show', $order) }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-neutral-100 hover:bg-neutral-200 rounded-xl font-black text-sm transition">

                        View

                      </a>

                      {{-- STATUS FORM --}}
                      <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                        class="flex items-center gap-2">

                        @csrf
                        @method('PATCH')

                        <select name="status" class="rounded-xl border-neutral-300 text-sm font-semibold">

                          @foreach (['pending', 'paid', 'shipped', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>

                              {{ ucfirst($status) }}

                            </option>
                          @endforeach

                        </select>

                        <button
                          class="px-4 py-2 bg-black text-white rounded-xl font-black text-sm hover:bg-neutral-800 transition">

                          Save

                        </button>

                      </form>

                    </div>

                  </td>

                </tr>

              @empty

                <tr>
                  <td colspan="6" class="p-12 text-center">

                    <h2 class="text-2xl font-black text-black">
                      No orders yet
                    </h2>

                    <p class="mt-2 text-neutral-500">
                      Customer orders will appear here.
                    </p>

                  </td>
                </tr>

              @endforelse

            </tbody>

          </table>

        </div>

      </div>

    </div>
  </div>
</x-app-layout>
