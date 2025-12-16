<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Shared Journals</h2>
    </x-slot>

    <div class="p-6 space-y-4 text-white">
        @forelse($journals as $journal)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-white">
                <div class="flex justify-between">
                    <div>
                        {{-- User name --}}
                        <span class="font-semibold text-white">{{ $journal->user->name }}</span>
                        {{-- Email below name --}}
                        <div class="text-sm italic text-gray-400">
                            {{ $journal->user->email }}
                        </div>
                    </div>
                    <span class="text-xs text-white">
                        {{ $journal->updated_at->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                    </span>
                </div>

                {{-- Show quote if the entry is based on a quote --}}
                @if($journal->quote)
                    <blockquote class="mt-3 italic">“{{ $journal->quote->text }}”</blockquote>
                    @if($journal->quote->author)
                        <p class="text-s text-gray-300">— {{ $journal->quote->author }}</p>
                    @endif
                @endif

                {{-- Show title only if it exists; do not render "Untitled" --}}
                @if(!empty($journal->title))
                    <h3 class="mt-3 font-semibold text-white">{{ $journal->title }}</h3>
                @endif

                {{-- Always show the reflection/free writing --}}
                @if(!empty($journal->reflection))
                    <p class="mt-2 text-s text-white">{{ $journal->reflection }}</p>
                @endif
            </div>
        @empty
            <p class="text-white">No shared journals yet.</p>
        @endforelse
    </div>
</x-app-layout>
