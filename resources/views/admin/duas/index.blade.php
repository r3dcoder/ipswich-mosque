@extends('layouts.dashboard')

@section('title', 'Duas')
@section('header', 'Duas')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Duas</h2>
        <p class="text-sm text-gray-600">Manage Dua content.</p>
    </div>

    <a href="{{ route('admin.duas.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + Add Dua
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

{{-- Filters --}}
<form class="bg-white border rounded-xl p-4 mb-4 flex flex-col md:flex-row gap-3 md:items-end">
    <div class="flex-1">
        <label class="block text-sm font-medium mb-1">Search</label>
        <input name="q" value="{{ $q }}" placeholder="title / keywords"
               class="w-full rounded-lg border-gray-300">
    </div>

    <div class="md:w-72">
        <label class="block text-sm font-medium mb-1">Category</label>
        <select name="category" class="w-full rounded-lg border-gray-300">
            <option value="">All</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected((string)$categoryId === (string)$c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Filter</button>
        <a href="{{ route('admin.duas.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Reset</a>
    </div>
</form>

<div class="bg-white border rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3">Title</th>
                <th class="text-left px-4 py-3">Category</th>
                <th class="text-left px-4 py-3">Keywords</th>
                <th class="text-right px-4 py-3">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y">
            @forelse($duas as $d)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $d->title }}</td>
                    <td class="px-4 py-3">{{ $d->category?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $d->keywords ?? '—' }}</td>
                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.duas.edit', $d) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.duas.destroy', $d) }}"
                              class="inline" onsubmit="return confirm('Delete this dua?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-600">No duas yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $duas->links() }}
    </div>
</div>
@endsection
