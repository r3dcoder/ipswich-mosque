@extends('layouts.dashboard')

@section('title', 'Jummah Schedules')
@section('header', 'Jummah Schedules')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Jummah Time Ranges</h2>
        <p class="text-sm text-gray-600">Add/edit Jummah times that apply for date ranges.</p>
    </div>

    <a href="{{ route('admin.jummah.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + Add Schedule
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left px-4 py-3">Effective From</th>
                    <th class="text-left px-4 py-3">Effective Till</th>
                    <th class="text-left px-4 py-3">Khutbah</th>
                    <th class="text-left px-4 py-3">Salah</th>
                    <th class="text-left px-4 py-3">Active</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
            @forelse ($schedules as $s)
                <tr>
                    <td class="px-4 py-3">{{ $s->effective_from?->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $s->effective_till?->format('d M Y') ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $s->khutbah_time ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $s->salah_time ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($s->is_active)
                            <span class="px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200">Yes</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-50 text-gray-600 border">No</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right space-x-2">
                        <a href="{{ route('admin.jummah.edit', $s) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>

                        <form action="{{ route('admin.jummah.destroy', $s) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this schedule?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                @if($s->note)
                    <tr class="bg-gray-50">
                        <td colspan="6" class="px-4 py-2 text-gray-600">
                            <span class="font-medium">Note:</span> {{ $s->note }}
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-600">
                        No schedules yet. Click “Add Schedule”.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $schedules->links() }}
    </div>
</div>
@endsection
