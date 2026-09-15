@extends('layouts.dashboard')

@section('title', 'Edit Janazah Content')
@section('header', 'Edit Janazah Content')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.janazah-contents.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to content list</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Content Block</h1>
        <p class="text-sm text-gray-500 mt-1">Update this block on the Janazah & Funeral Services page.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.janazah-contents.update', $janazahContent->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.janazah-contents._form', ['content' => $janazahContent, 'submitLabel' => 'Update Content Block'])
        </form>
    </div>
</div>
@endsection