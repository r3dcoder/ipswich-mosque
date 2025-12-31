@extends('layouts.dashboard')

@section('title', 'Edit Dua Category')
@section('header', 'Edit Dua Category')

@section('content')
<div class="max-w-2xl bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.dua_categories.update', $duaCategory) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input name="name" value="{{ old('name', $duaCategory->name) }}" class="w-full rounded-lg border-gray-300" required>
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Category (optional)</label>
            <input name="category" value="{{ old('category', $duaCategory->category) }}" class="w-full rounded-lg border-gray-300">
            @error('category') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.dua_categories.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>
@endsection
