<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Daily Check-In') }}</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="mb-6 flex justify-end">
            <a href="{{ route('checkin.start') }}" class="text-sm text-gray-500">Back</a>
        </div>

        <div class="bg-white border rounded shadow-sm p-4 max-w-xl mx-auto">
            {{-- Month / Year (centered and high contrast) --}}
            @php
                $displayDate = \Carbon\Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, 1);
                $prev = $displayDate->copy()->subMonth();
                $next = $displayDate->copy()->addMonth();
            @endphp
            <div class="mb-4 text-center flex items-center justify-center gap-4">
                <a href="{{ route('checkin.index', ['month' => $prev->month, 'year' => $prev->year]) }}" class="text-gray-500 hover:text-gray-700" aria-label="Previous month">‹</a>
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-200" id="calendarMonth">{{ $displayDate->format('F Y') }}</h3>
                <a href="{{ route('checkin.index', ['month' => $next->month, 'year' => $next->year]) }}" class="text-gray-500 hover:text-gray-700" aria-label="Next month">›</a>
            </div>

            {{-- Weekday headers --}}
            <div class="grid grid-cols-7 text-center font-semibold text-xs pb-2 border-b">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>

            @php
                // Prepare a JSON map of check-ins by date for client-side prefill and delete actions
                $checkinsJson = collect($checkinsByDate)->map(function($col) {
                    return collect($col)->map(function($c){ return $c->toArray(); })->values()->all();
                })->all();
                $today = \Carbon\Carbon::today()->toDateString();
            @endphp
            <script>
                window.CHECKINS = {!! json_encode($checkinsJson) !!};
                window.TODAY = '{{ $today }}';
            </script>

            @if(!empty($openDate))
                <script>
                    // Only select the date on load (highlight) — do NOT auto-open the survey modal.
                    document.addEventListener('DOMContentLoaded', function () {
                        window.dispatchEvent(new CustomEvent('select-date', { detail: { date: '{{ $openDate }}' } }));
                    });
                </script>
            @endif

            {{-- Calendar grid (simple current month) --}}
            <div x-data="{selectedDate:null}"                 @select-date.window="selectedDate = $event.detail.date"            <div @open-checkin.window="if($event.detail.date === window.TODAY) selectedDate = $event.detail.date" 
                 @close-checkin.window="selectedDate = null"
                 class="grid grid-cols-7 gap-1 mt-2 w-full">
                @php
                    $startOfMonth = $displayDate->copy()->startOfMonth();
                    $endOfMonth = $displayDate->copy()->endOfMonth();
                    $startDay = $startOfMonth->copy()->startOfWeek();
                    $endDay = $endOfMonth->copy()->endOfWeek();
                    $date = $startDay->copy();
                @endphp

                @while($date->lte($endDay))
                    @php
                        $isCurrentMonth = $date->month === $displayDate->month;
                        $key = $date->toDateString();
                        $checkins = $checkinsByDate[$key] ?? null;
                        $badge = null;
                        if ($checkins && $checkins->first()) {
                            $m = $checkins->first()->mood;
                            $badge = $m;
                        }
                    @endphp

                    @php
                        $today = \Carbon\Carbon::today();
                        $isPastCell = $date->lt($today);
                        $isToday = $date->isSameDay($today);
                        $isFuture = $date->gt($today);
                    @endphp

                    <div :class="selectedDate === '{{ $date->toDateString() }}' ? 'ring-2 ring-offset-2 ring-blue-400 bg-blue-50' : '{{ $isPastCell ? 'bg-gray-100 opacity-70 cursor-not-allowed' : ($isToday ? 'bg-white cursor-pointer' : 'bg-gray-50 cursor-not-allowed') }}'"
                         class="h-16 p-2 border rounded relative"
                         @if($isToday) @click="selectedDate='{{ $date->toDateString() }}'; $dispatch('open-checkin', { date: '{{ $date->toDateString() }}' })" role="button" tabindex="0" aria-label="Open check-in for {{ $date->toDateString() }}" @endif
                    >
                        <div class="text-xs font-medium">{{ $date->day }}</div>

                        @php
                            $periods = $checkins ? $checkins->pluck('period')->unique()->values()->all() : [];
                            $periodMap = [
                                'morning' => ['label' => 'M', 'title' => 'Morning', 'color' => 'bg-yellow-100'],
                                'afternoon' => ['label' => 'A', 'title' => 'Afternoon', 'color' => 'bg-orange-100'],
                                'evening' => ['label' => 'E', 'title' => 'Evening', 'color' => 'bg-slate-200'],
                            ];
                        @endphp

                        {{-- Period badges (top-right) --}}
                        @if(count($periods))
                            <div class="absolute top-1 right-1 flex gap-1" role="list">
                                @foreach($periods as $p)
                                    @php $info = $periodMap[$p] ?? ['label' => strtoupper(substr($p, 0, 1)), 'title' => $p, 'color' => 'bg-gray-200']; @endphp
                                    <span role="listitem" title="{{ $info['title'] }}" class="text-xs px-1 py-0.5 rounded {{ $info['color'] }} border">{{ $info['label'] }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if($badge)
                            {{-- simple emoji mapping --}}
                            @php
                                $emojiMap = [1 => '😢',2 => '🙁',3 => '😐',4 => '🙂',5 => '😊'];
                                $colorMap = [1=>'bg-blue-200',2=>'bg-red-200',3=>'bg-gray-200',4=>'bg-amber-200',5=>'bg-yellow-200'];
                            @endphp
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded {{ $colorMap[$badge] ?? 'bg-gray-200' }}">{{ $emojiMap[$badge] ?? '•' }}</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 flex items-end justify-center pb-2"></div>

                    </div>

                    @php $date->addDay(); @endphp
                @endwhile
            </div>
        </div>

        {{-- Modal: Check-in form (Alpine driven) --}}
        <div x-data="{open:false,date:null,period:'evening',mood:3,energy:3,focus:3,satisfaction:3,self_kindness:3,relaxation:3,note:'',existingId:null,detectPeriod:function(){let h=(new Date()).getHours();if(h>=5 && h<12) return 'morning'; if(h>=12 && h<17) return 'afternoon'; return 'evening';}}" @open-checkin.window="(function(){ date = $event.detail.date; period = detectPeriod(); existingId = null; mood=3; energy=3; focus=3; satisfaction=3; self_kindness=3; relaxation=3; note=''; var items = (window.CHECKINS && window.CHECKINS[date]) ? window.CHECKINS[date] : []; var found = items.find(function(c){ return c.period === period; }); if(found){ existingId = found.id; mood = found.mood || 3; energy = found.energy || 3; focus = found.focus || 3; satisfaction = found.satisfaction || 3; self_kindness = found.self_kindness || 3; relaxation = found.relaxation || 3; note = found.note || ''; } open = true; })()" x-effect="document.documentElement.classList.toggle('overflow-hidden', open)">
            <template x-if="open">
                <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white rounded shadow-lg w-full max-w-2xl max-h-[95vh] flex flex-col overflow-hidden">
                        <div class="p-6 flex-shrink-0">
                            <div class="flex justify-between items-center mb-0">
                                <h4 class="text-base font-semibold">Daily Check-In — <span x-text="date"></span> <span class="text-sm text-gray-500" x-text="'(' + period + ')'" /></h4>
                                <button @click="open=false; $dispatch('close-checkin')" class="text-gray-500">Close</button>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('checkin.store') }}" class="flex flex-col flex-1 min-h-0">
                            @csrf
                            <input type="hidden" name="date" :value="date">
                            <input type="hidden" name="period" :value="period">

                            <div class="px-4 py-3 space-y-3 min-h-0 overflow-y-auto max-h-[70vh]">
                                <div class="mb-0">
                                    <span class="text-sm text-gray-700">Period: <strong x-text="period"></strong></span>
                                    <p class="text-xs text-gray-500">(Automatically detected based on current time — check-ins for past dates are not allowed)</p>
                                </div>

                                {{-- Emoji mood picker --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2">Mood</label>
                                    <div class="flex gap-2">
                                        <button type="button" @click="mood=1" :class="{'ring-2 ring-offset-2 ring-blue-400': mood==1}" class="px-3 py-2 rounded bg-blue-100">😢</button>
                                        <button type="button" @click="mood=2" :class="{'ring-2 ring-offset-2 ring-blue-400': mood==2}" class="px-3 py-2 rounded bg-red-100">🙁</button>
                                        <button type="button" @click="mood=3" :class="{'ring-2 ring-offset-2 ring-blue-400': mood==3}" class="px-3 py-2 rounded bg-gray-100">😐</button>
                                        <button type="button" @click="mood=4" :class="{'ring-2 ring-offset-2 ring-blue-400': mood==4}" class="px-3 py-2 rounded bg-amber-100">🙂</button>
                                        <button type="button" @click="mood=5" :class="{'ring-2 ring-offset-2 ring-blue-400': mood==5}" class="px-3 py-2 rounded bg-yellow-100">😊</button>
                                    </div>
                                    <input type="hidden" name="mood" :value="mood">
                                    <p class="text-xs text-gray-500 mt-2">Mood scale: 1 down/negative → 5 very positive</p>
                                </div>

                                {{-- Morning survey --}}
                                <div x-show="period=='morning'" class="mb-2 bg-gray-50 p-3 rounded">
                                    <h5 class="font-semibold mb-2">🌞 Morning Check-In</h5>
                                    <div class="mb-2">
                                        <label class="block text-sm mb-1">Energy <span class="text-xs text-gray-500">(<span x-text="energy"></span>)</span></label>
                                        <input type="range" min="1" max="5" x-model.number="energy" name="energy" class="w-full h-2">
                                        <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Exhausted</span><span>3 Neutral</span><span>5 Energized</span></div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="block text-sm mb-1">Focus <span class="text-xs text-gray-500">(<span x-text="focus"></span>)</span></label>
                                        <input type="range" min="1" max="5" x-model.number="focus" name="focus" class="w-full h-2">
                                        <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Scattered</span><span>3 Average</span><span>5 Sharp</span></div>
                                    </div>
                                </div>

                                {{-- Afternoon survey (simple) --}}
                                <div x-show="period=='afternoon'" class="mb-2 bg-gray-50 p-3 rounded">
                                    <h5 class="font-semibold mb-2">🌤 Afternoon Check-In</h5>
                                    <p class="text-sm text-gray-500 mb-2">Quick mood check and a one-line note (keeps it fast).</p>

                                    <div class="flex gap-2 mb-2">
                                        <button type="button" class="text-xs px-2 py-1 rounded bg-gray-100" @click="note = note ? note + (note.endsWith(' ') ? '' : ' ') + 'Stressed' : 'Stressed'">Stressed</button>
                                        <button type="button" class="text-xs px-2 py-1 rounded bg-gray-100" @click="note = note ? note + (note.endsWith(' ') ? '' : ' ') + 'Productive' : 'Productive'">Productive</button>
                                        <button type="button" class="text-xs px-2 py-1 rounded bg-gray-100" @click="note = note ? note + (note.endsWith(' ') ? '' : ' ') + 'Tired' : 'Tired'">Tired</button>
                                        <button type="button" class="text-xs px-2 py-1 rounded bg-gray-100" @click="note = note ? note + (note.endsWith(' ') ? '' : ' ') + 'Calm' : 'Calm'">Calm</button>
                                    </div>

                                    <div>
                                        <label class="block text-sm mb-1">Short note <span class="text-xs text-gray-500">(<span x-text="(note || '').length"></span>/140)</span></label>
                                        <input type="text" name="note" x-model="note" maxlength="140" class="w-full border rounded p-2 text-sm" placeholder="e.g., 'Back-to-back meetings'" />
                                    </div>
                                </div>

                                {{-- Evening survey (default wellness) --}}
                                <div x-show="period=='evening'" class="mb-2 bg-gray-50 p-3 rounded">
                                    <h5 class="font-semibold mb-2">🌙 Evening Reflection</h5>
                                    <div class="mb-2">
                                        <label class="block text-sm mb-1">Satisfaction with the Day <span class="text-xs text-gray-500">(<span x-text="satisfaction"></span>)</span></label>
                                        <input type="range" min="1" max="5" x-model.number="satisfaction" name="satisfaction" class="w-full h-2">
                                        <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Unsatisfied</span><span>3 Neutral</span><span>5 Fulfilled</span></div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="block text-sm mb-1">Self-Kindness <span class="text-xs text-gray-500">(<span x-text="self_kindness"></span>)</span></label>
                                        <input type="range" min="1" max="5" x-model.number="self_kindness" name="self_kindness" class="w-full h-2">
                                        <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Very Critical</span><span>3 Neutral</span><span>5 Very Compassionate</span></div>
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1">Relaxation <span class="text-xs text-gray-500">(<span x-text="relaxation"></span>)</span></label>
                                        <input type="range" min="1" max="5" x-model.number="relaxation" name="relaxation" class="w-full">
                                        <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Tense</span><span>3 Neutral</span><span>5 Peaceful</span></div>
                                    </div>
                                </div>

                                <div x-show="period != 'afternoon'">
                                    <label class="block text-sm mb-1">Note (optional)</label>
                                    <textarea name="note" x-model="note" class="w-full border rounded p-2" rows="3"></textarea>
                                </div>

                            </div>

                            <div class="px-4 py-3 bg-white border-t flex justify-between items-center gap-2 flex-shrink-0 sticky bottom-0 z-10">
                                <div class="flex items-center gap-2">
                                    <form x-show="existingId" x-bind:action="'/checkin/' + existingId" method="POST" class="mr-2" onsubmit="return confirm('Delete this check-in? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                                    </form>
                                </div>

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="open=false; $dispatch('close-checkin')" class="px-3 py-1 border rounded">Cancel</button>
                                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save Check-In</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </template>
        </div>

    </div>
</x-app-layout>
