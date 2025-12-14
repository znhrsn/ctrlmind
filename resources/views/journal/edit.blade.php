<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Journal Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('journal.update', $entry->id) }}">
                @csrf
                @method('PUT')

                <textarea name="reflection" rows="8"
                          class="w-full p-4 rounded bg-gray-800 text-white"
                          required>{{ old('reflection', $entry->reflection) }}</textarea>

                <div class="mt-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Update Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
