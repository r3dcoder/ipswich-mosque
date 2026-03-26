@extends('layouts.dashboard')

@section('title', 'View Contact Message')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Contact Message</h1>
                    <p class="text-gray-600 mt-1">View and manage contact form submission</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                        Back to List
                    </a>
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors"
                                onclick="return confirm('Are you sure you want to delete this message?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Message Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Message Content -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $contact->subject }}</h2>
                            <p class="text-sm text-gray-500 mt-1">From: {{ $contact->name }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $contact->read ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                            {{ $contact->read ? 'Read' : 'Unread' }}
                        </span>
                    </div>
                    
                    <div class="prose max-w-none">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <p class="text-gray-900">{{ $contact->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900">
                                <a href="mailto:{{ $contact->email }}" class="text-green-600 hover:text-green-800">
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <p class="text-gray-900">{{ $contact->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Contact Method</label>
                            <p class="text-gray-900 capitalize">{{ $contact->contact_method }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Message Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Message Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Submitted</label>
                            <p class="text-gray-900 mt-1">{{ $contact->created_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <p class="text-gray-900 mt-1">{{ $contact->read ? 'Read' : 'Unread' }}</p>
                        </div>
                        @if($contact->read_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Read At</label>
                                <p class="text-gray-900 mt-1">{{ $contact->read_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        @if(!$contact->read)
                            <form action="{{ route('admin.contacts.markAsRead', $contact) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                    Mark as Read
                                </button>
                            </form>
                        @endif
                        <a href="mailto:{{ $contact->email }}" 
                           class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center">
                            Reply via Email
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Message Length</span>
                            <span class="font-medium">{{ strlen(strip_tags($contact->message)) }} characters</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Subject Length</span>
                            <span class="font-medium">{{ strlen($contact->subject) }} characters</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Submitted</span>
                            <span class="font-medium">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection