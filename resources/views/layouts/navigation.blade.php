<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side: Logo + Navigation -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/ctrl-mind-logo-2.jpg') }}" 
                            alt="CTRL+Mind Logo" 
                            class="block h-20 w-auto dark:hidden transition-all duration-300">
                        
                        <img src="{{ asset('images/ctrl-mind-logo.jpg') }}" 
                            alt="CTRL+Mind Logo" 
                            class="hidden h-20 w-auto dark:block transition-all duration-300">
                    </a>
                </div>
                
            <div x-data="{ 
                darkMode: localStorage.getItem('dark') === 'true',
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('dark', this.darkMode);
                    document.documentElement.classList.toggle('dark', this.darkMode);
                }
            }" class="flex items-center">
                <button 
                    @click="toggle"
                    type="button" 
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none bg-gray-200 dark:bg-blue-600"
                    role="switch" 
                    aria-checked="false"
                >
                    <span 
                        aria-hidden="true" 
                        :class="darkMode ? 'translate-x-5 bg-gray-900' : 'translate-x-0 bg-white'"
                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out flex items-center justify-center"
                    >
                        <svg x-show="darkMode" class="h-3 w-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.01 8.01 0 0110.586 10.586z"></path></svg>
                        <svg x-show="!darkMode" class="h-3 w-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                    </span>
                </button>
            </div>

                {{-- Consultant-only links --}}
                    @if(auth()->user()->role === 'consultant')
                        <x-nav-link :href="route('consultant.dashboard')" :active="request()->routeIs('consultant.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('consultant.notifications.index')" :active="request()->routeIs('consultant.notifications.index')" class="relative">
                            {{ __('Notifications') }}
                            
                            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                            
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-3 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white dark:ring-gray-800">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </x-nav-link>
                                                <x-nav-link :href="route('consultant.shared-journals')" :active="request()->routeIs('consultant.shared-journals')">
                            Shared Journals
                        </x-nav-link>

                        <form action="{{ route('consultant.search') }}" method="GET" class="ml-4">
                            <input type="text" name="query" placeholder="Search clients…" 
                                class="px-3 py-1 rounded border border-gray-300 focus:outline-none focus:ring focus:border-blue-400 text-sm">
                            <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                Search
                            </button>
                        </form>
                    @endif

                <!-- Navigation Links -->
                @if(auth()->user()->role === 'user')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('resources.index') }}" :active="request()->routeIs('resources.index')">
                        {{ __('Resources') }}
                    </x-nav-link>
                    <x-nav-link :href="route('journal.index')" :active="request()->is('journal') || request()->is('journal/archived')">
                        {{ __('Journal') }}
                    </x-nav-link>
                    <x-nav-link :href="route('quotes.index')" :active="request()->routeIs('quotes.index')">
                        {{ __('Saved Quotes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.index')">
                        {{ __('Chat') }}
                    </x-nav-link>
                @endif
            </div>

            <!-- Right side: Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role === 'user')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('journal.index')" :active="request()->is('journal') || request()->is('journal/archived')">
                    {{ __('Journal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('quotes.index')" :active="request()->routeIs('quotes.index')">
                    {{ __('Saved Quotes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.index')">
                    {{ __('Chat') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        
    </div>
</nav>
