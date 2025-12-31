@extends('layouts.dashboard')

@section('title', 'Edit Event')
@section('header', 'Edit Event')

@section('content')
<div class="max-w-3xl bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.events.update', $event) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title" value="{{ old('title', $event->title) }}" class="w-full rounded-lg border-gray-300" required>
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Date & Time</label>
                <input type="datetime-local" name="starts_at"
                       value="{{ old('starts_at', optional($event->starts_at)->format('Y-m-d\TH:i')) }}"
                       class="w-full rounded-lg border-gray-300" required>
                @error('starts_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Location (optional)</label>
                <input name="location" value="{{ old('location', $event->location) }}" class="w-full rounded-lg border-gray-300">
                @error('location') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description (optional)</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300">{{ old('description', $event->description) }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Sort Order</label>
                <input type="number" min="1" name="sort_order" value="{{ old('sort_order', $event->sort_order) }}"
                       class="w-full rounded-lg border-gray-300">
                @error('sort_order') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2 mt-6">
                <input id="is_active" type="checkbox" name="is_active" value="1" class="rounded border-gray-300"
                       @checked(old('is_active', $event->is_active))>
                <label for="is_active" class="text-sm">Active</label>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.events.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>
@endsection
