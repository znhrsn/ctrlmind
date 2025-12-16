<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Daily Check-In') }}</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">{{ now()->format('F Y') }}</h3>
                <a href="{{ route('checkin.start') }}" class="text-sm text-gray-500">Back</a>
            </div>
        </div>

        <div class="bg-white border rounded shadow-sm p-4">
            {{-- Weekday headers --}}
            <div class="grid grid-cols-7 text-center font-semibold text-sm pb-2 border-b">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>

            {{-- Calendar grid (simple current month) --}}
            <div class="grid grid-cols-7 gap-1 mt-2">
                @php
                    $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                    $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
                    $startDay = $startOfMonth->startOfWeek();
                    $endDay = $endOfMonth->endOfWeek();
                    $date = $startDay->copy();
                @endphp

                @while($date->lte($endDay))
                    @php
                        $isCurrentMonth = $date->month === now()->month;
                        $key = $date->toDateString();
                        $checkins = $checkinsByDate[$key] ?? null;
                        $badge = null;
                        if ($checkins && $checkins->first()) {
                            $m = $checkins->first()->mood;
                            $badge = $m;
                        }
                    @endphp

                    <div class="h-28 p-2 border rounded bg-{{ $isCurrentMonth ? 'white' : 'gray-100' }} relative">
                        <div class="text-sm font-medium">{{ $date->day }}</div>

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

                        {{-- Hidden form modal trigger --}}
                        <div class="absolute inset-0 flex items-end justify-center pb-2">
                            <button @click="$dispatch('open-checkin', { date: '{{ $date->toDateString() }}' })" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Open</button>
                        </div>

                    </div>

                    @php $date->addDay(); @endphp
                @endwhile
            </div>
        </div>

        {{-- Modal: Check-in form (Alpine driven) --}}
        <div x-data="{open:false,date:null,period:'evening',mood:3,energy:3,focus:3,satisfaction:3,self_kindness:3,relaxation:3,note:'',detectPeriod:function(){let h=(new Date()).getHours();if(h>=5 && h<12) return 'morning'; if(h>=12 && h<17) return 'afternoon'; return 'evening';}}" @open-checkin.window="date = $event.detail.date; period = detectPeriod(); open = true">
            <template x-if="open">
                <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white rounded shadow-lg w-full max-w-2xl p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-semibold">Daily Check-In — <span x-text="date"></span> <span class="text-sm text-gray-500" x-text="'(' + period + ')'" /></h4>
                            <button @click="open=false" class="text-gray-500">Close</button>
                        </div>

                        <form method="POST" action="{{ route('checkin.store') }}">
                            @csrf
                            <input type="hidden" name="date" :value="date">

                            {{-- Period: auto-detected unless editing a past date --}}
                            <div class="mb-4">
                                <template x-if="(new Date(date)).toDateString() !== (new Date()).toDateString()">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Period (override for past date)</label>
                                        <select name="period" x-model="period" class="border rounded p-2 w-40">
                                            <option value="morning">Morning</option>
                                            <option value="afternoon">Afternoon</option>
                                            <option value="evening">Evening</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">You are editing a past date; choose the appropriate period.</p>
                                    </div>
                                </template>

                                <template x-if="(new Date(date)).toDateString() === (new Date()).toDateString()">
                                    <input type="hidden" name="period" :value="period">
                                    <span class="text-sm text-gray-700">Period: <strong x-text="period"></strong></span>
                                    <p class="text-xs text-gray-500">(Automatically detected based on current time)</p>
                                </template>
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
                            <div x-show="period=='morning'" class="mb-4 bg-gray-50 p-4 rounded">
                                <h5 class="font-semibold mb-2">🌞 Morning Check-In</h5>
                                <div class="mb-3">
                                    <label class="block text-sm mb-1">Energy <span class="text-xs text-gray-500">(<span x-text="energy"></span>)</span></label>
                                    <input type="range" min="1" max="5" x-model.number="energy" name="energy" class="w-full">
                                    <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Exhausted</span><span>3 Neutral</span><span>5 Energized</span></div>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm mb-1">Focus <span class="text-xs text-gray-500">(<span x-text="focus"></span>)</span></label>
                                    <input type="range" min="1" max="5" x-model.number="focus" name="focus" class="w-full">
                                    <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Scattered</span><span>3 Average</span><span>5 Sharp</span></div>
                                </div>
                            </div>

                            {{-- Afternoon survey (simple) --}}
                            <div x-show="period=='afternoon'" class="mb-4 bg-gray-50 p-4 rounded">
                                <h5 class="font-semibold mb-2">🌤 Afternoon Check-In</h5>
                                <p class="text-sm text-gray-500 mb-2">Quick mood check and short note.</p>
                            </div>

                            {{-- Evening survey (default wellness) --}}
                            <div x-show="period=='evening'" class="mb-4 bg-gray-50 p-4 rounded">
                                <h5 class="font-semibold mb-2">🌙 Evening Reflection</h5>
                                <div class="mb-3">
                                    <label class="block text-sm mb-1">Satisfaction with the Day <span class="text-xs text-gray-500">(<span x-text="satisfaction"></span>)</span></label>
                                    <input type="range" min="1" max="5" x-model.number="satisfaction" name="satisfaction" class="w-full">
                                    <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Unsatisfied</span><span>3 Neutral</span><span>5 Fulfilled</span></div>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm mb-1">Self-Kindness <span class="text-xs text-gray-500">(<span x-text="self_kindness"></span>)</span></label>
                                    <input type="range" min="1" max="5" x-model.number="self_kindness" name="self_kindness" class="w-full">
                                    <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Very Critical</span><span>3 Neutral</span><span>5 Very Compassionate</span></div>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Relaxation <span class="text-xs text-gray-500">(<span x-text="relaxation"></span>)</span></label>
                                    <input type="range" min="1" max="5" x-model.number="relaxation" name="relaxation" class="w-full">
                                    <div class="text-xs text-gray-500 flex justify-between mt-1"><span>1 Tense</span><span>3 Neutral</span><span>5 Peaceful</span></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm mb-1">Note (optional)</label>
                                <textarea name="note" x-model="note" class="w-full border rounded p-2" rows="3"></textarea>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" @click="open=false" class="px-4 py-2 border rounded">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Check-In</button>
                            </div>

                        </form>
                    </div>
                </div>
            </template>
        </div>

    </div>
</x-app-layout>
