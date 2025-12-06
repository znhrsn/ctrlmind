<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Journal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

                <!-- Free-form journal entry -->
                <div class="mb-8">
                    <form method="POST" action="{{ route('journal.store') }}">
                        @csrf
                        <textarea name="reflection" rows="4" placeholder="Write your thoughts here..."
                                  class="w-full px-4 py-2 rounded border border-gray-600 bg-gray-800 text-white placeholder-gray-400"></textarea>
                        <button type="submit" class="mt-3 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            Save Journal Entry
                        </button>
                    </form>
                </div>

                <!-- Existing entries -->
                @if($entries->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">You haven’t written any reflections yet.</p>
                @else
                    <div class="space-y-6">
                        @foreach($entries as $entry)
                            <div class="bg-gray-900 text-white rounded-lg shadow p-6">
                                @if($entry->quote)
                                    <p class="italic">“{{ $entry->quote->text }}” — {{ $entry->quote->author }}</p>
                                @endif

                                <p class="mt-2">{{ $entry->reflection }}</p>
                                <span class="text-sm text-gray-400">Added on {{ $entry->created_at->format('M d, Y') }}</span>

                                <div class="mt-4 flex gap-4">
                                    <!-- Archive -->
                                    <form method="POST" action="{{ route('journal.archive', $entry->id) }}"
                                        onsubmit="return confirm('Are you sure? This entry helps track your journey.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                            Archive
                                        </button>
                                    </form>

                                    <!-- Share to Consultant -->
                                    <form method="POST" action="{{ route('journal.share', $entry->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1 rounded {{ $entry->shared_with_consultant ? 'bg-green-600' : 'bg-green-500' }}">
                                            {{ $entry->shared_with_consultant ? 'Unshare' : 'Share with Consultant' }}
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
