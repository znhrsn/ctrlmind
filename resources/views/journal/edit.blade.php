<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Journal Entry') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                
                {{-- Quote Context (Optional) --}}
                @if($entry->quote)
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 border-l-4 border-blue-500 rounded-r-lg">
                        <p class="text-sm italic text-gray-600 dark:text-gray-400">“{{ $entry->quote->text }}”</p>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mt-2">— {{ $entry->quote->author }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('journal.update', $entry->id) }}">
                    @csrf
                    @method('PUT')

                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">
                        Your Reflection
                    </label>

                    {{-- Adaptive Textarea --}}
                    <textarea name="reflection" rows="10"
                              class="w-full p-5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all leading-relaxed"
                              placeholder="Update your thoughts..."
                              required>{{ old('reflection', $entry->reflection) }}</textarea>

                    <div class="mt-8 flex items-center justify-between">
                        {{-- Back Button --}}
                        <a href="{{ route('journal.index') }}" 
                           class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                            Cancel Changes
                        </a>

                        {{-- Update Button --}}
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-blue-100 dark:shadow-none">
                            Update Entry
                        </button>
                    </div>
                </form>
            </div>

            <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
                © 2025 CTRL+Mind EVSU
            </footer>
        </div>
    </div>
</x-app-layout>