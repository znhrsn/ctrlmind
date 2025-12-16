<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Notifications
        </h2>
    </x-slot>
    <div class="py-6 px-4">
        @forelse($all as $notification)
            <div class="p-3 mb-2 rounded border 
                        @if(is_null($notification->read_at)) border-blue-500 bg-blue-50 dark:bg-blue-900/20 @else border-gray-300 @endif">
                <div class="font-medium">
                    {{ $notification->data['title'] ?? 'Notification' }}
                </div>
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $notification->data['message'] ?? '' }}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <div class="py-4 px-6">
                <p class="text-gray-600 dark:text-gray-300">No notifications yet.</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $all->links() }}
        </div>
    </div>
</x-app-layout>
