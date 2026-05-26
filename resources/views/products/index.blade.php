<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-[1600px] mx-auto px-4 py-8">

      @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold">
          {{ session('success') }}
        </div>
      @endif

      <form method="GET" id="filter-form">
        <input type="hidden" name="view" value="{{ $currentView }}">

        <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] xl:grid-cols-[240px_1fr] gap-6 items-start">

          {{-- Filter Sidebar --}}
          <x-product-filter-sidebar :filters="$filters" :connections="$connections" :price-ranges="$priceRanges" :filter-counts="$filterCounts"
            :active-filters="$activeFilters" :has-active-filters="$hasActiveFilters" />

          <main>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
              <div>
                <h1 class="text-3xl font-black text-black">
                  Monitor Products
                </h1>

                <p class="mt-1 text-sm font-bold text-neutral-500">
                  {{ $products->total() }} Results
                </p>
              </div>

              {{-- View Toggle and Sort --}}
              <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                  <a href="{{ route('products.index', array_merge(request()->query(), ['view' => 'grid'])) }}"
                    class="relative inline-flex items-center justify-center w-11 h-11 rounded-2xl 
                    {{ $currentView === 'grid' ? 'bg-gray-100 hover:bg-gray-200 text-gray-700' : 'bg-white text-gray-700 border-neutral-200' }}">
                    <span class="material-symbols-outlined text-[22px]">
                      grid_view
                    </span>
                  </a>

                  <a href="{{ route('products.index', array_merge(request()->query(), ['view' => 'list'])) }}"
                    class="relative inline-flex items-center justify-center w-11 h-11 rounded-2xl 
                    {{ $currentView === 'list' ? 'bg-gray-100 hover:bg-gray-200 text-gray-700' : 'bg-white text-gray-700 border-neutral-200' }}">
                    <span class="material-symbols-outlined text-[22px]">
                      view_list
                    </span>
                  </a>
                </div>

                <select name="sort" onchange="document.getElementById('filter-form').submit()"
                  class="rounded-xl border-neutral-300 text-sm">
                  <option value="">Newest</option>
                  <option value="lowest" @selected(request('sort') === 'lowest')>
                    Lowest Price
                  </option>
                  <option value="highest" @selected(request('sort') === 'highest')>
                    Highest Price
                  </option>
                </select>
              </div>
            </div>

            {{-- Product Grid/List --}}
            @if ($products->count())
              <div
                class="{{ $currentView === 'list'
                    ? 'space-y-3'
                    : 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-3' }}">

                @foreach ($products as $product)
                  @if ($currentView === 'list')
                    {{-- List View Card --}}
                    <x-product-list-card :product="$product" :filters="$filters" />
                  @else
                    {{-- Grid View Card --}}
                    <x-product-grid-card :product="$product" :filters="$filters" />
                  @endif
                @endforeach

              </div>

              @if ($products->hasPages())
                <div class="mt-10">
                  {{ $products->links() }}
                </div>
              @endif
            @else
              <div class="bg-white border border-neutral-200 rounded-3xl p-12 text-center">
                <h2 class="text-2xl font-black text-black">
                  No products found
                </h2>

                <p class="mt-2 text-neutral-500">
                  Try clearing filters or changing your search options.
                </p>

                <a href="{{ route('products.index') }}"
                  class="inline-flex mt-6 px-6 py-3 bg-black text-white rounded-2xl font-black">
                  Clear Filters
                </a>
              </div>
            @endif

          </main>

        </div>
      </form>

    </div>
  </div>
</x-app-layout>
