@extends('main-layout')

@section('title', $dua->title)

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container mx-auto px-6 py-10 max-w-5xl">

    <!-- Category Navigation -->
    <div class="flex flex-wrap justify-center gap-3 mb-10">
        @foreach($allCategories as $cat)
            <a href="{{ route('duas.category', $cat->id) }}"
               class="px-4 py-2 rounded-full text-sm font-medium border transition-all duration-200 
               {{ $cat->id === $dua->category?->id 
                   ? 'bg-[#0a5134] text-white border-[#0a5134]' 
                   : 'bg-white text-[#0a5134] border-[#0a5134] hover:bg-[#0a5134] hover:text-white' }}">
               {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Dua Title -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-[#0a5134] mb-2 tracking-wide">
            {{ $dua->title }}
        </h1>
        <p class="text-gray-600 text-sm">
            Category: <span class="text-[#0a5134] font-semibold">{{ $dua->category?->name }}</span>
        </p>
        <div class="w-20 h-1 bg-[#0a5134] mx-auto mt-3 rounded"></div>
    </div>

    <!-- Dua Content -->
    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

        <!-- Arabic -->
        <div class="mb-8 text-center">
            <h2 class="text-xl font-semibold text-[#0a5134] mb-3 uppercase tracking-wider">Arabic</h2>
            <p class="text-3xl font-arabic leading-relaxed text-gray-900">
                {{ $dua->arabic }}
            </p>
        </div>

        <!-- Pronunciation -->
        @if($dua->pronunciation)
        <div class="mb-8 bg-[#f9fdfa] p-4 rounded-lg border-l-4 border-[#0a5134]">
            <h2 class="text-xl font-semibold text-[#0a5134] mb-2">Pronunciation</h2>
            <p class="text-gray-800 italic leading-relaxed">{{ $dua->pronunciation }}</p>
        </div>
        @endif

        <!-- Translation -->
        @if($dua->translation)
        <div class="mb-8 bg-[#f9fdfa] p-4 rounded-lg border-l-4 border-[#0a5134]">
            <h2 class="text-xl font-semibold text-[#0a5134] mb-2">Translation</h2>
            <p class="text-gray-800 leading-relaxed">{{ $dua->translation }}</p>
        </div>
        @endif

        <!-- Explanation -->
        @if($dua->description)
        <div class="bg-[#f9fdfa] p-4 rounded-lg border-l-4 border-[#0a5134]">
            <h2 class="text-xl font-semibold text-[#0a5134] mb-2">Explanation</h2>
            <p class="text-gray-700 leading-relaxed">{{ $dua->description }}</p>
        </div>
        @endif
    </div>

    <!-- Related Duas Section -->
    @if($relatedDuas->count() > 0)
    <div class="mt-14">
        <h2 class="text-2xl font-bold text-[#0a5134] mb-6 border-b pb-2 border-gray-200">Related Duas</h2>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach ($relatedDuas as $related)
                <a href="{{ route('duas.show', $related->id) }}" 
                   class="block bg-white border rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-200 hover:border-[#0a5134]">
                    <h3 class="text-lg font-semibold text-[#0a5134]">{{ $related->title }}</h3>
                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                        {{ Str::limit($related->translation, 80) }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="text-center mt-10">
        <a href="{{ route('duas.index') }}" 
           class="inline-block px-6 py-2 text-white bg-[#0a5134] hover:bg-[#09442b] rounded-md transition-all duration-200">
           ← Back to All Duas
        </a>
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
