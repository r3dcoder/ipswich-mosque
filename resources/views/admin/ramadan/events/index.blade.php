@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Ramadan Events</h1>
                <p class="text-gray-600">{{ $ramadan->title }} ({{ $ramadan->year }})</p>
            </div>
            <a href="{{ route('admin.ramadan.events.create', $ramadan) }}" 
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-lg flex items-center gap-2">
                <span>+</span> Add New Event
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($events->isEmpty())
            <div class="bg-white p-12 text-center rounded-2xl shadow">
                <p class="text-gray-500 text-xl">No events added yet for this Ramadan.</p>
                <a href="{{ route('admin.ramadan.events.create', $ramadan) }}" class="text-emerald-600 mt-4 inline-block">Add your first event →</a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach ($events as $event)
                    <div class="bg-white rounded-2xl shadow p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex-1">
                            <h3 class="font-semibold text-xl">{{ $event->title }}</h3>
                            <p class="text-gray-600 mt-1">{{ $event->description }}</p>
                            <div class="flex gap-4 mt-3 text-sm">
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">
                                    {{ $event->event_date->format('d M Y') }}
                                </span>
                                @if($event->start_time)
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full">
                                        {{ $event->start_time->format('H:i') }} 
                                        @if($event->end_time) - {{ $event->end_time->format('H:i') }} @endif
                                    </span>
                                @endif
                            </div>
                            @if($event->location)
                                <p class="text-gray-500 mt-2">📍 {{ $event->location }}</p>
                            @endif
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('admin.ramadan.events.edit', [$ramadan, $event]) }}" 
                               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('admin.ramadan.events.destroy', [$ramadan, $event]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                        onclick="return confirm('Delete this event?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('admin.ramadan.index') }}" class="text-emerald-600 hover:underline">← Back to Ramadan Years</a>
        </div>
    </div>
@endsection