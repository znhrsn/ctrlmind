<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('All Check-Ins') }}</h2>
    </x-slot>

    <div class="p-6">
        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">Back to dashboard</a>
            <h3 class="text-lg font-semibold">All Check-Ins</h3>
        </div>

        <div class="bg-white border rounded shadow-sm p-4">
            @if($checkins->count())
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-500">
                            <th class="pr-4">Date</th>
                            <th class="pr-4">Period</th>
                            <th class="pr-4">Mood</th>
                            <th class="pr-4">Note</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($checkins as $c)
                            <tr class="py-2">
                                <td class="py-2">{{ \Carbon\Carbon::parse($c->date)->format('Y-m-d') }}</td>
                                <td class="py-2">{{ ucfirst($c->period) }}</td>
                                <td class="py-2">{{ [1=>'😢',2=>'🙁',3=>'😐',4=>'🙂',5=>'😊'][$c->mood ?? 3] }}</td>
                                <td class="py-2">{{ $c->note ? \Illuminate\Support\Str::limit($c->note, 80) : 'No note' }}</td>
                                <td class="py-2 text-right">
                                    <a href="{{ route('checkin.index', ['open_date' => $c->date, 'open_period' => $c->period]) }}" class="text-blue-500 text-xs hover:underline mr-3">View</a>
                                    @if(\Carbon\Carbon::now()->diffInSeconds($c->created_at) <= (10 * 3600))
                                    <form action="{{ route('checkin.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Delete this check-in?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 text-xs">Delete</button>
                                    </form>
                                    @else
                                    <span class="text-xs text-gray-500">Deletion window expired</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $checkins->links() }}
                </div>
            @else
                <p class="text-sm text-gray-500">No check-ins yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>