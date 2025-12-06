<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CTRL+Mind Profile') }}
        </h2>
    </x-slot>

    <div class="py-7 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Quote of the Day -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Quote of the Day</h3>

                <!-- Save Quote form -->
                <form method="POST" action="{{ route('quotes.toggle') }}">
                    @csrf
                    <input type="hidden" name="text" value="{{ $quote->text }}">
                    <input type="hidden" name="author" value="{{ $quote->author }}">

                    <button type="submit" class="focus:outline-none">
                        @if($quote)
                            <div class="p-6">
                                <p class="text-lg italic text-white">“{{ $quote->text }}” — {{ $quote->author }}</p>
                                <form method="POST" action="{{ route('quotes.toggle') }}" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                                    <button type="submit" class="focus:outline-none">
                                        @if($savedQuoteIds->contains($quote->id))
                                            <span class="text-red-500 text-2xl">♥</span>
                                        @else
                                            <span class="text-gray-400 text-2xl">♡</span>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="p-6 text-gray-500">No quotes available yet. Please add some in the admin panel.</p>
                        @endif
                    </button>
                </form>

            <!-- Mental Wellness Resources -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Mental Wellness Resources</h3>
                <!-- Add your resource links or content here -->
            </div>

            <!-- Daily Check-in -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Daily Check-in</h3>
                <a href="{{ route('checkin.start') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Start Today's Check-in
                </a>
            </div>

            <!-- Footer -->
            <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
                © 2025 CTRL+Mind EVSU
            </footer>

        </div>
    </div>
</x-app-layout>