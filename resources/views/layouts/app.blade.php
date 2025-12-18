<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        if (localStorage.getItem('dark') === 'true' || (!('dark' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900"
      x-data="{
          toastMessage: '',
          showToast: false,
          toastType: 'info',
          toastFired: false, {{-- Logical guard to prevent double-firing --}}
          
          initToast() {
              {{-- 1. Capture the session message --}}
              const msg = '{{ session('status') }}';
              
              {{-- 2. GUARD: Only fire if msg exists AND we havent fired it yet --}}
              if (msg && msg.length > 0 && !this.toastFired) {
                  this.toastFired = true; {{-- Lock the guard immediately --}}
                  this.toastMessage = msg;
                  this.showToast = true;
                  
                  {{-- 3. Determine Type --}}
                  const lowerMsg = msg.toLowerCase();
                  if (lowerMsg.includes('error') || lowerMsg.includes('failed')) {
                      this.toastType = 'error';
                  } else if (lowerMsg.includes('only pin') || lowerMsg.includes('unpin') || lowerMsg.includes('limit')) {
                      this.toastType = 'warning';
                  } else if (lowerMsg.includes('saved') || lowerMsg.includes('successfully') || lowerMsg.includes('updated')) {
                      this.toastType = 'success';
                  } else {
                      this.toastType = 'info';
                  }

                  {{-- 4. Auto-hide and Reset --}}
                  setTimeout(() => { 
                      this.showToast = false;
                      this.toastMessage = '';
                  }, 3000);
              }
          }
      }"
      x-init="initToast()">

    <div class="min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    <template x-if="showToast">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 transform -translate-y-2 scale-95"
             :class="{
                'border-green-500 bg-white dark:bg-gray-800 text-green-700 dark:text-green-400': toastType === 'success',
                'border-yellow-500 bg-white dark:bg-gray-800 text-yellow-700 dark:text-yellow-400': toastType === 'warning',
                'border-red-500 bg-white dark:bg-gray-800 text-red-700 dark:text-red-400': toastType === 'error',
                'border-blue-500 bg-white dark:bg-gray-800 text-blue-700 dark:text-blue-400': toastType === 'info'
             }"
             class="fixed top-6 left-1/2 transform -translate-x-1/2 px-5 py-3 rounded-2xl border-2 shadow-2xl flex items-center gap-3 z-[100] min-w-[320px] justify-between">
            
            <div class="flex items-center gap-3">
                <template x-if="toastType === 'success'"><span class="text-xl">✅</span></template>
                <template x-if="toastType === 'warning'"><span class="text-xl">⚠️</span></template>
                <template x-if="toastType === 'error'"><span class="text-xl">❌</span></template>
                <template x-if="toastType === 'info'"><span class="text-xl">ℹ️</span></template>
                
                <span class="text-sm font-black uppercase tracking-tight" x-text="toastMessage"></span>
            </div>
            
            <button @click="showToast = false" class="ml-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>

    @if(session('welcome_modal'))
        <div x-data="{ show: true }" x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-[110]">
            <div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white rounded-3xl shadow-2xl p-8 max-w-md w-full text-center border border-gray-100 dark:border-gray-800">
                <div class="text-5xl mb-4">🎉</div>
                <h2 class="text-2xl font-black mb-3 uppercase tracking-tight">Welcome to CTRL + Mind</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">
                    This is your safe space to reflect, save inspiration, and track your growth.
                </p>
                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-2xl p-4 mb-6 border border-blue-100 dark:border-blue-800">
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400 mb-1">Assigned Consultant</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Dr. {{ session('welcome_modal')['consultant'] }}</p>
                    <p class="text-[10px] mt-1 text-blue-500">Available for support 24/7 💬</p>
                </div>
                <button @click="show = false" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                    Let's Get Started
                </button>
            </div>
        </div>
    @endif

</body>
</html>