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
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 whitespace-nowrap">
        + Add Schedule
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border rounded-xl overflow-hidden w-full">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm table-fixed">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="w-1/6 text-left px-4 py-3 whitespace-nowrap">Effective From</th>
                    <th class="w-1/6 text-left px-4 py-3 whitespace-nowrap">Effective Till</th>
                    <th class="w-1/6 text-left px-4 py-3 whitespace-nowrap">Khutbah</th>
                    <th class="w-1/6 text-left px-4 py-3 whitespace-nowrap">Salah</th>
                    <th class="w-1/6 text-left px-4 py-3 whitespace-nowrap">Active</th>
                    <th class="w-[180px] text-right px-4 py-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse ($schedules as $s)
                <tr>
                    <td class="px-4 py-3 truncate">
                        {{ $s->effective_from?->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 truncate">
                        {{ $s->effective_till?->format('d M Y') ?? '—' }}
                    </td>
                    <td class="px-4 py-3 truncate">
                        {{ $s->khutbah_time ?? '—' }}
                    </td>
                    <td class="px-4 py-3 truncate">
                        {{ $s->salah_time ?? '—' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($s->is_active)
                            <span class="inline-flex items-center px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200">
                                Yes
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded bg-gray-50 text-gray-600 border">
                                No
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.jummah.edit', $s) }}"
                               class="inline-flex items-center px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                Edit
                            </a>

                            <form action="{{ route('admin.jummah.destroy', $s) }}" method="POST"
                                  onsubmit="return confirm('Delete this schedule?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
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
