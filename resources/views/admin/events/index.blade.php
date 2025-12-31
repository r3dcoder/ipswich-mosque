@extends('layouts.dashboard')

@section('title', 'Events')
@section('header', 'Events')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Upcoming Events</h2>
        <p class="text-sm text-gray-600">Create, edit, and manage mosque events.</p>
    </div>

    <a href="{{ route('admin.events.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + Add Event
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
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Title</th>
                    <th class="text-left px-4 py-3">Location</th>
                    <th class="text-left px-4 py-3">Active</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
            @forelse ($events as $e)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $e->starts_at?->format('d M Y, g:i A') }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $e->title }}
                        @if($e->description)
                            <div class="text-xs text-gray-500 mt-1 line-clamp-2">
                                {{ $e->description }}
                            </div>
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        {{ $e->location ?? '—' }}
                    </td>

                    <td class="px-4 py-3">
                        @if($e->is_active)
                            <span class="px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200">Yes</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-50 text-gray-600 border">No</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.events.edit', $e) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>

                        <form action="{{ route('admin.events.destroy', $e) }}" method="POST"
                              class="inline" onsubmit="return confirm('Delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-600">
                        No events yet. Click “Add Event”.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $events->links() }}
    </div>
</div>
@endsection
