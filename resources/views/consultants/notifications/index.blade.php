<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @forelse($all as $notification)
                    <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-5 rounded-2xl border transition-all
                        @if(is_null($notification->read_at)) 
                            border-blue-500 shadow-md ring-1 ring-blue-500/20 
                        @else 
                            border-gray-200 dark:border-gray-700 opacity-75
                        @endif">
                        
                        {{-- Unread Indicator Dot --}}
                        @if(is_null($notification->read_at))
                            <span class="absolute top-5 right-5 h-3 w-3 rounded-full bg-blue-500 animate-pulse"></span>
                        @endif

                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg text-xl">
                                🔔
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 dark:text-gray-100">
                                    {{ $notification->data['title'] ?? 'System Update' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>

                                {{-- Action Button: Moved inside the loop --}}
                                @if(isset($notification->data['url']))
                                    <div class="mt-4">
                                        <a href="{{ $notification->data['url'] }}" 
                                           class="inline-flex items-center px-4 py-2 text-xs font-bold uppercase tracking-widest text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                                            View Details
                                        </a>
                                    </div>
                                @endif

                                <div class="flex items-center gap-2 mt-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 italic font-medium">No notifications yet.</p>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $all->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>