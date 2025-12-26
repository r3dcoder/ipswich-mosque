@extends('layouts.dashboard')

@section('title', 'Courses')
@section('header', 'Courses')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold">Course Sections</h2>
            <p class="text-sm text-gray-600">Manage Quran Education section per page.</p>
        </div>

        <a href="{{ route('admin.courses.create') }}"
            class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
            + Create Section
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border rounded-xl overflow-hidden w-full">
        <div class="overflow-x-auto w-full">
            <table class="min-w-full w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-4 py-3">Page</th>
                        <th class="text-left px-4 py-3">Slug</th>
                        <th class="text-left px-4 py-3">Title</th>
                        <th class="text-left px-4 py-3">Order</th>
                        <th class="text-left px-4 py-3">Active</th>
                        <th class="text-right px-4 py-3">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($sections as $s)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $s->page }}</td>
                            <td class="px-4 py-3">{{ $s->slug }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $s->title }}</div>
                                @if($s->subtitle)
                                    <div class="text-xs text-gray-500">{{ $s->subtitle }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $s->sort_order }}</td>
                            <td class="px-4 py-3">
                                @if($s->is_active)
                                    <span class="px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200">Yes</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-gray-50 text-gray-600 border">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.courses.edit', $s) }}"
                                    class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                    Manage
                                </a>

                                <form method="POST" action="{{ route('admin.courses.destroy', $s) }}" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this course section? This will remove ALL courses and features.')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 text-sm hover:bg-red-50">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-600">
                                No course sections yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $sections->links() }}
        </div>
    </div>
@endsection