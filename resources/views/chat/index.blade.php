<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Chat with Dr. {{ $consultant->name ?? 'Consultant' }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-4 h-[calc(100vh-160px)]">
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl overflow-hidden flex flex-col h-full border border-gray-100 dark:border-gray-700">
            
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth bg-gray-50/50 dark:bg-gray-900/50">
                @php $lastDate = null; @endphp
                
                @foreach($messages as $message)
                    @php
                        $isUser = $message->sender_id == auth()->id();
                        $sender = \App\Models\User::find($message->sender_id);
                        $initial = strtoupper(substr($sender->name, 0, 1));
                        
                        // Messenger-style Date Divider Logic
                        $currentDate = $message->created_at->timezone('Asia/Manila')->format('F j, Y');
                        $showDateDivider = ($lastDate !== $currentDate);
                        $lastDate = $currentDate;
                    @endphp

                    {{-- Date Divider --}}
                    @if($showDateDivider)
                        <div class="flex justify-center my-6">
                            <span class="px-4 py-1 rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 shadow-sm">
                                {{ $message->created_at->timezone('Asia/Manila')->isToday() ? 'Today' : ($message->created_at->timezone('Asia/Manila')->isYesterday() ? 'Yesterday' : $currentDate) }}
                            </span>
                        </div>
                    @endif

                    <div class="flex {{ $isUser ? 'justify-end' : 'justify-start' }} items-end gap-3 group">
                        @unless($isUser)
                            <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 flex items-center justify-center border border-gray-300 dark:border-gray-600 shadow-sm">
                                <span class="text-xs font-black text-gray-600 dark:text-gray-300">{{ $initial }}</span>
                            </div>
                        @endunless

                        <div class="flex flex-col {{ $isUser ? 'items-end' : 'items-start' }} max-w-[80%] sm:max-w-md">
                            {{-- Message Bubble --}}
                            <div class="px-4 py-2 rounded-2xl shadow-sm border transition-all
                                {{ $isUser 
                                    ? 'bg-blue-600 border-blue-500 text-white rounded-br-none' 
                                    : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 rounded-bl-none' 
                                }}">
                                <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                            </div>
                            
                            {{-- Time Stamp (Messenger style - subtle) --}}
                            <span class="text-[9px] font-bold tracking-tight text-gray-400 dark:text-gray-500 mt-1 px-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ $message->created_at->timezone('Asia/Manila')->format('g:i A') }}
                            </span>
                        </div>

                        @if($isUser)
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex-shrink-0 flex items-center justify-center border border-blue-200 dark:border-blue-800 shadow-sm">
                                <span class="text-xs font-black text-blue-600 dark:text-blue-400">{{ $initial }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
                <form action="{{ route('chat.store') }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="consultant_id" value="{{ $consultant->id ?? 1 }}">
                    
                    <div class="relative flex-1">
                        <input id="chat-input" type="text" name="content" autocomplete="off"
                               class="w-full rounded-full border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent px-5 py-3 text-sm transition-all"
                               placeholder="Type your message..." required autofocus>
                    </div>

                    <button type="submit"
                            class="p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full transition-all shadow-lg shadow-blue-100 dark:shadow-none active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatBox = document.getElementById('chat-messages');
        const inputField = document.getElementById('chat-input');

        const scrollToBottom = () => {
            if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
        };

        scrollToBottom();
        if (inputField) inputField.focus();
        window.addEventListener('resize', scrollToBottom);
    });
    </script>

    <style>
        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }
        #chat-messages::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.3);
            border-radius: 10px;
        }
    </style>
</x-app-layout>