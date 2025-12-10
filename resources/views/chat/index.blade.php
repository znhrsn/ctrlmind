<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Chat with Dr. {{ $consultant->name ?? 'Consultant' }}
        </h2>
    </x-slot>

    <!-- Fixed-height chat card -->
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 shadow rounded-lg overflow-hidden flex flex-col" style="height: 600px;">

        <!-- Scrollable messages area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3">
            @foreach($messages as $message)
                @php
                    $isUser = $message->sender_id == auth()->id();
                    $sender = \App\Models\User::find($message->sender_id);
                    $initial = strtoupper(substr($sender->name, 0, 1)); // first letter of sender's name
                @endphp

                <div class="flex {{ $isUser ? 'justify-end' : 'justify-start' }} items-end gap-2">
                    @unless($isUser)
                        <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            {{ $initial }}
                        </div>
                    @endunless

                    <div class="max-w-sm px-4 py-2 rounded-2xl shadow
                        {{ $isUser ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-100' }}">
                        <p>{{ $message->content }}</p>
                        <span class="text-xs text-gray-300 block mt-1 text-right">
                            {{ $message->created_at->timezone('Asia/Manila')->format('h:i A') }}
                        </span>
                    </div>

                    @if($isUser)
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            {{ $initial }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Input bar pinned at bottom of card -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-3 bg-gray-50 dark:bg-gray-800">
            <form action="{{ route('chat.store') }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <input type="hidden" name="consultant_id" value="{{ $consultant->id ?? 1 }}">
                <input id="chat-input" type="text" name="content"
                       class="flex-1 rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                       placeholder="Type a message..." required autofocus>
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                    Send
                </button>
            </form>
        </div>
    </div>

    <!-- Auto-scroll and auto-focus -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatBox = document.getElementById('chat-messages');
        const inputField = document.getElementById('chat-input');

        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
        if (inputField) inputField.focus();
    });
    </script>
</x-app-layout>