<x-app-layout>
    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
        [x-cloak] { display: none !important; }
        
        /* Hashed pattern for missed entries */
        .bg-missed {
            background-color: #f9fafb;
            background-image: repeating-linear-gradient(45deg, #f3f4f6, #f3f4f6 10px, #f9fafb 10px, #f9fafb 20px);
        }

        /* Custom range sliders */
        input[type=range] { @apply h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer; }
        input[type=range]::-webkit-slider-thumb { @apply w-4 h-4 bg-blue-600 rounded-full appearance-none shadow-md; }
    </style>

    <div class="p-6" x-data="{ selectedDate: null }">
        <div class="bg-white border rounded shadow-sm p-6 max-w-5xl mx-auto">
            @php
                $displayDate = \Carbon\Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, 1);
                $prev = $displayDate->copy()->subMonth();
                $next = $displayDate->copy()->addMonth();
                $checkinsByDate = $checkinsByDate ?? [];
                
                $today = \Carbon\Carbon::today();
                $isMorningTime = now()->hour < 12;

                $emojiMap = [1=>'😢', 2=>'🙁', 3=>'😐', 4=>'🙂', 5=>'😊'];
                $checkinsJson = collect($checkinsByDate)->map(fn($col) => collect($col)->values()->toArray())->all();
            @endphp

            <script>window.CHECKINS = {!! json_encode($checkinsJson) !!};</script>

            {{-- Legend --}}
            <div class="flex justify-center gap-6 mb-8 text-xs font-bold uppercase tracking-widest text-gray-500">
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-yellow-200 rounded-sm"></span> Morning</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-blue-200 rounded-sm"></span> Evening</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-missed border border-gray-200 rounded-sm"></span> Missed</div>
                <div class="flex items-center gap-2"><span>🔒</span> Locked History</div>
            </div>

            {{-- Header --}}
            <div class="mb-6 text-center flex items-center justify-center gap-8">
                <a href="{{ route('checkin.index', ['month' => $prev->month, 'year' => $prev->year]) }}" class="text-3xl text-gray-400 hover:text-gray-900 transition-colors">‹</a>
                <div class="flex flex-col">
                    <h3 class="text-3xl font-black text-gray-900 tracking-tight">{{ $displayDate->format('F Y') }}</h3>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mt-1">Hover over entries to see scales</p>
                </div>
                <a href="{{ route('checkin.index', ['month' => $next->month, 'year' => $next->year]) }}" class="text-3xl text-gray-400 hover:text-gray-900 transition-colors">›</a>
            </div>

            {{-- Calendar Grid --}}
            <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                @php
                    $startOfMonth = $displayDate->copy()->startOfMonth()->startOfWeek();
                    $endOfMonth = $displayDate->copy()->endOfMonth()->endOfWeek();
                    $date = $startOfMonth->copy();
                @endphp

                @while($date->lte($endOfMonth))
                    @php
                        $key = $date->toDateString();
                        $isToday = $date->isToday();
                        $isFuture = $date->isFuture();
                        
                        $dayCheckins = collect($checkinsByDate[$key] ?? []);
                        $morning = $dayCheckins->firstWhere('period', 'Morning');
                        $evening = $dayCheckins->firstWhere('period', 'Evening');

                        $canEditMorning = $isToday && $isMorningTime && !$morning;
                        $canEditEvening = $isToday && !$evening;
                        
                        $missedMorning = !$isFuture && !$morning && (!$isToday || ($isToday && !$isMorningTime));
                        $missedEvening = !$isFuture && !$evening && !$isToday;
                    @endphp

                    <div class="h-32 bg-white relative {{ $date->month !== $displayDate->month ? 'opacity-30' : '' }}">
                        <span class="absolute top-2 left-2 z-30 text-xs font-black {{ $isToday ? 'text-blue-600' : 'text-gray-400' }}">{{ $date->day }}</span>

                        <div class="flex h-full w-full">
                            {{-- Morning Section --}}
                            <div @if($canEditMorning) @click="$dispatch('open-checkin', { date: '{{ $key }}', period: 'Morning' })" @endif
                                 class="flex-1 flex flex-col items-center justify-center border-r border-gray-100 relative group/m transition-all
                                 {{ $morning ? 'bg-yellow-200 cursor-default' : ($canEditMorning ? 'hover:bg-yellow-50 cursor-pointer' : ($missedMorning ? 'bg-missed' : 'bg-gray-50')) }}">
                                
                                @if($morning)
                                    <span class="text-3xl animate-bounce-slow z-10">{{ $emojiMap[$morning['mood']] }}</span>
                                    
                                    <div class="absolute bottom-[80%] left-1/2 -translate-x-1/2 mb-3 hidden group-hover/m:block w-40 bg-gray-900 text-white rounded-xl p-3 shadow-2xl z-50 border border-gray-700 pointer-events-none">
                                        <div class="text-[9px] font-black uppercase tracking-widest text-yellow-400 mb-2 border-b border-gray-700 pb-1">Morning Scales</div>
                                        <div class="space-y-1.5">
                                            <div class="flex justify-between items-center">
                                                <span class="text-[8px] text-gray-400 uppercase">Energy</span>
                                                <span class="text-xs font-bold">{{ $morning['energy'] ?? '-' }}/5</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-[8px] text-gray-400 uppercase">Focus</span>
                                                <span class="text-xs font-bold">{{ $morning['focus'] ?? '-' }}/5</span>
                                            </div>
                                        </div>
                                        @if(!empty($morning['note']))
                                            <div class="mt-2 pt-2 border-t border-gray-800 text-[9px] italic text-gray-300 leading-tight">
                                                "{{ Str::limit($morning['note'], 40) }}"
                                            </div>
                                        @endif
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900"></div>
                                    </div>
                                @elseif($missedMorning)
                                    <span class="text-[9px] font-black uppercase tracking-tighter text-gray-400">Missed</span>
                                @endif
                            </div>

                            {{-- Evening Section --}}
                            <div @if($canEditEvening) @click="$dispatch('open-checkin', { date: '{{ $key }}', period: 'Evening' })" @endif
                                 class="flex-1 flex flex-col items-center justify-center relative group/e transition-all
                                 {{ $evening ? 'bg-blue-200 cursor-default' : ($canEditEvening ? 'hover:bg-blue-50 cursor-pointer' : ($missedEvening ? 'bg-missed' : 'bg-gray-50')) }}">
                                
                                @if($evening)
                                    <span class="text-3xl animate-bounce-slow z-10" style="animation-delay: 0.5s">{{ $emojiMap[$evening['mood']] }}</span>
                                    
                                    <div class="absolute bottom-[80%] left-1/2 -translate-x-1/2 mb-3 hidden group-hover/e:block w-44 bg-gray-900 text-white rounded-xl p-3 shadow-2xl z-50 border border-gray-700 pointer-events-none">
                                        <div class="text-[9px] font-black uppercase tracking-widest text-blue-400 mb-2 border-b border-gray-700 pb-1">Evening Scales</div>
                                        <div class="space-y-1.5">
                                            <div class="flex justify-between items-center">
                                                <span class="text-[8px] text-gray-400 uppercase">Satisfaction</span>
                                                <span class="text-xs font-bold">{{ $evening['satisfaction'] ?? '-' }}/5</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-[8px] text-gray-400 uppercase">Self-Kindness</span>
                                                <span class="text-xs font-bold">{{ $evening['self_kindness'] ?? '-' }}/5</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-[8px] text-gray-400 uppercase">Relaxation</span>
                                                <span class="text-xs font-bold">{{ $evening['relaxation'] ?? '-' }}/5</span>
                                            </div>
                                        </div>
                                        @if(!empty($evening['note']))
                                            <div class="mt-2 pt-2 border-t border-gray-800 text-[9px] italic text-gray-300 leading-tight">
                                                "{{ Str::limit($evening['note'], 40) }}"
                                            </div>
                                        @endif
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-gray-900"></div>
                                    </div>
                                @elseif($missedEvening)
                                    <span class="text-[9px] font-black uppercase tracking-tighter text-gray-400">Missed</span>
                                @endif
                            </div>
                        </div>

                        @if(!$isToday && !$isFuture) 
                            <div class="absolute top-1 right-1 opacity-20 text-[10px]">🔒</div> 
                        @endif
                    </div>
                    @php $date->addDay(); @endphp
                @endwhile
            </div>
        </div>

        {{-- MODAL WITH SURVEYS --}}
        <div x-data="{
                open: false, date: null, period: 'Morning',
                mood: 3, energy: 3, focus: 3, satisfaction: 3, self_kindness: 3, relaxation: 3, 
                note: '', existingId: null
            }"
            @open-checkin.window="
                date = $event.detail.date;
                period = $event.detail.period;
                existingId = null; note = ''; mood = 3; energy = 3; focus = 3; satisfaction = 3; self_kindness = 3; relaxation = 3;
                let dayEntries = (window.CHECKINS && window.CHECKINS[date]) ? window.CHECKINS[date] : [];
                let found = dayEntries.find(c => c.period === period);
                if(found) {
                    existingId = found.id; mood = found.mood; energy = found.energy || 3; focus = found.focus || 3;
                    satisfaction = found.satisfaction || 3; self_kindness = found.self_kindness || 3;
                    relaxation = found.relaxation || 3; note = found.note || '';
                }
                open = true;
            "
            x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"></div>
            
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 overflow-hidden">
                <form method="POST" action="{{ route('checkin.store') }}" class="p-8">
                    @csrf
                    <input type="hidden" name="date" :value="date">
                    <input type="hidden" name="period" :value="period">
                    
                    <div class="mb-6">
                        <h4 class="text-2xl font-black text-gray-900" x-text="period + ' Check-In'"></h4>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest" x-text="date"></p>
                    </div>

                    {{-- Mood Picker --}}
                    <div class="flex justify-between mb-8 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <template x-for="(emoji, val) in {1:'😢', 2:'🙁', 3:'😐', 4:'🙂', 5:'😊'}">
                            <button type="button" @click="mood = val" 
                                    :class="mood == val ? 'scale-125 transition-transform grayscale-0' : 'grayscale opacity-30 hover:opacity-100'"
                                    class="text-4xl transition-all" x-text="emoji"></button>
                        </template>
                        <input type="hidden" name="mood" :value="mood">
                    </div>

                    {{-- MORNING SURVEY --}}
                    <div x-show="period == 'Morning'" class="space-y-6 mb-6">
                        <div class="bg-yellow-50/50 p-4 rounded-2xl border border-yellow-100">
                            <label class="flex justify-between text-[10px] font-black uppercase text-yellow-700 mb-2 tracking-widest">Energy Level <span x-text="energy" class="text-sm"></span></label>
                            <input type="range" min="1" max="5" x-model="energy" name="energy" class="w-full">
                        </div>
                        <div class="bg-yellow-50/50 p-4 rounded-2xl border border-yellow-100">
                            <label class="flex justify-between text-[10px] font-black uppercase text-yellow-700 mb-2 tracking-widest">Focus Level <span x-text="focus" class="text-sm"></span></label>
                            <input type="range" min="1" max="5" x-model="focus" name="focus" class="w-full">
                        </div>
                    </div>

                    {{-- EVENING SURVEY --}}
                    <div x-show="period == 'Evening'" class="space-y-4 mb-6">
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                            <label class="flex justify-between text-[10px] font-black uppercase text-blue-700 mb-2 tracking-widest">Satisfaction <span x-text="satisfaction" class="text-sm"></span></label>
                            <input type="range" min="1" max="5" x-model="satisfaction" name="satisfaction" class="w-full">
                        </div>
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                            <label class="flex justify-between text-[10px] font-black uppercase text-blue-700 mb-2 tracking-widest">Self-Kindness <span x-text="self_kindness" class="text-sm"></span></label>
                            <input type="range" min="1" max="5" x-model="self_kindness" name="self_kindness" class="w-full">
                        </div>
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                            <label class="flex justify-between text-[10px] font-black uppercase text-blue-700 mb-2 tracking-widest">Relaxation <span x-text="relaxation" class="text-sm"></span></label>
                            <input type="range" min="1" max="5" x-model="relaxation" name="relaxation" class="w-full">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Notes</label>
                        <textarea name="note" x-model="note" class="w-full border-gray-100 bg-gray-50 rounded-2xl p-4 focus:ring-2 focus:ring-blue-100 transition-shadow" rows="3" placeholder="How's it going?"></textarea>
                    </div>
                    
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all">
                            Save Entry
                        </button>
                        
                        <button type="button" @click="open = false" class="w-full text-gray-400 py-2 rounded-2xl font-bold uppercase tracking-widest text-[10px] hover:text-gray-600 transition-colors">
                            Maybe Later
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>