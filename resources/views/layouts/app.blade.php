<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900"
      x-data="{
          toastMessage: '{{ session('status') }}',
          showToast: {{ session('status') ? 'true' : 'false' }},
          toastType: (() => {
              const msg = '{{ session('status') }}'.toLowerCase();
              if (msg.includes('error') || msg.includes('failed')) return 'error';
              if (msg.includes('only pin') || msg.includes('unpin') || msg.includes('limit')) return 'warning';
              if (msg.includes('saved') || msg.includes('successfully') || msg.includes('updated')) return 'success';
              return 'info';
          })()
      }"
      x-init="if(showToast){ setTimeout(() => showToast = false, 3000) }">

    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Toast Notification -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         :class="{
            'border-green-600 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300': toastType === 'success',
            'border-yellow-500 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300': toastType === 'warning',
            'border-red-600 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300': toastType === 'error',
            'border-blue-600 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300': toastType === 'info'
         }"
         class="fixed top-6 left-1/2 transform -translate-x-1/2 
                px-4 py-3 rounded-lg shadow-lg flex items-center gap-3 text-center z-50">
        <template x-if="toastType === 'success'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </template>
        <template x-if="toastType === 'warning'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14a7 7 0 000-14z" />
            </svg>
        </template>
        <template x-if="toastType === 'error'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </template>
        <template x-if="toastType === 'info'">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20a10 10 0 000-20z" />
            </svg>
        </template>
        <span class="text-sm font-medium" x-text="toastMessage"></span>
    </div>

    <!-- Welcome Modal -->
    @if(session('welcome_modal'))
        <div x-data="{ show: true }" x-show="show"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white rounded-lg shadow-lg p-6 max-w-md w-full text-center">
                <h2 class="text-2xl font-bold mb-3">
                    Welcome to CTRL + Mind 🎉
                </h2>
                <p class="text-sm mb-4">
                    CTRL + Mind is your space to write thoughts, save quotes, track your mood, explore the resource library, and chat with consultants.
                </p>
                <div class="mt-4 border-t border-gray-300 dark:border-gray-700 pt-4">
                    <p class="text-sm mb-2">
                        Your consultant is 
                        <span class="font-semibold text-blue-500">
                            {{ session('welcome_modal')['consultant'] }}
                        </span>.
                    </p>
                    <p class="text-sm italic text-gray-500 mb-4">
                        You can chat with them anytime for support 💬
                    </p>
                    <button @click="show = false" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                        Got it
                    </button>
                </div>
            </div>
        </div>
    @endif

</body>
</html>
