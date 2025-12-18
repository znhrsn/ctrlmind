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

    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6">

                {{-- New Entry Form --}}
                <div class="mb-8">
                    <form method="POST" action="{{ route('journal.store') }}">
                        @csrf
                        <textarea name="reflection" rows="4" placeholder="Write your thoughts here..."
                                  class="w-full px-4 py-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 transition-all"></textarea>
                        <button type="submit" class="mt-3 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold text-sm uppercase tracking-widest transition-colors shadow-md shadow-green-100 dark:shadow-none">
                            Save Journal Entry
                        </button>
                    </form>
                </div>

                @if($entries->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-center py-10 italic">You haven’t written any reflections yet.</p>
                @else
                    <div class="space-y-6">
                        @foreach($entries as $entry)
                            <div class="relative bg-white dark:bg-gray-900 text-gray-900 dark:text-white rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md transition-shadow">

                                <div x-data="{ open: false, showArchiveModal: false }" class="absolute top-4 right-4">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-xl font-bold p-1">
                                        ⋮
                                    </button>

                                    <div x-show="open" @click.away="open = false" x-cloak
                                         class="absolute right-0 mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl z-10 w-48 overflow-hidden">
                                        <ul class="text-sm">
                                            <li>
                                                <form method="POST" action="{{ route('journal.share', $entry->id) }}">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                                        {{ $entry->shared_with_consultant ? 'Unshare Entry' : 'Share with Consultant' }}
                                                    </button>
                                                </form>
                                            </li>
                                            @if($entry->created_at->timezone('Asia/Manila')->gt(now('Asia/Manila')->subDay()))
                                                <li>
                                                    <a href="{{ route('journal.edit', $entry->id) }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                                                        Edit Reflection
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <button type="button" @click="showArchiveModal = true" class="w-full text-left px-4 py-3 hover:bg-red-50 dark:hover:bg-red-900/30 text-red-600">
                                                    Archive Entry
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- Archive Confirmation Modal --}}
                                    <div x-show="showArchiveModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                                        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showArchiveModal = false"></div>
                                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl w-full max-w-sm relative z-10">
                                            <h2 class="text-lg font-black text-gray-900 dark:text-white mb-2">Confirm Archive</h2>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Are you sure you want to archive this entry? You can find it in your Archives later.</p>
                                            <div class="flex justify-end gap-3">
                                                <button @click="showArchiveModal = false" class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                                                <form method="POST" action="{{ route('journal.archiveEntry', $entry->id) }}">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-widest bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Archive</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 mb-3">
                                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">
                                        {{ $entry->created_at->timezone('Asia/Manila')->format('F j, Y — g:i A') }}
                                    </span>
                                </div>

                                @if($entry->quote)
                                    <div class="bg-blue-50/50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-4 rounded-r-xl">
                                        <p class="italic text-gray-700 dark:text-blue-200 text-sm">“{{ $entry->quote->text }}”</p>
                                        <p class="text-[10px] font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 mt-2">— {{ $entry->quote->author }}</p>
                                    </div>
                                @endif

                                <p class="text-gray-700 dark:text-gray-200 leading-relaxed">{{ $entry->reflection }}</p>

                                @if($entry->created_at->timezone('Asia/Manila')->gt(now('Asia/Manila')->subDay()))
                                    <div class="mt-6 pt-4 border-t border-gray-50 dark:border-gray-800 flex justify-end">
                                        <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400">
                                            Editable until: {{ $entry->created_at->timezone('Asia/Manila')->addDay()->format('M j, g:i A') }}
                                        </span>
                                    </div>
                                @endif
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