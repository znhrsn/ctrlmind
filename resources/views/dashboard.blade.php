<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CTRL+Mind: Mental Wellness Support System') }}
        </h2>
    </x-slot>

    <div class="py-7 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">Quote of the Day</h3>
                    @if($quote)
                        <form method="POST" action="{{ route('quotes.toggle') }}">
                            @csrf
                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            <button type="submit" class="focus:outline-none transition-transform active:scale-125">
                                @if($savedQuoteIds->contains($quote->id))
                                    <span class="text-red-500 text-xl">♥</span>
                                @else
                                    <span class="text-gray-400 text-xl hover:text-red-400">♡</span>
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
                @if($quote)
                    <div class="relative pl-6">
                        <span class="absolute top-0 left-0 text-3xl text-gray-200 dark:text-gray-700 font-serif">“</span>
                        <p class="text-lg italic text-gray-700 dark:text-gray-200">{{ $quote->text }}</p>
                        @if($quote->author)
                            <p class="text-sm text-gray-500 mt-1">— {{ $quote->author }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-xl rounded-2xl p-6 text-white flex flex-col md:flex-row items-center justify-between gap-6 border border-blue-500/30">
                <div class="flex items-center gap-5">
                    <div class="bg-white/10 p-4 rounded-xl backdrop-blur-md text-3xl shadow-inner">📝</div>
                    <div>
                        <h3 class="text-xl font-bold">Mental Wellness Check-in</h3>
                        <p class="text-blue-100 text-sm opacity-90">Review your past data below. New entries are locked after the day ends.</p>
                    </div>
                </div>
                <a href="{{ route('checkin.index', ['open_date' => now()->toDateString()]) }}"
                   class="w-full md:w-auto px-10 py-4 bg-white text-blue-700 font-extrabold rounded-xl hover:bg-blue-50 transition-all shadow-lg active:scale-95 text-center uppercase tracking-wider text-sm">
                    Start Today's Check-in
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
                
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-700 flex flex-col">
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-6 text-center">Mood Distribution</h3>
                    @php
                        $max = max([$moodCounts->max() ?? 0, 1]);
                        $emojiMap = [1=>'😢', 2=>'🙁', 3=>'😐', 4=>'🙂', 5=>'😊'];
                    @endphp
                    <div class="flex flex-1 items-end justify-between gap-2 px-2 pb-2">
                        @for($m = 1; $m <= 5; $m++)
                            @php $count = $moodCounts[$m] ?? 0; $pct = round(($count / $max) * 100); @endphp
                            <div class="flex flex-col items-center gap-2 w-full group">
                                <span class="text-[10px] font-mono text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity">{{ $count }}</span>
                                <div class="w-full bg-gray-100 dark:bg-gray-700/50 rounded-t-lg flex flex-col justify-end overflow-hidden" style="height: 120px;">
                                    <div class="bg-blue-500 w-full transition-all duration-1000 ease-out" style="height: {{ $pct }}%"></div>
                                </div>
                                <span class="text-xl">{{ $emojiMap[$m] }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-700 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">Scale History</h3>
                        <a href="{{ route('checkin.index') }}" class="text-[10px] text-blue-500 font-bold hover:underline">FULL VIEW</a>
                    </div>

                    <div class="space-y-3 overflow-y-auto pr-1 custom-scrollbar" style="height: 220px;">
                        @forelse($recentCheckins as $c)
                            <div x-data="{ showScales: false }" class="bg-gray-50 dark:bg-gray-900/40 p-3 rounded-xl border border-gray-100 dark:border-gray-700/50 transition-all hover:border-blue-500/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="text-2xl">{{ $emojiMap[$c->mood ?? 3] }}</div>
                                        <div class="overflow-hidden">
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter leading-none">
                                                {{ \Carbon\Carbon::parse($c->date)->format('M j, Y') }}
                                            </div>
                                            <div class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 mt-1 uppercase">
                                                {{ $c->period }} Entry
                                            </div>
                                        </div>
                                    </div>
                                    <button @click="showScales = !showScales" class="text-gray-400 hover:text-blue-500 transition-colors p-2 focus:outline-none">
                                        <svg :class="showScales ? 'rotate-180' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div x-show="showScales" x-cloak x-transition class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <div class="grid grid-cols-2 gap-2">
                                        @if(strtolower($c->period) == 'morning')
                                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                                <span class="block text-[8px] uppercase text-gray-500 font-bold tracking-widest">Energy</span>
                                                <span class="text-sm font-black text-yellow-500">{{ $c->energy ?? '-' }}/5</span>
                                            </div>
                                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                                <span class="block text-[8px] uppercase text-gray-500 font-bold tracking-widest">Focus</span>
                                                <span class="text-sm font-black text-yellow-500">{{ $c->focus ?? '-' }}/5</span>
                                            </div>
                                        @else
                                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                                <span class="block text-[8px] uppercase text-gray-500 font-bold tracking-widest">Satisfaction</span>
                                                <span class="text-sm font-black text-blue-500">{{ $c->satisfaction ?? '-' }}/5</span>
                                            </div>
                                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                                                <span class="block text-[8px] uppercase text-gray-500 font-bold tracking-widest">Self-Kindness</span>
                                                <span class="text-sm font-black text-blue-500">{{ $c->self_kindness ?? '-' }}/5</span>
                                            </div>
                                            <div class="bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-100 dark:border-gray-700 col-span-2">
                                                <span class="block text-[8px] uppercase text-gray-500 font-bold tracking-widest">Relaxation</span>
                                                <span class="text-sm font-black text-blue-500">{{ $c->relaxation ?? '-' }}/5</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if($c->note)
                                        <div class="mt-2 bg-gray-100 dark:bg-gray-800/50 p-2 rounded-lg">
                                            <p class="text-[10px] text-gray-500 italic">"{{ $c->note }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-500 text-center py-6">No history available yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-700 flex flex-col items-center justify-center text-center">
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-6">30-Day Trend</h3>
                    @php
                        $width = 200; $height = 80; $points = '';
                        $n = count($moodTrend ?? []);
                        $step = $n > 1 ? $width / ($n - 1) : $width;
                        $i = 0;
                        foreach ($moodTrend as $p) {
                            $x = $i * $step;
                            $y = is_null($p['avg']) ? $height : $height - (($p['avg'] - 1) / 4) * $height;
                            $points .= round($x, 2) . ',' . round($y, 2) . ' ';
                            $i++;
                        }
                        $avgMood = collect($moodTrend)->filter(fn ($it) => !is_null($it['avg']))->avg('avg');
                    @endphp
                    <div class="w-full flex flex-col items-center">
                        <svg width="100%" height="{{ $height }}" viewBox="0 0 {{ $width }} {{ $height }}" class="overflow-visible mb-6">
                            <polyline fill="none" stroke="#3B82F6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" points="{{ trim($points) }}" />
                        </svg>
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-3 border border-gray-100 dark:border-gray-700/50 w-full max-w-[140px]">
                            <span class="text-3xl font-black text-gray-800 dark:text-white leading-none">
                                {{ $avgMood ? number_format($avgMood, 1) : '-' }}
                            </span>
                            <p class="text-[9px] font-bold text-gray-500 uppercase tracking-tight mt-1">Average Score</p>
                        </div>
                    </div>
                </div>

            </div> <footer class="text-center text-sm text-gray-500 mt-8 opacity-50">
                © 2025 CTRL+Mind EVSU
            </footer>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; }
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>