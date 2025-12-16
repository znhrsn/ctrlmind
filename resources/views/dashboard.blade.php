<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('CTRL+Mind: Mental Wellness Support System') }}
        </h2>
    </x-slot>

    <div class="py-7 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Quote of the Day -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-300 border-b border-gray-700 pb-2 mb-4">
                    Quote of the Day
                </h3>

                @if($quote)
                    <div class="p-6 bg-gray-900 text-white rounded-lg">
                        <p class="text-lg italic">“{{ $quote->text }}”</p>
                        @if($quote->author)
                            <p class="text-sm text-gray-400">— {{ $quote->author }}</p>
                        @endif

                        <form method="POST" action="{{ route('quotes.toggle') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            <button type="submit" class="focus:outline-none">
                                @if($savedQuoteIds->contains($quote->id))
                                    <span class="text-red-500 text-2xl">♥</span> {{-- filled heart --}}
                                @else
                                    <span class="text-gray-400 text-2xl">♡</span> {{-- empty heart --}}
                                @endif
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Mood Tracker -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-300 border-b border-gray-700 pb-2 mb-4">
                    Mood Tracker
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- CTA / Quick Check-in -->
                    <div class="col-span-1 md:col-span-1 flex flex-col items-center justify-center p-4 border rounded">
                        <p class="mb-4 text-center text-gray-500 dark:text-gray-300">How are you feeling today?</p>
                        <a href="{{ route('checkin.index', ['open_date' => now()->toDateString()]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Start Today's Check-in</a>
                    </div>

                    <!-- Distribution & Recent (center column) -->
                    <div class="col-span-1 md:col-span-1 p-4 border rounded flex flex-col items-center justify-center">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Mood Distribution (30d)</h4>
                        @php
                            $max = max([$moodCounts->max() ?? 0,1]);
                            $emojiMap = [1=>'😢',2=>'🙁',3=>'😐',4=>'🙂',5=>'😊'];
                        @endphp
                        <div class="space-y-2 mb-4 w-full max-w-xs">
                            @for($m=5;$m>=1;$m--)
                                @php $count = $moodCounts[$m] ?? 0; $pct = round(($count/$max)*100); @endphp
                                <div class="flex items-center gap-2">
                                    <div class="w-6 text-xl text-gray-500 dark:text-gray-300">{{ $emojiMap[$m] }}</div>
                                    <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden">
                                        <div class="bg-blue-500 h-3" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <div class="w-8 text-xs text-gray-500 dark:text-gray-300 text-right">{{ $count }}</div>
                                </div>
                            @endfor
                        </div>

                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Survey Periods</h4>
                        @php
                            $periodMap = ['morning'=>'🌞 Morning','afternoon'=>'🌤 Afternoon','evening'=>'🌙 Evening'];
                            $pmax = max([$periodCounts->max() ?? 0,1]);
                        @endphp
                        <div class="space-y-2 mb-4 w-full max-w-xs">
                            @foreach(['morning','afternoon','evening'] as $p)
                                @php $count = $periodCounts[$p] ?? 0; $pct = round(($count/$pmax)*100); @endphp
                                <div class="flex items-center gap-2">
                                    <div class="w-20 text-xs text-gray-500 dark:text-gray-300">{{ $periodMap[$p] }}</div>
                                    <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded overflow-hidden">
                                        <div class="bg-green-500 h-3" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <div class="w-8 text-xs text-gray-500 dark:text-gray-300 text-right">{{ $count }}</div>
                                </div>
                            @endforeach
                        </div>

                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Recent Check-ins</h5>
                        <div class="space-y-2 text-sm w-full max-w-xs">
                            @foreach($recentCheckins as $c)
                                @php
                                    $emo = [1=>'😢',2=>'🙁',3=>'😐',4=>'🙂',5=>'😊'][$c->mood ?? 3];
                                @endphp
                                <div class="flex items-start gap-3">
                                    <div class="text-2xl">{{ $emo }}</div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::parse($c->date)->format('M j') }} • {{ ucfirst($c->period) }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $c->note ? \Illuminate\Support\Str::limit($c->note, 80) : 'No note' }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Trend (sparkline) -->
                    <div class="col-span-1 md:col-span-1 p-4 border rounded flex items-center justify-center">
                        <div class="w-full">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Mood Trend (last 30 days)</h4>
                            @php
                                $points = '';
                                $width = 220;
                                $height = 48;
                                $n = count($moodTrend ?? []);
                                $step = $n > 1 ? $width / ($n - 1) : $width;
                                $i = 0;
                                foreach($moodTrend as $p){
                                    $x = $i * $step;
                                    if (is_null($p['avg'])) {
                                        $y = $height; // bottom
                                    } else {
                                        $y = $height - (($p['avg'] - 1) / 4) * $height; // map 1..5
                                    }
                                    $points .= round($x,2).",".round($y,2).' ';
                                    $i++;
                                }

                                // compute average mood value for the period (ignoring nulls)
                                $avgMood = collect($moodTrend)->filter(fn($it)=>!is_null($it['avg']))->avg('avg') ?: null;
                            @endphp
                            <div class="flex items-center gap-4">
                                <div>
                                    <svg width="{{ $width }}" height="{{ $height }}" class="block">
                                        <polyline fill="none" stroke="#2563EB" stroke-width="2" points="{{ trim($points) }}" />
                                    </svg>
                                </div>

                                <div>
                                    <div class="text-2xl font-bold">{{ $avgMood ? number_format($avgMood,1) : '-' }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-300">Average mood</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Footer -->
            <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
                © 2025 CTRL+Mind EVSU
            </footer>

        </div>
    </div>
</x-app-layout>
