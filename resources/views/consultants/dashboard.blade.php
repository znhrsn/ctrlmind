<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('My Clients') }}
            </h2>
            <span class="text-xs font-bold uppercase tracking-widest text-gray-400">
                Consultant View
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($clients as $client)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-5 hover:border-blue-500 transition-colors">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                {{-- Simple Avatar Placeholder --}}
                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                </div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-gray-900 dark:text-gray-100 truncate">
                                        {{ $client->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $client->email }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0">
                                <a href="{{ route('consultant.chat', $client->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Chat
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 italic font-medium">
                            No clients assigned yet.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>