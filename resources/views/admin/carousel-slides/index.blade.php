@extends('layouts.dashboard')
@section('title','Carousel Slides')
@section('header','Carousel Slides')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Carousel Slides</h2>
        <p class="text-sm text-gray-600">Manage slides by page and order.</p>
    </div>

    <a href="{{ route('admin.carousel-slides.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 whitespace-nowrap">
        + Add Slide
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm table-fixed">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="w-[90px] text-left px-4 py-3">Image</th>
                <th class="w-1/6 text-left px-4 py-3">Page</th>
                <th class="w-2/6 text-left px-4 py-3">Title</th>
                <th class="w-1/6 text-left px-4 py-3">Order</th>
                <th class="w-1/6 text-left px-4 py-3">Active</th>
                <th class="w-[180px] text-right px-4 py-3 whitespace-nowrap">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @forelse($slides as $s)
                <tr>
                    <td class="px-4 py-3 max-h-10 max-w-16 overflow-hidden">
                        <img class="h-10 w-16 object-cover rounded"
                             src="{{ asset('storage/'.$s->image_path) }}" alt="">
                    </td>
                    <td class="px-4 py-3">{{ $s->page }}</td>
                    <td class="px-4 py-3 truncate">
                        <div class="font-medium">{{ $s->title }}</div>
                        @if($s->subtitle)<div class="text-gray-500">{{ $s->subtitle }}</div>@endif
                    </td>
                    <td class="px-4 py-3">{{ $s->sort_order }}</td>
                    <td class="px-4 py-3">
                        @if($s->is_active)
                            <span class="inline-flex px-2 py-1 rounded bg-green-50 text-green-700 border border-green-200">Yes</span>
                        @else
                            <span class="inline-flex px-2 py-1 rounded bg-gray-50 text-gray-600 border">No</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.carousel-slides.edit', $s) }}"
                               class="inline-flex items-center px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.carousel-slides.destroy', $s) }}"
                                  onsubmit="return confirm('Delete this slide?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex items-center px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-600">No slides yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">{{ $slides->links() }}</div>
</div>
@endsection
