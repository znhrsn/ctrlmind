<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-100">Resource Library</h2>
    </x-slot>

    <div class="py-7">
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- Mental Wellness Resources -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-300 border-b border-gray-700 pb-2 mb-4">
                    Mental Wellness Resources
                </h3>
                <div class="bg-gray-900 text-white rounded-lg shadow p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($featuredResources as $res)
                            <div class="bg-gray-800 rounded-lg p-4 shadow">
                                <h4 class="text-md font-semibold text-white">{{ $res->title }}</h4>
                                <p class="text-sm text-gray-400">{{ $res->description }}</p>
                                <a href="{{ $res->url }}" target="_blank"
                                   class="text-blue-400 hover:text-blue-300 text-sm mt-2 inline-block">View →</a>
                            </div>
                        @empty
                            <p class="text-gray-400">No featured resources yet.</p>
                        @endforelse
                    </div>
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('resources.index') }}" class="text-blue-400 hover:text-blue-300 text-sm">
                            Browse all resources →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
