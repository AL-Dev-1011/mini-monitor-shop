@php
  $cart = session('cart', []);
  $cartCount = collect($cart)->sum('quantity');
@endphp

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-neutral-200 dark:border-gray-700">
  <div class="max-w-[1600px] mx-auto px-4 sm:px-6">
    <div class="flex justify-between h-16">

      <div class="flex">
        <div class="shrink-0 flex items-center">
          <a href="{{ route('products.index') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
          </a>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

          <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index') || request()->routeIs('products.show')">
            Products
          </x-nav-link>

          @auth
            @if (auth()->user()->role !== 'admin')
              <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                My Orders
              </x-nav-link>
            @endif
          @endauth

          @auth

            @if (auth()->user()->role === 'admin')
              <x-nav-link :href="route('products.create')" :active="request()->routeIs('products.create') || request()->routeIs('products.edit')">
                Add Product
              </x-nav-link>
              <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                Orders
              </x-nav-link>
              <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                Dashboard
              </x-nav-link>
            @endif

          @endauth
        </div>

      </div>

      <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">

        {{-- Cart: show before and after login --}}
        @if (!auth()->check() || auth()->user()->role !== 'admin')

          <a href="{{ route('cart.index') }}"
            class="relative inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-gray-100 hover:bg-gray-200 transition">
            <span class="material-symbols-outlined text-[22px] text-gray-700">
              shopping_cart
            </span>
            @if ($cartCount > 0)
              <span
                class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-xs font-black flex items-center justify-center">
                {{ $cartCount }}
              </span>
            @endif
          </a>

        @endif

        @auth
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button
                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                <div>{{ Auth::user()->name }}</div>

                <div class="ms-1">
                  <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </div>
              </button>
            </x-slot>

            <x-slot name="content">
              <x-dropdown-link :href="route('profile.edit')">
                Profile
              </x-dropdown-link>

              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                  Log Out
                </x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        @else
          <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-100">
            Login
          </a>

          <a href="{{ route('register') }}"
            class="px-4 py-2 rounded-xl text-sm font-bold bg-gray-900 text-white hover:bg-gray-800">
            Register
          </a>
        @endauth
      </div>

      <div class="-me-2 flex items-center sm:hidden">
        <button @click="open = ! open"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

    </div>
  </div>

  <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
        Productsss
      </x-responsive-nav-link>

      <x-responsive-nav-link :href="route('cart.index')">
        Cart ({{ $cartCount }})
      </x-responsive-nav-link>
    </div>

    <div class="pt-4 pb-1 border-t border-gray-200">
      @auth
        <div class="px-4">
          <div class="font-medium text-base text-gray-800">
            {{ Auth::user()->name }}
          </div>
          <div class="font-medium text-sm text-gray-500">
            {{ Auth::user()->email }}
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <x-responsive-nav-link :href="route('profile.edit')">
            Profile
          </x-responsive-nav-link>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
              Log Out
            </x-responsive-nav-link>
          </form>
        </div>
      @else
        <div class="mt-3 space-y-1">
          <x-responsive-nav-link :href="route('login')">
            Login
          </x-responsive-nav-link>

          <x-responsive-nav-link :href="route('register')">
            Register
          </x-responsive-nav-link>
        </div>
      @endauth
    </div>
  </div>
</nav>
