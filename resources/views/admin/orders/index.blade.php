<x-app-layout>
  <div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-black mb-8">
      Admin Orders
    </h1>

    @if (session('success'))
      <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white border border-neutral-200 rounded-3xl overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-neutral-50 border-b">
          <tr>
            <th class="p-4 text-left">Order</th>
            <th class="p-4 text-left">Customer</th>
            <th class="p-4 text-left">Total</th>
            <th class="p-4 text-left">Status</th>
            <th class="p-4 text-left">Date</th>
            <th class="p-4 text-left">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @foreach ($orders as $order)
            <tr>
              <td class="p-4 font-black">
                {{ $order->order_number }}
              </td>

              <td class="p-4">
                {{ $order->full_name }}<br>
                <span class="text-neutral-500">{{ $order->email }}</span>
              </td>

              <td class="p-4 font-black">
                ${{ number_format($order->total, 2) }}
              </td>

              <td class="p-4">
                <span class="px-3 py-1 rounded-full bg-neutral-100 font-bold">
                  {{ $order->status }}
                </span>
              </td>

              <td class="p-4">
                {{ $order->created_at->format('d M Y') }}
              </td>

              <td class="p-4">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                  @csrf
                  @method('PATCH')

                  <select name="status" class="rounded-xl border-neutral-300 text-sm">
                    @foreach (['pending', 'paid', 'shipped', 'completed', 'cancelled'] as $status)
                      <option value="{{ $status }}" @selected($order->status === $status)>
                        {{ ucfirst($status) }}
                      </option>
                    @endforeach
                  </select>

                  <button class="ml-2 px-4 py-2 bg-black text-white rounded-xl font-bold">
                    Save
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</x-app-layout>
