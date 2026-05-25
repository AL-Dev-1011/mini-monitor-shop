<x-app-layout>
  @php
    $cart = session('cart', []);
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $shipping = 0;
    $total = $subtotal + $shipping;
  @endphp

  <div class="bg-white min-h-screen">
    <div class="max-w-[1024px] mx-auto px-4 py-10">

      @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700">
          <p class="font-black mb-2">Please check these fields:</p>

          <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif


      <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 items-start">

          {{-- LEFT --}}
          <div class="bg-neutral-50 border border-neutral-200 rounded-3xl p-6 lg:p-8 shadow-sm">

            {{-- HEADER --}}
            <div class="mb-8">
              <h1 class="text-3xl font-black tracking-tight text-black">
                Checkout
              </h1>
              <p class="mt-2 text-sm text-neutral-500">
                Complete your monitor purchase securely.
              </p>
            </div>

            {{-- DELIVERY --}}
            <div>
              <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-6 rounded-full bg-black"></div>
                <h2 class="text-xl font-black">
                  Delivery
                </h2>
              </div>
              <div class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                  <input name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}"
                    placeholder="First name"
                    class="rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black" required>
                  <input name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                    placeholder="Last name"
                    class="rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black" required>
                </div>
                <input name="address" value="{{ old('address', auth()->user()->address ?? '') }}" placeholder="Address"
                  class="w-full rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black"
                  required>
                <input name="apartment" placeholder="Apartment, suite, etc. (optional)"
                  class="w-full rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black">
                <div class="grid grid-cols-2 gap-3">

                  <select id="province-select" name="province"
                    class="rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black" required>
                  </select>
                  <input name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}"
                    placeholder="Postal code"
                    class="rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black" required>
                </div>
                <input name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="Phone"
                  class="w-full rounded-2xl border-neutral-200 px-4 py-3 text-sm focus:ring-0 focus:border-black">
                <label class="flex items-center gap-3 text-sm pt-1">
                  <input type="checkbox" name="save_info" class="rounded border-neutral-300">
                  Save this information for next time
                </label>
              </div>
            </div>

            {{-- PAYMENT --}}
            <div class="mt-10">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-6 rounded-full bg-black"></div>
                <h2 class="text-xl font-black">
                  Payment
                </h2>
              </div>
              <p class="text-sm text-neutral-500 mb-4">
                All transactions are secure and encrypted.
              </p>
              <div class="border border-black rounded-2xl overflow-hidden">
                <label class="flex items-center justify-between p-5 bg-neutral-50 cursor-pointer">
                  <div class="flex items-center gap-3">
                    <input type="radio" name="payment_method" value="omise" checked>
                    <span class="font-black text-sm">
                      Omise Payments
                    </span>
                  </div>
                  <div class="flex gap-1 text-xs">
                    <span class="px-2 py-1 bg-white rounded border">
                      VISA
                    </span>
                    <span class="px-2 py-1 bg-white rounded border">
                      MC
                    </span>
                    <span class="px-2 py-1 bg-white rounded border">
                      JCB
                    </span>
                  </div>
                </label>
                <div class="bg-white text-center text-sm text-neutral-500 py-5 px-4 border-t border-neutral-200">
                  You'll be redirected to Omise Payments to complete your purchase.
                </div>
              </div>
            </div>

            {{-- BILLING --}}
            <div class="mt-10">
              <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-6 rounded-full bg-black"></div>
                <h2 class="text-xl font-black">
                  Billing Address
                </h2>
              </div>
              <div class="border border-neutral-200 rounded-2xl overflow-hidden">
                <label
                  class="flex items-center gap-3 p-5 bg-neutral-50 text-sm cursor-pointer border-b border-neutral-200">
                  <input type="radio" name="billing_address" value="same" checked>
                  Same as shipping address
                </label>
                <label class="flex items-center gap-3 p-5 bg-white text-sm cursor-pointer">
                  <input type="radio" name="billing_address" value="different">
                  Use a different billing address
                </label>
              </div>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
              class="mt-10 w-full py-4 rounded-2xl bg-black hover:bg-neutral-800 text-white font-black transition">
              Pay now
            </button>
          </div>

          {{-- RIGHT --}}
          <div class="w-full">
            <div class="lg:sticky lg:top-8 bg-neutral-50 border border-neutral-200 rounded-3xl p-6 shadow-sm">
              <h2 class="text-2xl font-black text-black mb-6">
                Order Summary
              </h2>
              <div class="mb-6 text-sm text-neutral-500">
                {{ now()->timezone('Asia/Bangkok')->format('d M Y · H:i') }}
              </div>
              <div class="space-y-5">

                @foreach ($cart as $item)
                  <div class="flex gap-4">
                    <div class="w-24 h-20 rounded-2xl overflow-hidden border border-neutral-200 bg-white shrink-0">
                      <img src="{{ $item['image'] ?: 'https://placehold.co/300x200' }}"
                        class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1 min-w-0">

                      <h3 class="font-black text-sm leading-tight text-black">
                        {{ $item['brand'] ?? '' }}
                        {{ $item['name'] }}
                      </h3>

                      <p class="text-xs text-neutral-500 mt-1">
                        Qty: {{ $item['quantity'] }}
                      </p>

                      <p class="font-black text-lg mt-2">
                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                      </p>

                    </div>

                  </div>
                @endforeach

              </div>

              {{-- TOTAL --}}
              <div class="border-t border-neutral-200 mt-6 pt-6 space-y-4">
                <div class="flex justify-between text-sm">
                  <span class="text-neutral-500 font-semibold">
                    Subtotal
                  </span>
                  <span class="font-black">${{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="flex justify-between text-sm">
                  <span class="text-neutral-500 font-semibold">
                    Shipping
                  </span>
                  <span class="font-black">
                    Free
                  </span>
                </div>
              </div>
              <div class="border-t border-neutral-200 mt-6 pt-6 flex justify-between items-end">
                <span class="text-neutral-500 font-bold">
                  Total
                </span>
                <span class="text-4xl font-black text-black">${{ number_format($total, 2) }}</span>
              </div>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userProvince = @json(auth()->user()->province ?? 'Khon Kaen');

      const thaiProvinces = [
        "Bangkok",
        "Amnat Charoen",
        "Ang Thong",
        "Bueng Kan",
        "Buri Ram",
        "Chachoengsao",
        "Chai Nat",
        "Chaiyaphum",
        "Chanthaburi",
        "Chiang Mai",
        "Chiang Rai",
        "Chon Buri",
        "Chumphon",
        "Kalasin",
        "Kamphaeng Phet",
        "Kanchanaburi",
        "Khon Kaen",
        "Krabi",
        "Lampang",
        "Lamphun",
        "Loei",
        "Lop Buri",
        "Mae Hong Son",
        "Maha Sarakham",
        "Mukdahan",
        "Nakhon Nayok",
        "Nakhon Pathom",
        "Nakhon Phanom",
        "Nakhon Ratchasima",
        "Nakhon Sawan",
        "Nakhon Si Thammarat",
        "Nan",
        "Narathiwat",
        "Nong Bua Lamphu",
        "Nong Khai",
        "Nonthaburi",
        "Pathum Thani",
        "Pattani",
        "Phang Nga",
        "Phatthalung",
        "Phayao",
        "Phetchabun",
        "Phetchaburi",
        "Phichit",
        "Phitsanulok",
        "Phra Nakhon Si Ayutthaya",
        "Phrae",
        "Phuket",
        "Prachin Buri",
        "Prachuap Khiri Khan",
        "Ranong",
        "Ratchaburi",
        "Rayong",
        "Roi Et",
        "Sa Kaeo",
        "Sakon Nakhon",
        "Samut Prakan",
        "Samut Sakhon",
        "Samut Songkhram",
        "Saraburi",
        "Satun",
        "Sing Buri",
        "Sisaket",
        "Songkhla",
        "Sukhothai",
        "Suphan Buri",
        "Surat Thani",
        "Surin",
        "Tak",
        "Trang",
        "Trat",
        "Ubon Ratchathani",
        "Udon Thani",
        "Uthai Thani",
        "Uttaradit",
        "Yala",
        "Yasothon"
      ];

      const provinceSelect = document.getElementById('province-select');

      thaiProvinces.forEach(function(province) {

        const option = document.createElement('option');

        option.value = province;
        option.textContent = province;

        if (province === userProvince) {
          option.selected = true;
        }

        provinceSelect.appendChild(option);
      });

    });
  </script>
</x-app-layout>
