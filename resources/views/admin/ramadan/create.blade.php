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
                    value="{{ old('title', 'Ramadan Mubarak ' . (date('Y')+1)) }}"
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
                <label class="block text-sm font-medium mb-1">Countdown Target (JS Countdown)</label>
                <input type="datetime-local" name="countdown_target"
                    value="{{ old('countdown_target') }}"
                    class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
            <h2 class="text-lg font-bold mb-4 text-teal-800">Ramadan Info Cards Data</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Fitrana --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Fitrana Amount (e.g. 5.00)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">£</span>
                        <input type="text" name="fitrana"
                            value="{{ old('fitrana', '5.00') }}"
                            placeholder="5.00"
                            class="w-full border rounded pl-7 pr-3 py-2">
                    </div>
                </div>

                {{-- Eid Jamat --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Eid Jamat Times</label>
                    <input type="text" name="eid_jamat"
                        value="{{ old('eid_jamat') }}"
                        placeholder="1st: 8:00am | 2nd: 9:00am"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Isha & Taraweeh --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Isha & Taraweeh Note</label>
                    <input type="text" name="esha_and_taraweeh"
                        value="{{ old('esha_and_taraweeh') }}"
                        placeholder="See calendar for times"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>
        </div>

        {{-- Hero Message --}}
        <div class="mt-6">
            <label class="block text-sm font-medium mb-1">Hero Message</label>
            <textarea name="hero_message" rows="3"
                placeholder="May Allah accept our fasting..."
                class="w-full border rounded px-3 py-2">{{ old('hero_message') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div class="mt-6">
            <label class="block text-sm font-medium mb-1">Timetable Image (JPG/PNG)</label>
            <input type="file" name="timetable_image" accept="image/*"
                class="w-full border rounded px-3 py-2 bg-white">
            @error('timetable_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.ramadan.index') }}"
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium transition">
                Cancel
            </a>

            <button type="submit"
                class="px-8 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 font-bold shadow-lg transition">
                Create Ramadan Year
            </button>
        </div>

    </form>
</div>
@endsection