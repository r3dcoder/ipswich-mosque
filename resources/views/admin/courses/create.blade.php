@extends('layouts.dashboard')

@section('title', 'Create Course Section')
@section('header', 'Create Course Section')

@section('content')
<div class="max-w-3xl">

    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.courses.store') }}"
          class="bg-white border rounded-xl p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Page</label>
                <input name="page" value="{{ old('page','home') }}" class="w-full rounded-lg border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Slug</label>
                <input name="slug" value="{{ old('slug','courses') }}" class="w-full rounded-lg border-gray-300">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title"
                   value="{{ old('title','📖 Quran Education at Ipswich Mosque') }}"
                   class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Subtitle</label>
            <input name="subtitle"
                   value="{{ old('subtitle','Providing structured Islamic education for all ages') }}"
                   class="w-full rounded-lg border-gray-300">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div>
                <label class="block text-sm font-medium mb-1">Sort Order</label>
                <input type="number" min="1" name="sort_order" value="{{ old('sort_order',1) }}"
                       class="w-full rounded-lg border-gray-300">
            </div>

            <div class="flex items-center gap-2 mt-6 md:mt-0">
                <input type="hidden" name="is_active" value="0">
                <input id="is_active" type="checkbox" name="is_active" value="1"
                       class="rounded border-gray-300" checked>
                <label for="is_active" class="text-sm">Active</label>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.courses.index') }}"
               class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">
                Cancel
            </a>

            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
