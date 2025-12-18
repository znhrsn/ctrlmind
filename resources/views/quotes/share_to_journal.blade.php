<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Share Quote to Journal') }}
        </h2>
    </x-slot>

    <div class="py-7">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                
                <div class="bg-blue-50/50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-6 rounded-r-xl mb-8">
                    <p class="italic text-lg text-gray-800 dark:text-blue-100 leading-relaxed">
                        “{{ $quote->text }}”
                    </p>
                    @if($quote->author)
                        <p class="text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400 mt-3">
                            — {{ $quote->author }}
                        </p>
                    @endif
                </div>

                <form method="POST" action="{{ route('quotes.shareToJournal') }}">
                    @csrf
                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                    
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2">
                        Your Reflection
                    </label>
                    
                    <textarea name="reflection" rows="5" 
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 transition-all"
                              placeholder="How does this quote make you feel today?"></textarea>
                    
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('quotes.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                            Cancel
                        </a>
                        
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-green-100 dark:shadow-none">
                            Save to Journal
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