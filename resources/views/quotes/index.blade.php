<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saved Quotes') }}
        </h2>
    </x-slot>

    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6">
                
                @if($userQuotes->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500 dark:text-gray-400 italic">You haven’t saved any quotes yet.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($userQuotes as $quote)
                            <div class="relative rounded-2xl shadow-sm p-6 transition-all border
                                @if($quote->pivot && $quote->pivot->is_pinned)
                                    border-blue-400 bg-blue-50 dark:bg-blue-900/30 dark:border-blue-500/50
                                @else
                                    bg-gray-50 dark:bg-gray-900 border-gray-100 dark:border-gray-700
                                @endif">

                                <form method="POST" action="{{ route('quotes.pin') }}" class="absolute top-4 right-4">
                                    @csrf
                                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                                    <button type="submit" class="text-2xl focus:outline-none transition-transform hover:scale-110">
                                        @if($quote->pivot && $quote->pivot->is_pinned)
                                            <span class="text-yellow-500">★</span> @else
                                            <span class="text-gray-300 dark:text-gray-600 hover:text-yellow-500">☆</span>
                                        @endif
                                    </button>
                                </form>

                                <p class="text-lg italic font-medium text-gray-900 dark:text-gray-100 pr-8">
                                    “{{ $quote->text }}”
                                </p>
                                
                                @if($quote->author)
                                    <p class="text-sm font-bold uppercase tracking-widest mt-2 text-gray-500 dark:text-gray-400">
                                        — {{ $quote->author }}
                                    </p>
                                @endif

                                <div class="mt-6 flex items-center justify-between border-t border-gray-200 dark:border-gray-800 pt-4">
                                    <div class="flex items-center gap-4">
                                        <form method="POST" action="{{ route('quotes.toggle') }}">
                                            @csrf
                                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                                            <button type="submit" title="Unsave" class="group flex items-center gap-1">
                                                <span class="text-red-500 text-2xl group-hover:scale-110 transition-transform">♥</span>
                                                <span class="text-[10px] font-bold uppercase tracking-tighter text-gray-400 dark:text-gray-500">Saved</span>
                                            </button>
                                        </form>
                                    </div>

                                    <a href="{{ route('quotes.showShareForm', $quote->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-black uppercase tracking-widest rounded-lg transition-colors shadow-md shadow-green-100 dark:shadow-none">
                                        Share to Journal
                                    </a>
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