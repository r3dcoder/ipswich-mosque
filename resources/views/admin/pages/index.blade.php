@extends('layouts.dashboard')

@section('title', 'Pages')
@section('header', 'Pages')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold">Pages</h2>
        <p class="text-sm text-gray-600">Create dynamic pages like Ramadan, Nikah, Janazah, Visiting Us.</p>
    </div>

    <a href="{{ route('admin.pages.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + New Page
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
                    <th class="text-left px-4 py-3">Title</th>
                    <th class="text-left px-4 py-3">Slug</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
            @forelse($pages as $page)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $page->title }}</td>
                    <td class="px-4 py-3 text-gray-600">/{{ $page->slug }}</td>
                    <td class="px-4 py-3">
                        @if($page->is_published)
                            <span class="px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200">Published</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-50 text-gray-600 border">Draft</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ url('/'.$page->slug) }}" target="_blank"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            View
                        </a>

                        <a href="{{ route('admin.pages.edit', $page) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>

                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this page?')">
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
                    <td colspan="4" class="px-4 py-8 text-center text-gray-600">
                        No pages yet. Click “New Page”.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $pages->links() }}
    </div>
</div>
@endsection
