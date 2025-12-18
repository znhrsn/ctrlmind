<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Search Results for: "{{ $query }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Matching Clients</h3>
                @if($clients->isEmpty())
                    <p class="text-gray-500 text-sm">No users found with that name.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($clients as $client)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700">
                                <div>
                                    <p class="font-bold dark:text-white">{{ $client->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $client->email }}</p>
                                </div>
                                <a href="{{ route('consultant.dashboard', ['user_id' => $client->id]) }}" class="text-blue-500 hover:underline text-sm font-bold">View Dashboard</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Shared Journals</h3>
                @if($sharedJournals->isEmpty())
                    <p class="text-gray-500 text-sm">No journals found for this search.</p>
                @else
                    <div class="space-y-3">
                        @foreach($sharedJournals as $journal)
                            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                <div>
                                    <p class="font-bold dark:text-white">{{ $journal->user->name }}'s Journal</p>
                                    <p class="text-xs text-gray-500">Shared on {{ $journal->created_at->format('M d, Y') }}</p>
                                </div>
                                <a href="{{ route('consultant.shared-journals', ['search' => $journal->user->name]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold uppercase">Read</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('consultant.dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm">← Back to Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>