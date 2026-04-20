@extends('layouts.dashboard')

@section('title', 'Notice Board')
@section('header', 'Notice Board')

@section('content')
<div class="max-w-7xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Notices</h2>
            <p class="text-sm text-gray-600 mt-1">Manage mosque announcements and notices</p>
        </div>
        <a href="{{ route('admin.notices.create') }}" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Notice
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
        <form method="GET" action="{{ route('admin.notices.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search notices..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="w-40">
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Notice::CATEGORIES as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">Filter</button>
            <a href="{{ route('admin.notices.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Clear</a>
        </form>
    </div>

    <!-- Notices List -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        @if($notices->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($notices as $notice)
                            <tr class="hover:bg-gray-50 {{ $notice->is_pinned ? 'bg-yellow-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if($notice->is_pinned)
                                            <span class="text-yellow-500" title="Pinned">📌</span>
                                        @endif
                                        @if($notice->is_active)
                                            <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Active</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">Inactive</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $notice->title }}</div>
                                    @if($notice->summary)
                                        <div class="text-sm text-gray-500 truncate max-w-md">{{ $notice->summary }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($notice->category == 'urgent') bg-red-100 text-red-700
                                        @elseif($notice->category == 'event') bg-blue-100 text-blue-700
                                        @elseif($notice->category == 'prayer') bg-emerald-100 text-emerald-700
                                        @elseif($notice->category == 'announcement') bg-purple-100 text-purple-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $notice->category_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $notice->published_at ? $notice->published_at->format('M d, Y') : 'Not published' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $notice->view_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.notices.edit', $notice) }}" class="text-emerald-600 hover:text-emerald-900">Edit</a>
                                        <form method="POST" action="{{ route('admin.notices.toggle-pin', $notice) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                {{ $notice->is_pinned ? 'Unpin' : 'Pin' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $notices->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No notices found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new notice.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.notices.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Create Notice
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection