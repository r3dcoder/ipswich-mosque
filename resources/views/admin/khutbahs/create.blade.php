@extends('layouts.dashboard')

@section('title', 'Add Khutbah')
@section('header', 'Add New Khutbah')

@section('content')
<div class="max-w-4xl">
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.khutbahs.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white border rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Video Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           placeholder="Enter khutbah title">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL <span class="text-red-500">*</span></label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" required
                           class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           placeholder="https://www.youtube.com/watch?v=...">
                    <p class="text-xs text-gray-500 mt-1">Enter the full YouTube URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Speaker</label>
                    <input type="text" name="speaker" value="{{ old('speaker') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           placeholder="Sheikh name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivered Date</label>
                    <input type="date" name="delivered_date" value="{{ old('delivered_date') }}"
                           class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes)</label>
                    <input type="number" name="duration" value="{{ old('duration') }}" min="1" max="300"
                           class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           placeholder="e.g., 30">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                              placeholder="Brief description of the khutbah...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white border rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Settings</h3>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                    <label for="is_featured" class="ml-2 text-sm text-gray-700">
                        Mark as featured (will appear in the featured section on the public page)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">
                        Active (visible to public)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-24 rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <label class="ml-2 text-sm text-gray-700">
                        Sort order (lower numbers appear first)
                    </label>
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-3 rounded-lg bg-gray-900 text-white font-medium hover:bg-gray-800">
                Add Khutbah
            </button>
            <a href="{{ route('admin.khutbahs.index') }}" class="px-6 py-3 rounded-lg border text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection