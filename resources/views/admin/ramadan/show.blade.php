@extends('layouts.dashboard')   {{-- or layouts.dashboard if you use that --}}

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">{{ $ramadan->title }} ({{ $ramadan->year }})</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.ramadan.edit', $ramadan) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg">Edit Settings</a>
                <a href="{{ route('admin.ramadan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg">Back</a>
            </div>
        </div>

        @if ($ramadan->timetable_image)
            <div class="mb-10">
                <h2 class="text-xl font-semibold mb-3">Timetable Image</h2>
                <img src="{{ Storage::url($ramadan->timetable_image) }}" 
                     alt="Timetable" class="max-w-4xl rounded-xl shadow">
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500">Start Date</p>
                <p class="text-2xl font-semibold">{{ $ramadan->start_date?->format('d M Y') ?? 'Not set' }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500">Prayer Times</p>
                <p class="text-2xl font-semibold">{{ $ramadan->dailyTimes->count() }} days</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center">
                <p class="text-gray-500">Events</p>
                <p class="text-2xl font-semibold">{{ $ramadan->events->count() }} events</p>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Manage Events -->
            <a href="{{ route('admin.ramadan.events.index', $ramadan) }}" 
               class="block bg-white border-2 border-dashed border-amber-400 hover:border-amber-600 p-10 rounded-3xl text-center transition">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-2xl font-semibold text-amber-700">Manage Events</h3>
                <p class="text-gray-600 mt-3">Add Taraweeh, Iftar, Laylatul Qadr, etc.</p>
                <span class="mt-6 inline-block bg-amber-600 text-white px-8 py-3 rounded-full text-sm font-medium">
                    Go to Events →
                </span>
            </a>

            <!-- Manage Daily Times (placeholder for now) -->
            <div class="block bg-white border-2 border-dashed border-emerald-400 p-10 rounded-3xl text-center">
                <div class="text-6xl mb-4">🕋</div>
                <h3 class="text-2xl font-semibold text-emerald-700">Manage Daily Times</h3>
                <p class="text-gray-600 mt-3">Sehri, Fajr, Iftar times for all 30 days</p>
                <span class="mt-6 inline-block text-emerald-600 font-medium">Coming Soon</span>
            </div>
        </div>
    </div>
@endsection