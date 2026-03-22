@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Ramadan Management</h1>
            <a href="{{ route('admin.ramadan.create') }}" 
               class="bg-emerald-600 hover:bg-emerald-700 text-black px-4 py-2 rounded">
                Add New Ramadan Year
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Times</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Events</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ramadans as $ramadan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ramadan->year }}</td>
                            <td class="px-6 py-4">{{ $ramadan->title }}</td>
                            <td class="px-6 py-4">{{ $ramadan->daily_times_count }}</td>
                            <td class="px-6 py-4">{{ $ramadan->events_count }}</td>
                            <td class="px-6 py-4 text-center text-sm">
                                <a href="{{ route('admin.ramadan.show', $ramadan) }}" class="text-blue-600 hover:underline mr-2">View</a>
                                <a href="{{ route('admin.ramadan.edit', $ramadan) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.ramadan.destroy', $ramadan) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Delete this year and all its times/events?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No Ramadan entries yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $ramadans->links() }}
            </div>
        </div>
    </div>
@endsection