<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Archived Journal Entries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                @if($entries->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No archived entries.</p>
                @else
                    @foreach($entries as $entry)
                        <div class="bg-gray-900 text-white rounded-lg shadow p-6 mb-4">
                            @if($entry->quote)
                                <p class="italic">“{{ $entry->quote->text }}” — {{ $entry->quote->author }}</p>
                            @endif
                            <p class="mt-2">{{ $entry->reflection }}</p>
                            <span class="text-sm text-gray-400">Archived on {{ $entry->deleted_at->format('M d, Y') }}</span>

                            <!-- Restore button -->
                            <form method="POST" action="{{ route('journal.restore', $entry->id) }}" class="mt-3">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    Restore
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
