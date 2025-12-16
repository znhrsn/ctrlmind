<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('My Clients') }}
            </h2>

            {{-- Notifications link --}}
            <a href="{{ route('consultant.notifications.index') }}" 
               class="relative text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                Notifications
                @if($unreadCount > 0)
                    <span class="ml-1 bg-red-600 text-white rounded-full px-2 text-xs">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4">
        @forelse($clients as $client)
            <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-800 p-4 rounded mb-2">
                <div>
                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $client->name }}</p>
                    <p class="italic text-gray-600 dark:text-gray-400">{{ $client->email }}</p>
                </div>
                <div>
                    <a href="{{ route('consultant.chat', $client->id) }}"
                       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Chat
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400 italic">
                No clients assigned yet.
            </p>
        @endforelse
    </div>
</x-app-layout>
