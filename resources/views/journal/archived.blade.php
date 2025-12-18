<x-app-layout>
    <x-slot name="header">
        <div class="flex space-x-6">
            <a href="{{ route('journal.index') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded transition-colors {{ request()->routeIs('journal.index') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="font-bold uppercase tracking-widest text-xs">Entries</span>
            </a>

            <a href="{{ route('journal.archived') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded transition-colors {{ request()->routeIs('journal.archived') ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v13h14V7M9 3h6v4H9V3z" />
                </svg>
                <span class="font-bold uppercase tracking-widest text-xs">Archives</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6">
                
                <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-widest mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    Archived Reflections
                </h3>

                @if($entries->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400 italic">No archived entries found.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($entries as $entry)
                            @php
                                $archivedAt = \Carbon\Carbon::parse($entry->archived_at);
                                $daysPassed = $archivedAt->diffInDays(now('Asia/Manila'));
                                $daysLeft = max(0, 30 - $daysPassed);
                            @endphp

                            <div class="relative bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                                
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-500">
                                        Archived on: {{ $archivedAt->timezone('Asia/Manila')->format('M j, Y — g:i A') }}
                                    </span>

                                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                                        <span class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-tighter">
                                            @if($daysLeft > 0)
                                                ⚠️ Deleting in {{ intval($daysLeft) }} days
                                            @else
                                                ⚠️ Scheduled for deletion
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                @if($entry->quote)
                                    <div class="mb-4 border-l-4 border-gray-300 dark:border-gray-600 pl-4 py-1">
                                        <p class="italic text-gray-600 dark:text-gray-400 text-sm">“{{ $entry->quote->text }}”</p>
                                        <p class="text-[10px] font-bold uppercase text-gray-500 mt-1">— {{ $entry->quote->author }}</p>
                                    </div>
                                @endif

                                <p class="text-gray-800 dark:text-gray-200 leading-relaxed mb-6">{{ $entry->reflection }}</p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-800">
                                    <p class="text-[9px] text-gray-400 uppercase font-medium">Restoring will move this back to your main feed</p>
                                    
                                    <form method="POST" action="{{ route('journal.restore', $entry->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-bold text-xs uppercase tracking-widest transition-all shadow-md shadow-blue-100 dark:shadow-none">
                                            Restore Entry
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
                © 2025 CTRL+Mind EVSU
            </footer>
        </div>
    </div>
</x-app-layout>