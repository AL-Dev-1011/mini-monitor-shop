<section>
  <header>
    <h2 class="text-2xl font-black text-black">
      Profile Information
    </h2>

    <p class="mt-1 text-sm text-neutral-500">
      Update your personal information and default shipping address.
    </p>
  </header>

  <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
      <div>
        <x-input-label for="name" value="Display Name" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-2xl" :value="old('name', $user->name)"
          required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
      </div>

      <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl"
          :value="old('email', $user->email)" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
      </div>

      <div>
        <x-input-label for="first_name" value="First Name" />
        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full rounded-2xl"
          :value="old('first_name', $user->first_name)" />
      </div>

      <div>
        <x-input-label for="last_name" value="Last Name" />
        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full rounded-2xl"
          :value="old('last_name', $user->last_name)" />
      </div>

      <div>
        <x-input-label for="phone" value="Phone Number" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-2xl"
          :value="old('phone', $user->phone)" />
      </div>
    </div>

    <div class="border-t border-neutral-200 pt-6">
      <h3 class="text-xl font-black text-black mb-4">
        Default Shipping Address
      </h3>

      <div class="space-y-5">
        <div>
          <x-input-label for="address" value="Address" />
          <textarea id="address" name="address" rows="4"
            class="mt-1 block w-full rounded-2xl border-gray-300 shadow-sm focus:border-black focus:ring-black">{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

          <div>
            <x-input-label for="province" value="Province" />
            <x-text-input id="province" name="province" type="text" class="mt-1 block w-full rounded-2xl"
              :value="old('province', $user->province)" />
          </div>

          <div>
            <x-input-label for="postal_code" value="Postal Code" />
            <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full rounded-2xl"
              :value="old('postal_code', $user->postal_code)" />
          </div>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <button class="px-6 py-3 bg-black text-white rounded-2xl font-black">
        Save Profile
      </button>

      @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
          class="text-sm text-green-600 font-bold">
          Saved.
        </p>
      @endif
    </div>
  </form>
</section>
