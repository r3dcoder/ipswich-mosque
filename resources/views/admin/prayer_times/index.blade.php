@extends('layouts.dashboard')

@section('title', 'Prayer Times')
@section('header', 'Prayer Times')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Prayer Times</h2>
        <p class="text-sm text-gray-600">Manage imported prayer timetable rows.</p>
    </div>

    <a href="{{ route('admin.prayer-times.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + Add Row
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<form class="bg-white border rounded-xl p-4 mb-4 flex flex-col md:flex-row gap-3 md:items-end">
    <div class="md:w-64">
        <label class="block text-sm font-medium mb-1">Month</label>
        <select name="month" class="w-full rounded-lg border-gray-300">
            <option value="">All</option>
            @foreach($months as $m)
                <option value="{{ $m }}" @selected($month === $m)>{{ $m }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex-1">
        <label class="block text-sm font-medium mb-1">Search</label>
        <input name="q" value="{{ $q }}" class="w-full rounded-lg border-gray-300" placeholder="Day / date / Hijri month">
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Filter</button>
        <a href="{{ route('admin.prayer-times.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Reset</a>
    </div>
</form>

<div class="bg-white border rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
            <tr class="whitespace-nowrap">
                <th class="text-left px-3 py-3">Month</th>
                <th class="text-left px-3 py-3">Date</th>
                <th class="text-left px-3 py-3">Day</th>
                <th class="text-left px-3 py-3">Fajr</th>
                <th class="text-left px-3 py-3">Sunrise</th>
                <th class="text-left px-3 py-3">Zuhr</th>
                <th class="text-left px-3 py-3">Asr</th>
                <th class="text-left px-3 py-3">Maghrib</th>
                <th class="text-left px-3 py-3">Isha</th>
                <th class="text-left px-3 py-3">Hijri</th>
                <th class="text-right px-3 py-3">Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($prayers as $p)
                <tr class="whitespace-nowrap">
                    <td class="px-3 py-3">{{ $p->month ?? '—' }}</td>
                    <td class="px-3 py-3">{{ $p->date }}</td>
                    <td class="px-3 py-3">{{ $p->day }}</td>

                    <td class="px-3 py-3">
                        <div>Beg: {{ $p->fajr_begins ?? '—' }}</div>
                        <div class="text-xs text-gray-500">Jam: {{ $p->fajr_jamaat ?? '—' }}</div>
                    </td>

                    <td class="px-3 py-3">{{ $p->sunrise ?? '—' }}</td>

                    <td class="px-3 py-3">
                        <div>Beg: {{ $p->zuhr_begins ?? '—' }}</div>
                        <div class="text-xs text-gray-500">Jam: {{ $p->zuhr_jamaat ?? '—' }}</div>
                    </td>

                    <td class="px-3 py-3">
                        <div>Beg: {{ $p->asr_begins ?? '—' }}</div>
                        <div class="text-xs text-gray-500">Jam: {{ $p->asr_jamaat ?? '—' }}</div>
                    </td>

                    <td class="px-3 py-3">
                        <div>Beg: {{ $p->maghrib_begins ?? '—' }}</div>
                        <div class="text-xs text-gray-500">Jam: {{ $p->maghrib_jamaat ?? '—' }}</div>
                    </td>

                    <td class="px-3 py-3">
                        <div>Beg: {{ $p->isha_begins ?? '—' }}</div>
                        <div class="text-xs text-gray-500">Jam: {{ $p->isha_jamaat ?? '—' }}</div>
                    </td>

                    <td class="px-3 py-3">
                        {{ $p->hijri_date ?? '—' }} {{ $p->hijri_month ?? '' }} {{ $p->hijri_year ?? '' }}
                    </td>

                    <td class="px-3 py-3 text-right space-x-2">
                        <a href="{{ route('admin.prayer-times.edit', $p) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>

                        <form action="{{ route('admin.prayer-times.destroy', $p) }}" method="POST"
                              class="inline" onsubmit="return confirm('Delete this row?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11" class="px-4 py-6 text-center text-gray-600">No rows found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $prayers->links() }}
    </div>
</div>
@endsection
