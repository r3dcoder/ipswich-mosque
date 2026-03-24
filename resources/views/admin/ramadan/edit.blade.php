@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        Edit Ramadan Setting - {{ $ramadan->year }}
    </h1>

    <form action="{{ route('admin.ramadan.update', $ramadan->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6 bg-white p-8 rounded-3xl shadow">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Year (Read Only or Disabled usually recommended for Unique keys) --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Year <span class="text-red-500">*</span></label>
                    <input type="number" name="year"
                        value="{{ old('year', $ramadan->year) }}"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">
                    @error('year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title"
                        value="{{ old('title', $ramadan->title) }}"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Start Date</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', $ramadan->start_date?->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                </div>

                {{-- Countdown --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Countdown Target</label>
                    <input type="datetime-local" name="countdown_target"
                        value="{{ old('countdown_target', $ramadan->countdown_target ? date('Y-m-d\TH:i', strtotime($ramadan->countdown_target)) : '') }}"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                </div>
            </div>

            <div class="p-6 bg-teal-50 rounded-2xl border border-teal-100">
                <h2 class="text-lg font-bold mb-4 text-teal-800">Ramadan Info Cards</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Fitrana --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Fitrana (£)</label>
                        <input type="text" name="fitrana"
                            value="{{ old('fitrana', $ramadan->fitrana) }}"
                            placeholder="5.00"
                            class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>

                    {{-- Eid Jamat --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Eid Jamat</label>
                        <input type="text" name="eid_jamat"
                            value="{{ old('eid_jamat', $ramadan->eid_jamat) }}"
                            placeholder="8:00, 9:00, 10:30"
                            class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>

                    {{-- Isha & Taraweeh --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Isha & Taraweeh</label>
                        <input type="text" name="esha_and_taraweeh"
                            value="{{ old('esha_and_taraweeh', $ramadan->esha_and_taraweeh) }}"
                            placeholder="See calendar for times"
                            class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                </div>
            </div>

            {{-- Hero Message --}}
            <div>
                <label class="block text-sm font-medium mb-2">Hero Message</label>
                <textarea name="hero_message" rows="3"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4">{{ old('hero_message', $ramadan->hero_message) }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div>
                <label class="block text-sm font-medium mb-2">Timetable Image</label>
                
                @if($ramadan->timetable_image)
                    <div class="mb-4 relative w-32 group">
                        <img src="{{ Storage::url($ramadan->timetable_image) }}" 
                             class="h-32 w-32 object-cover rounded-2xl border">
                        <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-white text-xs">Current</span>
                        </div>
                    </div>
                @endif

                <input type="file" name="timetable_image" accept="image/*"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-50 text-sm">
                <p class="text-gray-500 text-xs mt-2">Uploading a new image will replace the old one.</p>
                @error('timetable_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex gap-4">
            <a href="{{ route('admin.ramadan.index') }}" 
               class="flex-1 text-center py-4 bg-gray-200 hover:bg-gray-300 rounded-2xl font-medium transition">
                Cancel
            </a>
            <button type="submit" 
                    class="flex-1 py-4 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl font-medium transition">
                Update Ramadan Setting
            </button>
        </div>
    </form>
</div>
@endsection