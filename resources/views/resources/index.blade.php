<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Resource Library</h2>
    </x-slot>

    <div class="py-7">
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- Mental Wellness Resources Board -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-300 border-b border-gray-700 pb-2 mb-4">
                    Mental Wellness Resources
                </h3>

                <div class="space-y-10">

            <!-- Educational Corner -->
            <div>
            <img src="{{ asset('images/educorner.png') }}" 
                    alt="Educational Corner" 
                    class="mx-auto rounded-lg shadow-md mb-6">

                <h4 class="text-md font-semibold text-gray-200 mb-2">
                    Educational Corner
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($educational as $resource)
                <div class="bg-gray-900 p-4 rounded shadow">
                <h5 class="text-white font-bold">{{ $resource->title }}</h5>
                <p class="text-gray-400 text-sm">{{ $resource->description }}</p>

                <a href="{{ $resource->url }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="text-indigo-600 font-medium hover:underline">
                    View →
                </a>
            </div>
                    @endforeach

                    @if($educational->count() === 0)
                    <p class="text-gray-400">No resources available in this section.</p>
                    @endif
                </div>
            </div>


            <!-- Coping & Self-Care Strategies -->
            <div>
                <h4 class="text-md font-semibold text-gray-200 mb-2">
                    Coping & Self-Care Strategies
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($coping as $resource)
                <div class="bg-gray-900 p-4 rounded shadow">
                <h5 class="text-white font-bold">{{ $resource->title }}</h5>
                <p class="text-gray-400 text-sm">{{ $resource->description }}</p>

                <a href="{{ $resource->url }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="text-indigo-600 font-medium hover:underline">
                    View →
                </a>
            </div>
                    @endforeach

                    @if($coping->count() === 0)
                    <p class="text-gray-400">No resources available in this section.</p>
                    @endif
                </div>
            </div>


            <!-- Getting Help: Support & Referral -->
            <div>
                <h4 class="text-md font-semibold text-gray-200 mb-2">
                    Getting Help: Support & Referral
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($help as $resource)
            <div class="bg-gray-900 p-4 rounded shadow">
                <h5 class="text-white font-bold">{{ $resource->title }}</h5>
                <p class="text-gray-400 text-sm">{{ $resource->description }}</p>

                <a href="{{ $resource->url }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="text-indigo-600 font-medium hover:underline">
                    View →
                </a>
            </div>
                    @endforeach

                    @if($help->count() === 0)
            <p class="text-gray-400">No resources available in this section.</p>
            @endif
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
