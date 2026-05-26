<div>
  <aside class="space-y-3 lg:sticky lg:top-6">

    {{-- FILTER HEADER --}}
    <div class="flex items-center gap-3">
      <h2 class="text-2xl font-black text-black">
        Filters
      </h2>

      @if ($hasActiveFilters)
        <a href="{{ route('products.index') }}" class="text-sm font-bold text-blue-600 hover:underline">
          Clear All
        </a>
      @endif
    </div>

    {{-- ACTIVE TAGS --}}
    @if ($hasActiveFilters)
      <div class="flex flex-wrap gap-2">

        @foreach ($activeFilters as $key => $values)
          @foreach ((array) $values as $value)
            @if (
                $value !== null &&
                    $value !== '' &&
                    $value !== '1' &&
                    $key !== '_token' &&
                    $key !== 'delete' &&
                    strtolower($value) !== 'delete' &&
                    strlen($value) < 40)
              @php
                $tagLabel = $value;

                if ($key === 'price_range') {
                    $tagLabel = $priceRanges[$value] ?? $value;
                }

                if ($key === 'resolution') {
                    $tagLabel = $filters['resolution'][$value] ?? $value;
                }
              @endphp

              <span
                class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-300 text-blue-700 text-xs font-bold rounded-lg">
                {{ $tagLabel }}
                <a href="{{ removeFilterUrl($key, $value) }}" class="text-blue-700 hover:text-black">
                  ×
                </a>
              </span>
            @endif
          @endforeach
        @endforeach

        @if (request('min_price') || request('max_price'))
          <span
            class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-300 text-blue-700 text-xs font-bold rounded-lg">
            ${{ request('min_price') ?? 0 }}
            -
            ${{ request('max_price') ?? 'more' }}
            <a href="{{ route('products.index', request()->except(['min_price', 'max_price'])) }}"
              class="text-blue-700 hover:text-black">
              ×
            </a>
          </span>
        @endif

      </div>
    @endif

    {{-- PRICE FILTER --}}
    <details open class="bg-white border border-neutral-200 rounded-2xl overflow-hidden ">
      <summary class="cursor-pointer p-4 font-black flex justify-between items-center">
        Price
        <span>⌄</span>
      </summary>

      <div class="p-4 space-y-3 border-t border-neutral-200">

        @foreach ($priceRanges as $value => $label)
          <label class="flex items-center gap-3 text-sm">
            <input type="checkbox" name="price_range[]" value="{{ $value }}" @checked(in_array($value, request('price_range', [])))
              onchange="document.getElementById('filter-form').submit()"
              class="rounded border-neutral-300 text-blue-600">

            <span>
              {{ $label }} ({{ $filterCounts['price_range'][$value] ?? 0 }})
            </span>
          </label>
        @endforeach

        <div class="grid grid-cols-2 gap-2 pt-3">
          <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
            class="rounded-xl border-neutral-200 text-sm">

          <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
            class="rounded-xl border-neutral-200 text-sm">
        </div>

        <button type="submit" class="w-full py-2.5 bg-black text-white rounded-xl text-sm font-black">
          Apply Price
        </button>

      </div>
    </details>

    {{-- NORMAL FILTERS --}}
    @foreach ($filters as $field => $options)
      <details open class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
        <summary class="cursor-pointer p-4 font-black flex justify-between items-center capitalize">
          {{ str_replace('_', ' ', $field) }}
          <span>⌄</span>
        </summary>

        <div class="p-4 space-y-3 border-t border-neutral-200">

          @foreach ($options as $value => $label)
            @php
              if (is_int($value)) {
                  $value = $label;
              }
            @endphp

            <label class="flex items-center gap-3 text-sm">
              <input type="checkbox" name="{{ $field }}[]" value="{{ $value }}"
                @checked(in_array($value, request($field, []))) onchange="document.getElementById('filter-form').submit()"
                class="rounded border-neutral-300 text-blue-600">

              <span>
                {{ $label }} ({{ $filterCounts[$field][$value] ?? 0 }})
              </span>
            </label>
          @endforeach

        </div>
      </details>
    @endforeach

    {{-- CONNECTION TYPES --}}
    <details open class="bg-white border border-neutral-200 rounded-2xl overflow-hidden">
      <summary class="cursor-pointer p-4 font-black flex justify-between items-center">
        Connection Types
        <span>⌄</span>
      </summary>

      <div class="p-4 space-y-3 border-t border-neutral-200">

        @foreach ($connections as $connection)
          <label class="flex items-center gap-3 text-sm">
            <input type="checkbox" name="connection_types[]" value="{{ $connection }}" @checked(in_array($connection, request('connection_types', [])))
              onchange="document.getElementById('filter-form').submit()"
              class="rounded border-neutral-300 text-blue-600">

            <span>
              {{ $connection }} ({{ $filterCounts['connection_types'][$connection] ?? 0 }})
            </span>
          </label>
        @endforeach

      </div>
    </details>

  </aside>
</div>
