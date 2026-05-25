@php
  $brands = ['Dell', 'LG', 'Samsung', 'ASUS', 'AOC', 'Acer', 'MSI', 'Gigabyte', 'ViewSonic', 'Xiaomi'];
  $applications = ['business / personal', 'color grading', 'gaming', 'dual mode'];
  $sizes = ['less 24', '23 - 24', '25 - 27', '30 - 32', '32 more'];
  $resolutions = [
      '5120 x 1440',
      '3840 x 2160',
      '3840 x 1080',
      '3440 x 1440',
      '2560 x 1440',
      '2560 x 1080',
      '1920 x 1080',
  ];
  $refreshRates = ['500 Hz', '360 Hz', '290 Hz', '240 Hz', '180 Hz', '144 Hz', '120 Hz', '100 Hz', '60 Hz'];
  $panelTypes = ['OLED', 'IPS', 'TN', 'VA'];
  $aspectRatios = ['16:9', '16:10', '21:9', '32:9'];
  $responseTimes = ['1 ms or less', '4 ms', '5 ms more'];
  $connectionTypes = ['HDMI', 'DisplayPort', 'USB-C', 'Thunderbolt', 'VGA', 'USB', 'RJ45'];
  $curvatures = ['flat screen', 'curved'];

  function selectedValue($product, $field, $value)
  {
      return old($field, $product?->$field) === $value ? 'selected' : '';
  }
@endphp

<div>
  <label class="block text-sm font-semibold mb-2">Image URL</label>
  <input type="text" name="image" value="{{ old('image', $product?->image) }}"
    class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Brand</label>
  <select name="brand" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($brands as $brand)
      <option value="{{ $brand }}" {{ selectedValue($product, 'brand', $brand) }}>
        {{ $brand }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Name</label>
  <input type="text" name="name" value="{{ old('name', $product?->name) }}"
    class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Application</label>
  <select name="application" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($applications as $application)
      <option value="{{ $application }}" {{ selectedValue($product, 'application', $application) }}>
        {{ $application }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Display Size</label>
  <select name="display_size" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($sizes as $size)
      <option value="{{ $size }}" {{ selectedValue($product, 'display_size', $size) }}>
        {{ $size }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Resolution</label>
  <select name="resolution" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($resolutions as $resolution)
      <option value="{{ $resolution }}" {{ selectedValue($product, 'resolution', $resolution) }}>
        {{ $resolution }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Refresh Rate</label>
  <select name="refresh_rate" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($refreshRates as $refreshRate)
      <option value="{{ $refreshRate }}" {{ selectedValue($product, 'refresh_rate', $refreshRate) }}>
        {{ $refreshRate }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Panel Type</label>
  <select name="panel_type" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($panelTypes as $panelType)
      <option value="{{ $panelType }}" {{ selectedValue($product, 'panel_type', $panelType) }}>
        {{ $panelType }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Aspect Ratio</label>
  <select name="aspect_ratio" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($aspectRatios as $aspectRatio)
      <option value="{{ $aspectRatio }}" {{ selectedValue($product, 'aspect_ratio', $aspectRatio) }}>
        {{ $aspectRatio }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Response Time</label>
  <select name="response_time" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($responseTimes as $responseTime)
      <option value="{{ $responseTime }}" {{ selectedValue($product, 'response_time', $responseTime) }}>
        {{ $responseTime }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Connection Type</label>
  <select name="connection_type" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($connectionTypes as $connectionType)
      <option value="{{ $connectionType }}" {{ selectedValue($product, 'connection_type', $connectionType) }}>
        {{ $connectionType }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Screen Curvature</label>
  <select name="screen_curvature" class="w-full rounded-2xl border-gray-300 px-4 py-3">
    @foreach ($curvatures as $curvature)
      <option value="{{ $curvature }}" {{ selectedValue($product, 'screen_curvature', $curvature) }}>
        {{ $curvature }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Brightness</label>
  <input type="text" name="brightness" value="{{ old('brightness', $product?->brightness) }}" placeholder="400 nits"
    class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Color Bit</label>
  <input type="text" name="color_bit" value="{{ old('color_bit', $product?->color_bit) }}" placeholder="10-bit"
    class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Color Depth</label>
  <input type="text" name="color_depth" value="{{ old('color_depth', $product?->color_depth) }}"
    placeholder="1.07 billion colors" class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Color Gamut</label>
  <input type="text" name="color_gamut" value="{{ old('color_gamut', $product?->color_gamut) }}"
    placeholder="99% sRGB / 98% DCI-P3" class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Contrast Ratio</label>
  <input type="text" name="contrast_ratio" value="{{ old('contrast_ratio', $product?->contrast_ratio) }}"
    placeholder="1000:1" class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Dimension (W x H x D)</label>
  <input type="text" name="dimension" value="{{ old('dimension', $product?->dimension) }}"
    placeholder="614 x 365 x 215 mm" class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Accessory in Box</label>
  <textarea name="accessory_in_box" rows="3" class="w-full rounded-2xl border-gray-300 px-4 py-3">{{ old('accessory_in_box', $product?->accessory_in_box) }}</textarea>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Weight</label>
  <input type="text" name="weight" value="{{ old('weight', $product?->weight) }}" placeholder="6.2 kg"
    class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Connectivity</label>
  <textarea name="connectivity" rows="3" class="w-full rounded-2xl border-gray-300 px-4 py-3">{{ old('connectivity', $product?->connectivity) }}</textarea>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Full Spec</label>
  <textarea name="spec" rows="5" class="w-full rounded-2xl border-gray-300 px-4 py-3">{{ old('spec', $product?->spec) }}</textarea>
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Price</label>
  <input type="number" step="0.01" name="price" value="{{ old('price', $product?->price) }}"
    class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>

<div>
  <label class="block text-sm font-semibold mb-2">Discount (%)</label>
  <input type="number" min="0" max="100" name="discount"
    value="{{ old('discount', $product?->discount ?? 0) }}" class="w-full rounded-2xl border-gray-300 px-4 py-3">
</div>
