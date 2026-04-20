@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gift Aid Declarations</h1>
        <p class="text-gray-600 mt-1">Manage Gift Aid declarations for donors</p>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.gift-aid.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        Add New Declaration
                    </a>
                    <a href="{{ route('admin.gift-aid.report') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                        View Report
                    </a>
                    <a href="{{ route('admin.gift-aid.export') }}" 
                       class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                        Export CSV
                    </a>
                </div>
                <div class="text-sm text-gray-600">
                    Total Declarations: {{ $declarations->count() }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Declaration Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($declarations as $declaration)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $declaration->donor_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $declaration->donor_email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $declaration->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $declaration->is_active ? 'Active' : 'Cancelled' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $declaration->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.gift-aid.show', $declaration) }}" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('admin.gift-aid.edit', $declaration) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                @if($declaration->is_active)
                                    <form action="{{ route('admin.gift-aid.cancel', $declaration) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to cancel this Gift Aid declaration?')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No Gift Aid declarations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection