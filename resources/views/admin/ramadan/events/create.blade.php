@extends('layouts.dashboard')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Add New Event - {{ $ramadan->title }} ({{ $ramadan->year }})
        </h1>

        <form action="{{ route('admin.ramadan.events.store', $ramadan) }}" method="POST">
            @csrf

            <div class="space-y-6 bg-white p-8 rounded-3xl shadow">
                
                <div>
                    <label class="block text-sm font-medium mb-2">Event Title <span class="text-red-500">*</span></label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title') }}" 
                           required
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Event Date <span class="text-red-500">*</span></label>
                        <input type="date" 
                               name="event_date" 
                               value="{{ old('event_date') }}" 
                               required
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                        @error('event_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Location</label>
                        <input type="text" 
                               name="location" 
                               value="{{ old('location') }}" 
                               placeholder="Main Prayer Hall / Community Hall"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Start Time</label>
                        <input type="time" 
                               name="start_time" 
                               value="{{ old('start_time') }}"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">End Time</label>
                        <input type="time" 
                               name="end_time" 
                               value="{{ old('end_time') }}"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" 
                              rows="5"
                              class="w-full border border-gray-300 rounded-2xl px-5 py-4">{{ old('description') }}</textarea>
                </div>

            </div>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('admin.ramadan.events.index', $ramadan) }}" 
                   class="flex-1 text-center py-4 bg-gray-200 hover:bg-gray-300 rounded-2xl font-medium transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-medium transition">
                    Add Event
                </button>
            </div>
        </form>
    </div>
@endsection