@extends('main-layout')

@section('title', $dua->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">{{ $dua->title }}</h1>
    <p class="text-sm text-gray-500 mb-6">Category: {{ $dua->category?->name }}</p>

    <div class="bg-gray-50 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-2">Arabic</h2>
        <p class="text-2xl font-arabic mb-6">{{ $dua->arabic }}</p>

        @if($dua->pronunciation)
        <h2 class="text-xl font-semibold mb-2">Pronunciation</h2>
        <p class="mb-6">{{ $dua->pronunciation }}</p>
        @endif

        @if($dua->translation)
        <h2 class="text-xl font-semibold mb-2">Translation</h2>
        <p class="mb-6">{{ $dua->translation }}</p>
        @endif

        @if($dua->description)
        <h2 class="text-xl font-semibold mb-2">Explanation</h2>
        <p class="mb-6">{{ $dua->description }}</p>
        @endif
    </div>
</div>
@endsection
