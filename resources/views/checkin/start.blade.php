<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daily Check-in') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <p class="mb-4">Welcome to your daily check-in! Get started by opening the calendar.</p>
        <a href="{{ route('checkin.index') }}" class="bg-blue-500 px-4 py-2 text-white rounded">Open Calendar</a>
    </div>
</x-app-layout>
