@extends('layouts.dashboard')

@section('title', 'Dua Categories')
@section('header', 'Dua Categories')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Categories</h2>
        <p class="text-sm text-gray-600">Manage Dua categories.</p>
    </div>

    <a href="{{ route('admin.dua_categories.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + Add Category
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
                <th class="text-left px-4 py-3">Name</th>
                <th class="text-left px-4 py-3">Category</th>
                <th class="text-left px-4 py-3">Duas</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @forelse($categories as $c)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $c->name }}</td>
                    <td class="px-4 py-3">{{ $c->category ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $c->duas_count }}</td>
                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.dua_categories.edit', $c) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.dua_categories.destroy', $c) }}"
                              class="inline" onsubmit="return confirm('Delete this category? All duas inside will be deleted too.')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-600">No categories yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
