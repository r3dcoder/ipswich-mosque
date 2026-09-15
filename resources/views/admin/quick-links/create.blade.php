@extends('layouts.dashboard')

@section('title', 'Create Quick Link')

@section('content')
<script>
document.addEventListener('DOMContentLoaded', function() {
    toggleImageUpload();
});

function toggleImageUpload() {
    const iconType = document.getElementById('icon_type').value;
    const svgField = document.getElementById('svg-icon-field');
    const imageField = document.getElementById('image-upload-field');
    
    if (iconType === 'image') {
        svgField.classList.add('hidden');
        imageField.classList.remove('hidden');
    } else {
        svgField.classList.remove('hidden');
        imageField.classList.add('hidden');
    }
}
</script>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create Quick Link</h1>
        <a href="{{ route('admin.quick-links.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back to Quick Links
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.quick-links.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL *</label>
                <input type="text" name="url" id="url" value="{{ old('url') }}" required placeholder="/khutbah"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="icon_type" class="block text-sm font-medium text-gray-700 mb-2">Icon Type *</label>
                <select name="icon_type" id="icon_type" required onchange="toggleImageUpload()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="svg" {{ old('icon_type') == 'svg' ? 'selected' : '' }}>SVG Icon (Built-in)</option>
                    <option value="image" {{ old('icon_type') == 'image' ? 'selected' : '' }}>Custom Image Upload</option>
                </select>
            </div>

            <div class="mb-4" id="svg-icon-field">
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Select Icon *</label>
                <select name="icon" id="icon"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="book" {{ old('icon') == 'book' ? 'selected' : '' }}>Book (Khutbah)</option>
                    <option value="heart" {{ old('icon') == 'heart' ? 'selected' : '' }}>Heart (Duas)</option>
                    <option value="building" {{ old('icon') == 'building' ? 'selected' : '' }}>Building (Principles)</option>
                    <option value="link" {{ old('icon') == 'link' ? 'selected' : '' }}>Link (Generic)</option>
                </select>
                @error('icon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 hidden" id="image-upload-field">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <p class="text-sm text-gray-500 mt-1">Upload a custom icon image (max 2MB, recommended size: 64x64px)</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color Theme *</label>
                <select name="color" id="color" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Green</option>
                    <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }}>Blue</option>
                    <option value="amber" {{ old('color') == 'amber' ? 'selected' : '' }}>Amber</option>
                    <option value="red" {{ old('color') == 'red' ? 'selected' : '' }}>Red</option>
                    <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }}>Purple</option>
                    <option value="indigo" {{ old('color') == 'indigo' ? 'selected' : '' }}>Indigo</option>
                </select>
                @error('color')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <p class="text-sm text-gray-500 mt-1">Lower numbers appear first.</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Active (show on homepage)</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    Create Quick Link
                </button>
                <a href="{{ route('admin.quick-links.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
