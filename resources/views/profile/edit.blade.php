<x-app-layout>
  <div class="bg-white min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-10">

      <div class="mb-8">
        <h1 class="text-4xl font-black text-black">My Profile</h1>
        <p class="mt-2 text-neutral-500">Manage your personal information and shipping address.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8">

        {{-- LEFT PROFILE CARD --}}
        <aside class="bg-white border border-neutral-200 rounded-3xl p-6 h-fit">
          <div
            class="w-24 h-24 rounded-full bg-black text-white flex items-center justify-center text-3xl font-black mx-auto">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>

          <div class="text-center mt-5">
            <h2 class="text-xl font-black">{{ auth()->user()->name }}</h2>
            <p class="text-sm text-neutral-500 mt-1">{{ auth()->user()->email }}</p>

            <span class="inline-flex mt-4 px-3 py-1 rounded-full bg-neutral-100 text-xs font-black uppercase">
              {{ auth()->user()->role }}
            </span>
          </div>
        </aside>

        {{-- RIGHT CONTENT --}}
        <div class="space-y-6">

          <div class="bg-white border border-neutral-200 rounded-3xl p-6">
            @include('profile.partials.update-profile-information-form')
          </div>

          <div class="bg-white border border-neutral-200 rounded-3xl p-6">
            @include('profile.partials.update-password-form')
          </div>

          <div class="bg-white border border-red-200 rounded-3xl p-6">
            @include('profile.partials.delete-user-form')
          </div>

        </div>

      </div>
    </div>
  </div>
</x-app-layout>
