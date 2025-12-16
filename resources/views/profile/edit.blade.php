<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">
        {{-- Profile Information Form --}}
        @include('profile.partials.update-profile-information-form', ['user' => $user])
    </div>
</x-app-layout>
