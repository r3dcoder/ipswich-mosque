@extends('layouts.dashboard')

@section('title', 'Funeral Booking Details')
@section('header', 'Funeral Booking Details')

@section('content')
<div class="max-w-4xl">
    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Booking Details -->
        <div class="lg:col-span-2 bg-white border rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Booking Information</h3>
                <div class="flex gap-2">
                    <span class="px-2 py-1 rounded text-xs {{ $funeralBooking->read ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $funeralBooking->read ? 'Read' : 'Unread' }}
                    </span>
                    <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-800">
                        {{ $funeralBooking->status_label }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <p class="text-gray-900 font-medium">{{ $funeralBooking->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <p class="text-gray-900 font-medium">{{ $funeralBooking->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <p class="text-gray-900 font-medium">{{ $funeralBooking->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deceased Name</label>
                    <p class="text-gray-900 font-medium">{{ $funeralBooking->deceased_name ?? 'Not specified' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Submitted</label>
                    <p class="text-gray-900 font-medium">{{ $funeralBooking->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            @if($funeralBooking->message)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $funeralBooking->message }}</p>
                </div>
            @endif
        </div>

        <!-- Admin Actions -->
        <div class="bg-white border rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Admin Actions</h3>
            
            <form action="{{ route('admin.funeral-bookings.update', $funeralBooking) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                        <option value="pending" {{ $funeralBooking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $funeralBooking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ $funeralBooking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ $funeralBooking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                    <textarea name="admin_notes" rows="4" 
                              class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                              placeholder="Add any notes about this booking...">{{ old('admin_notes', $funeralBooking->admin_notes) }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                        Update Booking
                    </button>
                    @if(!$funeralBooking->read)
                        <form action="{{ route('admin.funeral-bookings.mark-as-read', $funeralBooking) }}" method="POST" class="inline">
                            @csrf
                            <button class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">
                                Mark Read
                            </button>
                        </form>
                    @endif
                </div>
            </form>

            <div class="mt-6 pt-6 border-t">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Quick Actions</h4>
                <div class="space-y-2">
                    <a href="mailto:{{ $funeralBooking->email }}" 
                       class="block w-full text-center px-4 py-2 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 text-sm hover:bg-blue-100">
                        Email {{ $funeralBooking->name }}
                    </a>
                    @if($funeralBooking->phone)
                        <a href="tel:{{ $funeralBooking->phone }}" 
                           class="block w-full text-center px-4 py-2 rounded-lg bg-green-50 text-green-700 border border-green-200 text-sm hover:bg-green-100">
                            Call {{ $funeralBooking->phone }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <div class="mt-6 bg-white border rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-2 text-red-600">Danger Zone</h3>
        <p class="text-sm text-gray-600 mb-4">This action cannot be undone.</p>
        
        <form action="{{ route('admin.funeral-bookings.destroy', $funeralBooking) }}" method="POST" 
              onsubmit="return confirm('Are you sure you want to delete this booking?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                Delete Booking
            </button>
        </form>
    </div>
</div>
@endsection