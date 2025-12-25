@extends('layouts.dashboard')
@section('title','Add Slide')
@section('header','Add Carousel Slide')

@section('content')
<div class="bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.carousel-slides.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @include('admin.carousel-slides._form')
        <div class="flex gap-2 pt-2">
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Save</button>
            <a href="{{ route('admin.carousel-slides.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
        </div>
    </form>
</div>
@endsection
