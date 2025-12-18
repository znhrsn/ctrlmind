<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Shared Journals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($journals as $journal)
                    {{-- Adaptive Card: White in Light Mode, Gray-800 in Dark Mode --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100 dark:border-gray-700">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                {{-- User name: Dark gray in Light, Blue-400 in Dark --}}
                                <h3 class="font-bold text-lg text-gray-900 dark:text-blue-400">
                                    {{ $journal->user->name }}
                                </h3>
                                {{-- Email --}}
                                <p class="text-sm italic text-gray-500 dark:text-gray-400">
                                    {{ $journal->user->email }}
                                </p>
                            </div>
                            
                            {{-- Date --}}
                            <span class="text-xs font-medium text-gray-400 dark:text-gray-500">
                                {{ $journal->updated_at->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                            </span>
                        </div>

                        {{-- Section: Quote --}}
                        @if($journal->quote)
                            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-900/50 border-l-4 border-blue-500 rounded-r-md">
                                <blockquote class="italic text-gray-700 dark:text-gray-300">
                                    “{{ $journal->quote->text }}”
                                </blockquote>
                                @if($journal->quote->author)
                                    <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">— {{ $journal->quote->author }}</p>
                                @endif
                            </div>
                        @endif

                        {{-- Section: Journal Content --}}
                        <div class="prose dark:prose-invert max-w-none">
                            @if(!empty($journal->title))
                                <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-2">
                                    {{ $journal->title }}
                                </h4>
                            @endif

                            @if(!empty($journal->reflection))
                                <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                                    {{ $journal->reflection }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 font-medium">No shared journals found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>