@extends('main-layout')

@section('title', 'Important Duas')

@section('header')
    @include('partials.header')
@endsection


@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Duas</h1>

    @foreach ($categories as $category)
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">{{ $category->name }}</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach ($category->duas as $dua)
                    <a href="{{ route('duas.show', $dua->id) }}" class="block p-4 bg-white shadow rounded-lg hover:bg-gray-50">
                        <h3 class="font-bold text-lg">{{ $dua->title }}</h3>
                        <p class="text-gray-600 line-clamp-2">{{ Str::limit($dua->translation, 80) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('footer')
    @include('partials.footer')

@endsection