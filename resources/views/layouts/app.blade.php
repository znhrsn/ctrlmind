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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
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

        @if(session('status'))
            <div id="status-message" 
                class="fixed top-6 left-1/2 transform -translate-x-1/2 
                        px-4 py-3 rounded-lg border border-green-600 
                        bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 
                        shadow-lg flex items-center gap-3 text-center z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">
                    {{ session('status') }}
                </span>
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('status-message');
                    if (msg) {
                        msg.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                        msg.style.opacity = "0";
                        msg.style.transform = "translate(-50%, -20px)";
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif

        <div id="toast-overlay" 
        class="fixed top-6 left-1/2 transform -translate-x-1/2 
                px-4 py-3 rounded-lg border border-green-600 
                bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 
                shadow-lg flex items-center gap-3 text-center z-50 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span id="toast-message" class="text-sm font-medium"></span>
    </div>

    <script>
        function showToast(message) {
            const toast = document.getElementById('toast-overlay');
            const text = document.getElementById('toast-message');
            text.textContent = message;
            toast.classList.remove('hidden');
            toast.style.opacity = "1";
            toast.style.transform = "translate(-50%, 0)";

            setTimeout(() => {
                toast.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                toast.style.opacity = "0";
                toast.style.transform = "translate(-50%, -20px)";
                setTimeout(() => toast.classList.add('hidden'), 500);
            }, 3000);
        }
    </script>

    <body x-data="{ toastMessage: '', showToast: false }">

    <div x-show="showToast" x-transition 
        class="fixed top-6 left-1/2 transform -translate-x-1/2 
                px-4 py-3 rounded-lg border border-green-600 
                bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 
                shadow-lg flex items-center gap-3 text-center z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-sm font-medium" x-text="toastMessage"></span>
    </div>

    </body>
</html>
