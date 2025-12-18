<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Resource Library</h2>
    </x-slot>

    <div class="py-7">
        <div class="max-w-5xl mx-auto space-y-6">

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">
                    Mental Wellness Resources
                </h3>

                <div class="space-y-10">

                    <div>
                        <img src="{{ asset('images/educorner.png') }}" 
                             alt="Educational Corner" 
                             class="mx-auto rounded-lg shadow-md mb-6">

                        <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Educational Corner
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($educational as $resource)
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <h5 class="text-gray-900 dark:text-white font-bold mb-1">{{ $resource->title }}</h5>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $resource->description }}</p>

                                    <a href="{{ $resource->url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-blue-600 dark:text-indigo-400 font-bold hover:underline inline-flex items-center">
                                        View Resource <span class="ml-1">→</span>
                                    </a>
                                </div>
                            @endforeach

                            @if($educational->count() === 0)
                                <p class="text-gray-500 dark:text-gray-400">No resources available in this section.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Coping & Self-Care Strategies
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($coping as $resource)
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <h5 class="text-gray-900 dark:text-white font-bold mb-1">{{ $resource->title }}</h5>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $resource->description }}</p>

                                    <a href="{{ $resource->url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-blue-600 dark:text-indigo-400 font-bold hover:underline inline-flex items-center">
                                        View Resource <span class="ml-1">→</span>
                                    </a>
                                </div>
                            @endforeach

                            @if($coping->count() === 0)
                                <p class="text-gray-500 dark:text-gray-400">No resources available in this section.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">
                            Getting Help: Support & Referral
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($help as $resource)
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <h5 class="text-gray-900 dark:text-white font-bold mb-1">{{ $resource->title }}</h5>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">{{ $resource->description }}</p>

                                    <a href="{{ $resource->url }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-blue-600 dark:text-indigo-400 font-bold hover:underline inline-flex items-center">
                                        View Resource <span class="ml-1">→</span>
                                    </a>
                                </div>
                            @endforeach

                            @if($help->count() === 0)
                                <p class="text-gray-500 dark:text-gray-400">No resources available in this section.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-8">
                © 2025 CTRL+Mind EVSU
            </footer>
        </div>
    </div>
</x-app-layout>