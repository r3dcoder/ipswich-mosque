@extends('layouts.dashboard')

@section('title', 'Janazah Page Content')
@section('header', 'Janazah Page Content')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Janazah Page Content</h1>
            <p class="text-sm text-gray-500 mt-1">Edit whole page sections together, or manage individual blocks.</p>
        </div>
        <a href="{{ route('admin.janazah-contents.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            + Add Single Block
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Quick section editors --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Edit by section</h2>
        <p class="text-sm text-gray-500 mb-4">Click a section to edit its title and all steps on one page.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            {{-- Hero card --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex flex-col">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Intro</p>
                        <h3 class="font-bold text-gray-900 mt-1">Hero / Intro</h3>
                    </div>
                    <span class="text-2xl">🕌</span>
                </div>
                <p class="text-sm text-gray-500 flex-1 mb-4">
                    {{ $hero?->title ? Str::limit($hero->title, 60) : 'Main page title and introduction text.' }}
                </p>
                @if($hero)
                    <a href="{{ route('admin.janazah-contents.edit', $hero->id) }}"
                       class="inline-flex items-center justify-center gap-2 bg-slate-900 text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-emerald-700 transition">
                        Edit hero content
                    </a>
                @else
                    <a href="{{ route('admin.janazah-contents.create') }}?section=hero"
                       class="inline-flex items-center justify-center gap-2 bg-green-600 text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-green-700 transition">
                        Create hero content
                    </a>
                @endif
            </div>

            @foreach($bulkSections as $key => $meta)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 flex flex-col hover:border-emerald-300 transition">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Section</p>
                            <h3 class="font-bold text-gray-900 mt-1">{{ $meta['label'] }}</h3>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-800 text-xs font-semibold px-2.5 py-1 border border-emerald-100">
                            {{ $bulkStats[$key]['item_count'] }} {{ Str::plural('item', $bulkStats[$key]['item_count']) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 flex-1 mb-4">{{ $meta['description'] }}</p>
                    <a href="{{ route('admin.janazah-contents.edit-section', $key) }}"
                       class="inline-flex items-center justify-center gap-2 bg-slate-900 text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-emerald-700 transition">
                        Edit all together
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Section filter --}}
    <div class="bg-white rounded-lg shadow p-4 mb-4">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Filter by Section</label>
                <select name="section" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">All blocks</option>
                    @foreach($sections as $key => $label)
                        <option value="{{ $key }}" {{ request('section') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition text-sm">Filter</button>
            @if(request('section'))
                <a href="{{ route('admin.janazah-contents.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Clear</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">All content blocks</h2>
            <p class="text-xs text-gray-500 mt-1">Advanced: edit a single block if needed. Prefer “Edit all together” for rites and prayer steps.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title / Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contents as $content)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $content->sort_order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    {{ $content->section_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $content->title ?: '—' }}</div>
                                @if($content->content)
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($content->content, 80) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($content->is_visible)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Visible</span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Hidden</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('admin.janazah-contents.toggle-visible', $content->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-amber-600 hover:text-amber-900 mr-3">
                                        {{ $content->is_visible ? 'Hide' : 'Show' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.janazah-contents.edit', $content->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.janazah-contents.destroy', $content->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this content block?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No content blocks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
