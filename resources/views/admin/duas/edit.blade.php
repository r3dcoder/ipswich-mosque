@extends('layouts.dashboard')

@section('title', 'Edit Dua')
@section('header', 'Edit Dua')

@section('content')
<div class="max-w-3xl bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.duas.update', $dua) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Category</label>
            <select name="dua_category_id" class="w-full rounded-lg border-gray-300" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('dua_category_id', $dua->dua_category_id) == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            @error('dua_category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input name="title" value="{{ old('title', $dua->title) }}" class="w-full rounded-lg border-gray-300" required>
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Arabic</label>
            <textarea name="arabic" rows="4" class="w-full rounded-lg border-gray-300" required>{{ old('arabic', $dua->arabic) }}</textarea>
            @error('arabic') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Pronunciation (optional)</label>
            <textarea name="pronunciation" rows="3" class="w-full rounded-lg border-gray-300">{{ old('pronunciation', $dua->pronunciation) }}</textarea>
            @error('pronunciation') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Translation</label>
            <textarea name="translation" rows="4" class="w-full rounded-lg border-gray-300" required>{{ old('translation', $dua->translation) }}</textarea>
            @error('translation') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Keywords (optional)</label>
            <input name="keywords" value="{{ old('keywords', $dua->keywords) }}" class="w-full rounded-lg border-gray-300">
            @error('keywords') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.duas.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>
@endsection
