<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Journal Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="p-6 bg-gray-900 text-white rounded-lg shadow">
                <p class="text-lg italic mb-4">“{{ $quote->text }}” — {{ $quote->author }}</p>

                <form method="POST" action="{{ route('journal.store') }}">
                    @csrf
                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                    <textarea name="reflection" rows="4" placeholder="This quote made me realize..."
                              class="w-full px-4 py-2 rounded border border-gray-600 bg-gray-800 text-white placeholder-gray-400"></textarea>
                    <button type="submit" class="mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Save to Journal
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
