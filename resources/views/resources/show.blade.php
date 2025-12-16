@extends('layouts.app') {{-- or whatever your main layout is --}}

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:underline">
        ← Back to Resource Library
    </a>

    <h1 class="text-3xl font-semibold mt-4 mb-2">
        {{ $resource->title }}
    </h1>

    <p class="text-sm text-gray-500 mb-6">
        Category: {{ ucfirst($resource->category) }}
    </p>

    <div class="prose max-w-none">
        {!! nl2br(e($resource->content)) !!}
    </div>
</div>
@endsection
