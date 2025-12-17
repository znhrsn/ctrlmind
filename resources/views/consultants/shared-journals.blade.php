<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Shared Journals') }}</h2>
    </x-slot>

    <div class="p-6">
        <div class="mb-4 flex items-center justify-between">
            <form method="GET" action="{{ route('consultant.shared-journals') }}" class="flex items-center gap-2">
                <input type="text" name="q" placeholder="Search users (e.g. 'mia li')" value="{{ old('q', $q ?? '') }}" class="border rounded px-3 py-2 text-sm" />
                <button class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Search</button>
            </form>
            <div>
                <a href="{{ route('consultant.dashboard') }}" class="text-sm text-gray-500 hover:underline">Back</a>
            </div>
        </div>

        <div class="bg-white border rounded p-4">
            <h3 class="font-semibold mb-2">Users with Shared Journals</h3>

            @if($users->count())
                <div class="space-y-2">
                    @foreach($users as $u)
                        <div class="flex items-center justify-between p-2 border rounded">
                            <div>
                                <div class="font-medium">{{ $u->name }}</div>
                                <div class="text-xs text-gray-500">{{ ($stats[$u->id] ?? 0) }} shared entries • last shared {{ isset($lastShared[$u->id]) ? \Carbon\Carbon::parse($lastShared[$u->id])->diffForHumans() : '—' }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('consultant.shared-journals', array_merge(request()->except('page'), ['user_id' => $u->id])) }}" class="text-sm text-blue-500 hover:underline">View entries</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @else
                <p class="text-sm text-gray-500">No users found with shared journals.</p>
            @endif
        </div>

        @if($selectedUserId)
            <div class="mt-6 bg-white border rounded p-4">
                <h3 class="font-semibold mb-2">Shared Entries for {{ optional($entries->first()->user)->name ?? 'User' }}</h3>

                @if($entries->count())
                    <div class="space-y-3">
                        @foreach($entries as $e)
                            <div class="p-3 border rounded">
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($e->created_at)->format('M j, Y H:i') }}</div>
                                <div class="mt-2">{{ \Illuminate\Support\Str::limit($e->reflection, 300) }}</div>
                                <div class="mt-2 text-xs">
                                    <a href="{{ route('consultant.shared-journals', array_merge(request()->except('page'), ['user_id' => $selectedUserId, 'entry_id' => $e->id])) }}" class="text-blue-500 hover:underline">View full entry</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        {{ $entries->links() }}
                    </div>
                @else
                    <p class="text-sm text-gray-500">No shared entries for this user.</p>
                @endif
            </div>
        @endif

    </div>
</x-app-layout>
