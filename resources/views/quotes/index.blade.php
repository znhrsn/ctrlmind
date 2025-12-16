<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saved Quotes') }}
        </h2>
    </x-slot>

    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                @if($userQuotes->isEmpty())
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <p class="text-gray-500 dark:text-gray-400">You haven’t saved any quotes yet.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($userQuotes as $quote)
                            <!-- Quote container -->
                            <div class="relative rounded-lg shadow p-6
                                @if($quote->pivot && $quote->pivot->is_pinned)
                                    border-2 border-blue-500 bg-gradient-to-r from-blue-800 via-blue-700 to-blue-600
                                @else
                                    bg-gray-900 text-white
                                @endif">

                                <!-- Clickable star badge -->
                                <form method="POST" action="{{ route('quotes.pin') }}" class="absolute top-2 right-2">
                                    @csrf
                                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                                    <button type="submit" class="text-2xl focus:outline-none">
                                        @if($quote->pivot && $quote->pivot->is_pinned)
                                            <span class="text-blue-400">★</span> <!-- filled star -->
                                        @else
                                            <span class="text-gray-400 hover:text-blue-400">☆</span> <!-- empty star -->
                                        @endif
                                    </button>
                                </form>

                                <p class="text-lg italic">“{{ $quote->text }}”</p>
                                @if($quote->author)
                                    <p class="text-sm text-gray-400">— {{ $quote->author }}</p>
                                @endif

                                <div class="mt-4 flex items-center gap-6">
                                    <!-- Unsave -->
                                    <form method="POST" action="{{ route('quotes.toggle') }}">
                                        @csrf
                                        <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                                        <button type="submit" title="Unsave">
                                            <span class="text-red-500 text-2xl">♥</span>
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
