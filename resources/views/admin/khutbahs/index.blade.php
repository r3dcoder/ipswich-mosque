@extends('layouts.dashboard')

@section('title', 'Khutbah Management')
@section('header', 'Khutbah Management')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
        <div>
            <h2 class="text-lg font-semibold">Khutbah Videos</h2>
            <p class="text-sm text-gray-600">Manage Friday sermons and Islamic lectures</p>
        </div>

        <div class="flex gap-2 flex-wrap">
            <form action="{{ route('admin.khutbahs.sync-youtube') }}" method="POST" class="inline" onsubmit="return confirm('Sync videos from YouTube channel? This may take a moment.')">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 flex items-center gap-2">
                    <i class="fab fa-youtube"></i>
                    Sync from YouTube
                </button>
            </form>
            
            <a href="{{ route('admin.khutbahs.create') }}" 
               class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                Add New Khutbah
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Videos</p>
                    <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-video text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active Videos</p>
                    <p class="text-2xl font-bold">{{ $stats['active'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-4 rounded-lg border">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Featured Videos</p>
                    <p class="text-2xl font-bold">{{ $stats['featured'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border rounded-xl p-4 mb-6">
        <form action="{{ route('admin.khutbahs.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <select name="category" class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-[200px]">
                <select name="featured" class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">All Featured</option>
                    <option value="featured" {{ request('featured') === 'featured' ? 'selected' : '' }}>Featured Only</option>
                    <option value="not-featured" {{ request('featured') === 'not-featured' ? 'selected' : '' }}>Not Featured</option>
                </select>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                    Filter
                </button>
                <a href="{{ route('admin.khutbahs.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white border rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-4 py-3">Video</th>
                        <th class="text-left px-4 py-3">Speaker</th>
                        <th class="text-left px-4 py-3">Category</th>
                        <th class="text-left px-4 py-3">Date</th>
                        <th class="text-left px-4 py-3">Duration</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Featured</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($khutbahs as $khutbah)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-16 h-12 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($khutbah->thumbnail_url)
                                        <img src="{{ $khutbah->thumbnail_url }}" alt="Thumbnail" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-500"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $khutbah->title }}</p>
                                    <p class="text-xs text-gray-500 truncate max-w-xs">{{ $khutbah->description }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $khutbah->speaker ?? 'Not specified' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs">{{ $khutbah->category_label }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $khutbah->formatted_date }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $khutbah->formatted_duration }}</td>
                        <td class="px-4 py-3">
                            @if($khutbah->is_active)
                                <span class="px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200 text-xs">Active</span>
                            @else
                                <span class="px-2 py-1 rounded bg-red-50 text-red-700 border border-red-200 text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($khutbah->is_featured)
                                <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs">Featured</span>
                            @else
                                <span class="px-2 py-1 rounded bg-gray-50 text-gray-700 border border-gray-200 text-xs">Not Featured</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                            <a href="{{ route('admin.khutbahs.edit', $khutbah) }}"
                               class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                Edit
                            </a>
                            <form action="{{ route('admin.khutbahs.toggle-featured', $khutbah) }}" method="POST" class="inline">
                                @csrf
                                <button class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50 {{ $khutbah->is_featured ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}">
                                    {{ $khutbah->is_featured ? 'Unfeature' : 'Feature' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.khutbahs.toggle-active', $khutbah) }}" method="POST" class="inline">
                                @csrf
                                <button class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50 {{ $khutbah->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                    {{ $khutbah->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.khutbahs.destroy', $khutbah) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this khutbah?')">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50 text-red-600 border-red-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-600">
                            No khutbahs found. <a href="{{ route('admin.khutbahs.create') }}" class="text-blue-600 hover:underline">Add your first khutbah</a>.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $khutbahs->links() }}
        </div>
    </div>
</div>
@endsection