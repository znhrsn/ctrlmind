<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Chat with Dr. {{ $user->name }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto h-[600px] flex flex-col bg-white dark:bg-gray-900 shadow rounded-lg">
        <!-- Messages -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3">
            @foreach($messages as $message)
                @php
                    // true if this message came from the client user
                    $isUserMessage = $message->sender_id == $user->id;

                    // fetch the sender model (if you haven't eager-loaded)
                    $sender = \App\Models\User::find($message->sender_id);

                    // get the first letter of their name
                    $initial = $sender ? strtoupper(substr($sender->name, 0, 1)) : '?';
                @endphp

                <div class="flex {{ $isUserMessage ? 'justify-start' : 'justify-end' }} items-end gap-2">
                    @if($isUserMessage)
                        <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            {{ $initial }}
                        </div>
                    @endif

                    <div class="max-w-sm px-4 py-2 rounded-2xl shadow
                        {{ $isUserMessage ? 'bg-gray-200 dark:bg-gray-700 dark:text-gray-100' : 'bg-green-500 text-white' }}">
                        <p>{{ $message->content }}</p>
                        <span class="text-xs text-gray-300 block mt-1 text-right">
                            {{ $message->created_at->timezone('Asia/Manila')->format('h:i A') }}
                        </span>
                    </div>

                    @unless($isUserMessage)
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            {{ $initial }}
                        </div>
                    @endunless
                </div>
            @endforeach
        </div>

        <!-- Input -->
        <div class="border-t border-gray-200 dark:border-gray-700 p-3 bg-gray-50 dark:bg-gray-800">
            <form action="{{ route('consultant.chat.reply', $user->id) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <input type="text" name="content"
                       class="flex-1 rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-green-500 focus:border-green-500 px-4 py-2"
                       placeholder="Type a reply..." required>
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600">
                    Send
                </button>
            </form>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-messages');
        chatBox.scrollTop = chatBox.scrollHeight;
        document.querySelector('input[name="content"]').focus();
    </script>
</x-app-layout>
