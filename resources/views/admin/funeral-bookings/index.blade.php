@extends('layouts.dashboard')

@section('title', 'Funeral Bookings')
@section('header', 'Funeral Bookings')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
        <div>
            <h2 class="text-lg font-semibold">Janazah/Funeral Bookings</h2>
            <p class="text-sm text-gray-600">Manage funeral service inquiries and bookings</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.funeral-bookings.index') }}" 
               class="px-4 py-2 rounded-lg border text-sm {{ request('status') ? 'hover:bg-gray-50' : 'bg-gray-900 text-white' }}">
                All ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.funeral-bookings.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg border text-sm {{ request('status') === 'pending' ? 'bg-yellow-50 border-yellow-300 text-yellow-700' : 'hover:bg-gray-50' }}">
                Pending ({{ $stats['pending'] }})
            </a>
            <a href="{{ route('admin.funeral-bookings.index', ['status' => 'confirmed']) }}" 
               class="px-4 py-2 rounded-lg border text-sm {{ request('status') === 'confirmed' ? 'bg-green-50 border-green-300 text-green-700' : 'hover:bg-gray-50' }}">
                Confirmed ({{ $stats['confirmed'] }})
            </a>
            <span class="px-4 py-2 rounded-lg border text-sm text-gray-500">
                Unread: {{ $stats['unread'] }}
            </span>
        </div>
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
                        <th class="text-left px-4 py-3">Name</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Phone</th>
                        <th class="text-left px-4 py-3">Deceased</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Read</th>
                        <th class="text-left px-4 py-3">Created</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($bookings as $booking)
                    <tr class="{{ $booking->read ? '' : 'bg-blue-50' }}">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $booking->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $booking->email }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $booking->phone ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $booking->deceased_name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($booking->status === 'pending')
                                <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs">Pending</span>
                            @elseif($booking->status === 'confirmed')
                                <span class="px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200 text-xs">Confirmed</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="px-2 py-1 rounded bg-red-50 text-red-700 border border-red-200 text-xs">Cancelled</span>
                            @elseif($booking->status === 'completed')
                                <span class="px-2 py-1 rounded bg-blue-50 text-blue-700 border border-blue-200 text-xs">Completed</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($booking->read)
                                <span class="text-green-600">✓</span>
                            @else
                                <span class="text-gray-400">○</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $booking->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.funeral-bookings.show', $booking) }}"
                               class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                View
                            </a>
                            @if(!$booking->read)
                                <form action="{{ route('admin.funeral-bookings.mark-as-read', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                        Mark Read
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-600">
                            No funeral bookings yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection