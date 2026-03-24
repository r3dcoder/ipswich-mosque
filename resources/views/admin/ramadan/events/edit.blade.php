@extends('layouts.dashboard')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Edit Event - {{ $ramadan->title }} ({{ $ramadan->year }})
        </h1>

        <form action="{{ route('admin.ramadan.events.update', [$ramadan, $event]) }}" 
              method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6 bg-white p-8 rounded-3xl shadow">
                
                <!-- Event Title -->
                <div>
                    <label class="block text-sm font-medium mb-2">Event Title <span class="text-red-500">*</span></label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $event->title) }}" 
                           required
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date + Location -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Event Date <span class="text-red-500">*</span></label>
                        <input type="date" 
                               name="event_date" 
                               value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" 
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
                               value="{{ old('location', $event->location) }}" 
                               placeholder="Main Prayer Hall / Community Hall"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                </div>

                <!-- Start Time + End Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Start Time</label>
                        <input type="time" 
                               name="start_time" 
                               value="{{ old('start_time', $event->start_time?->format('H:i')) }}"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">End Time</label>
                        <input type="time" 
                               name="end_time" 
                               value="{{ old('end_time', $event->end_time?->format('H:i')) }}"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" 
                              rows="5"
                              class="w-full border border-gray-300 rounded-2xl px-5 py-4">{{ old('description', $event->description) }}</textarea>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex gap-4">
                <a href="{{ route('admin.ramadan.events.index', $ramadan) }}" 
                   class="flex-1 text-center py-4 bg-gray-200 hover:bg-gray-300 rounded-2xl font-medium transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-medium transition">
                    Update Event
                </button>
            </div>
        </form>
    </div>
@endsection