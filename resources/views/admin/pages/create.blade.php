@extends('layouts.dashboard')

@section('title', 'Create Page')
@section('header', 'Create Page')

@section('content')
<div class="max-w-3xl">
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pages.store') }}" method="POST" class="bg-white border rounded-xl p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input name="title" value="{{ old('title') }}"
                   class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                   placeholder="Ramadan, Nikah, Janazah, Visiting Us" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Slug (URL)</label>
            <input name="slug" value="{{ old('slug') }}"
                   class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                   placeholder="ramadan (leave blank to auto-generate)">
            <p class="text-xs text-gray-500 mt-1">Public URL will be: /your-slug</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Excerpt (optional)</label>
            <textarea name="excerpt" rows="3"
                      class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                      placeholder="Short summary...">{{ old('excerpt') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Meta Title (optional)</label>
                <input name="meta_title" value="{{ old('meta_title') }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Published</label>
                <label class="mt-2 inline-flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300"
                           {{ old('is_published') ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">Make page public</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Meta Description (optional)</label>
            <textarea name="meta_description" rows="3"
                      class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('meta_description') }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                Create Page
            </button>
            <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-700 underline">Cancel</a>
        </div>
    </form>

    <p class="text-sm text-gray-500 mt-4">
        After creating the page, you can add blocks/components (Hero, Text, Timetable, Eid Jamaat, Downloads, etc).
    </p>
</div>
@endsection
