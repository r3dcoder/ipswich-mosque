@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ $ramadan->title }} ({{ $ramadan->year }})</h1>
            <div>
                <a href="{{ route('admin.ramadan.edit', $ramadan) }}" class="bg-yellow-500 text-white px-4 py-2 rounded mr-2 hover:bg-yellow-600">Edit</a>
                <a href="{{ route('admin.ramadan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
            </div>
        </div>

        @if ($ramadan->timetable_image)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">Timetable Image</h2>
                <img src="{{ Storage::url($ramadan->timetable_image) }}" alt="Timetable" class="max-w-3xl rounded shadow">
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <p><strong>Start Date:</strong> {{ $ramadan->start_date ? $ramadan->start_date->format('d M Y') : 'Not set' }}</p>
                <p><strong>Countdown Target:</strong> {{ $ramadan->countdown_target ?? 'Not set' }}</p>
            </div>
            <div>
                <p><strong>Daily Prayer Times:</strong> {{ $ramadan->dailyTimes->count() }}</p>
                <p><strong>Events:</strong> {{ $ramadan->events->count() }}</p>
            </div>
        </div>

        <!-- You can add tabs or sections for dailyTimes & events preview here later -->
    </div>
@endsection