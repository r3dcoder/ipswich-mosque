@extends('layouts.dashboard')
@section('title','Edit Slide')
@section('header','Edit Carousel Slide')

@section('content')
<div class="bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.carousel-slides.update', $slide) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        @include('admin.carousel-slides._form', ['slide' => $slide])
        <div class="flex gap-2 pt-2">
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Update</button>
            <a href="{{ route('admin.carousel-slides.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
