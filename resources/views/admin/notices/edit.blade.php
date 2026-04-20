@extends('layouts.dashboard')

@section('title', 'Edit Notice')
@section('header', 'Edit Notice')

@section('content')
<div class="max-w-4xl mx-auto">
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.notices.update', $notice) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $notice->title) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="category" name="category" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category', $notice->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image (Optional)</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div class="md:col-span-2">
                    <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">Summary (Optional)</label>
                    <textarea id="summary" name="summary" rows="2" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Brief summary of the notice...">{{ old('summary', $notice->summary) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <textarea id="content" name="content" rows="10" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Full notice content...">{{ old('content', $notice->content) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Settings</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $notice->published_at ? $notice->published_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                    <input type="datetime-local" id="expires_at" name="expires_at" value="{{ old('expires_at', $notice->expires_at ? $notice->expires_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $notice->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Active (visible to public)</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_pinned" name="is_pinned" value="1" {{ old('is_pinned', $notice->is_pinned) ? 'checked' : '' }}
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    <label for="is_pinned" class="ml-2 block text-sm text-gray-700">Pin to top</label>
                </div>

                <div class="flex items-center md:col-span-2">
                    <input type="checkbox" id="send_email_notification" name="send_email_notification" value="1" {{ old('send_email_notification', $notice->send_email_notification) ? 'checked' : '' }}
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    <label for="send_email_notification" class="ml-2 block text-sm text-gray-700">
                        Send email notification to newsletter subscribers
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.notices.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" class="px-6 py-3 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">Update Notice</button>
        </div>
    </form>
</div>
@endsection