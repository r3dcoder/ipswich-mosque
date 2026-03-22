@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Create Ramadan Year</h1>

    <form action="{{ route('admin.ramadan.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Year --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Year <span class="text-red-500">*</span>
                </label>
                <input type="number" name="year"
                    value="{{ old('year', date('Y')+1) }}"
                    required
                    class="w-full border rounded px-3 py-2 @error('year') border-red-500 @enderror">

                @error('year')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title"
                    value="{{ old('title', 'Ramadan ' . (date('Y')+1)) }}"
                    required
                    class="w-full border rounded px-3 py-2">

                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Start Date --}}
            <div>
                <label class="block text-sm font-medium mb-1">Start Date</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date') }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Countdown --}}
            <div>
                <label class="block text-sm font-medium mb-1">Countdown Target</label>
                <input type="datetime-local" name="countdown_target"
                    value="{{ old('countdown_target') }}"
                    class="w-full border rounded px-3 py-2">
            </div>

        </div>

        {{-- Hero Message --}}
        <div class="mt-6">
            <label class="block text-sm font-medium mb-1">Hero Message</label>
            <textarea name="hero_message" rows="4"
                class="w-full border rounded px-3 py-2">{{ old('hero_message') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div class="mt-6">
            <label class="block text-sm font-medium mb-1">
                Timetable Image
            </label>

            <input type="file" name="timetable_image" accept="image/*"
                class="w-full border rounded px-3 py-2">

            @error('timetable_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.ramadan.index') }}"
               class="px-6 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Cancel
            </a>

            <button type="submit"
                class="px-6 py-2 bg-emerald-600 text-black rounded hover:bg-emerald-700">
                Create
            </button>
        </div>

    </form>
</div>
@endsection