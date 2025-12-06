<x-app-layout>
    <x-slot name="header">
        <!-- Journal navigation with icons -->
        <div class="flex space-x-6">
            <!-- Journal Entries -->
            <a href="{{ route('journal.index') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded {{ request()->routeIs('journal.index') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:text-white' }}">
                <!-- Document icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M7 8h10M7 12h10M7 16h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Entries
            </a>

            <!-- Archived -->
            <a href="{{ route('journal.archived') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded {{ request()->routeIs('journal.archived') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:text-white' }}">
                <!-- Archive box icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 7h18M5 7v13h14V7M9 3h6v4H9V3z" />
                </svg>
                Archives
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                @if($entries->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No archived entries.</p>
                @else
                    <div class="space-y-6">
                        @foreach($entries as $entry)
                            <div class="relative bg-gray-900 text-white rounded-lg shadow p-6">

                                <!-- Timestamp -->
                                <span class="text-sm text-gray-400">
                                    @php
                                        $archivedAt = \Carbon\Carbon::parse($entry->archived_at);
                                        $daysLeft = max(0, 30 - $archivedAt->diffInDays(now('Asia/Manila')));
                                    @endphp
                                </span>

                                <!-- Quote -->
                                @if($entry->quote)
                                    <p class="italic mt-2">“{{ $entry->quote->text }}” — {{ $entry->quote->author }}</p>
                                @endif

                                <!-- Reflection -->
                                <p class="mt-2">{{ $entry->reflection }}</p>

                                <!-- Countdown until permanent deletion -->
                                @if($entry->archived_at)
                                    @php
                                        $archivedAt = \Carbon\Carbon::parse($entry->archived_at);
                                        $daysPassed = $archivedAt->diffInDays(now('Asia/Manila')); // always integer
                                        $daysLeft = max(0, 30 - $daysPassed); // force integer math
                                    @endphp

                                    @if($daysLeft > 0)
                                        <p class="text-sm text-red-500 mt-2">
                                            ⚠️ {{ intval($daysLeft) }}d left until permanent deletion
                                        </p>
                                    @else
                                        <p class="text-sm text-red-500 mt-2 font-bold">
                                            ⚠️ Entry scheduled for deletion
                                        </p>
                                    @endif
                                @endif

                                <!-- Restore button -->
                                <div class="mt-4 flex justify-end">
                                    <form method="POST" action="{{ route('journal.restore', $entry->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                            Restore
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
