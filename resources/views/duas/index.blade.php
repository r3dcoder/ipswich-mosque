@extends('main-layout')

@section('title', 'Important Duas')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-b from-amber-50 to-white py-12">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-[#0a5134] mb-3">🌙 Important Duas</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Explore beautiful daily Duas with Arabic text, pronunciation, and translation to enrich your spiritual journey.
            </p>
        </div>
        {{-- Category Buttons --}}
    <div class="flex flex-wrap gap-3 mb-8">
        @foreach ($categories as $cat)
            <a href="{{ route('duas.category', $cat->id) }}"
               class="px-4 py-2 rounded-full text-sm font-semibold border transition-all duration-300 
               {{ isset($selectedCategory) && $selectedCategory->id === $cat->id
                   ? 'bg-[#0a5134] text-white border-[#0a5134]'
                   : 'bg-white text-[#0a5134] border-[#0a5134] hover:bg-[#0a5134] hover:text-white' }}">
               {{ $cat->name }}
            </a>
        @endforeach
    </div>

        @foreach ($categories as $category)
            <div class="mb-12">
                <!-- Category Header -->
                <div class="flex items-center mb-6">
                    <div class="h-1 w-8 bg-[#0a5134] rounded-full mr-3"></div>
                    <h2 class="text-2xl font-semibold text-[#0a5134]">{{ $category->name }}</h2>
                </div>

                <!-- Dua Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($category->duas as $dua)
                        <a href="{{ route('duas.show', $dua->id) }}"
                           class="group bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300 border border-gray-100 hover:border-amber-400">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-lg text-gray-900 group-hover:text-amber-600">{{ $dua->title }}</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400 opacity-70 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <p class="text-amber-800 text-lg font-arabic mb-2 leading-relaxed text-right">{{ Str::limit($dua->arabic, 60) }}</p>
                            <p class="text-gray-500 italic text-sm mb-2">{{ Str::limit($dua->pronunciation, 80) }}</p>
                            <p class="text-gray-600 line-clamp-2 text-sm">{{ Str::limit($dua->translation, 90) }}</p>
                        </a>
                    @empty
                        <p class="text-gray-500 text-sm">No Duas found in this category.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
