@extends('layouts.dashboard')

@section('title', 'Edit ' . $meta['label'])
@section('header', 'Edit ' . $meta['label'])

@section('content')
@php
    $isMainHeading = !empty($meta['heading_is_main']);
    $oldItems = old('items');
@endphp

<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="mb-6">
        <a href="{{ route('admin.janazah-contents.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Janazah content</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $meta['label'] }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $meta['description'] }} Edit the section title and every step below, then save once.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.janazah-contents.update-section', $sectionKey) }}" method="POST" id="bulk-section-form">
        @csrf
        @method('PUT')

        {{-- Section heading --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-700 font-bold">§</div>
                <div>
                    <h2 class="font-bold text-gray-900">Section heading</h2>
                    <p class="text-xs text-gray-500">Shown at the top of this block on the public page.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="heading_title"
                           value="{{ old('heading_title', $heading->title ?? $meta['default_title']) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                           placeholder="{{ $meta['default_title'] }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $isMainHeading ? 'Main content' : 'Subtitle / description' }}
                    </label>
                    <textarea name="heading_content" rows="{{ $isMainHeading ? 6 : 2 }}"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                              placeholder="{{ $isMainHeading ? 'Main terms text...' : ($meta['default_subtitle'] ?? '') }}">{{ old('heading_content', $heading->content ?? ($isMainHeading ? '' : ($meta['default_subtitle'] ?? ''))) }}</textarea>
                </div>

                <label class="inline-flex items-center gap-2">
                    <input type="hidden" name="heading_visible" value="0">
                    <input type="checkbox" name="heading_visible" value="1"
                           {{ old('heading_visible', $heading->is_visible ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="text-sm text-gray-700">Section visible on public page</span>
                </label>
            </div>
        </div>

        {{-- Items --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <h2 class="font-bold text-gray-900">{{ Str::plural(ucfirst($meta['item_label'])) }}</h2>
                    <p class="text-xs text-gray-500 mt-1">Add, reorder, hide, or remove steps. Changes save together.</p>
                </div>
                <button type="button" id="add-item-btn"
                        class="inline-flex items-center gap-2 bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                    + Add {{ $meta['item_label'] }}
                </button>
            </div>

            <div id="items-list" class="space-y-4">
                @php
                    $rows = $oldItems !== null ? $oldItems : $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'content' => $item->content,
                            'sort_order' => $item->sort_order,
                            'is_visible' => $item->is_visible ? '1' : '0',
                        ];
                    })->values()->all();

                    if (empty($rows)) {
                        $rows = [['id' => '', 'title' => '', 'content' => '', 'sort_order' => 1, 'is_visible' => '1']];
                    }
                @endphp

                @foreach($rows as $index => $row)
                    @include('admin.janazah-contents._item-row', [
                        'index' => $index,
                        'row' => $row,
                        'itemLabel' => $meta['item_label'],
                    ])
                @endforeach
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 sticky bottom-4 bg-white/90 backdrop-blur border border-gray-200 shadow-lg rounded-xl px-5 py-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 transition font-medium">
                Save entire section
            </button>
            <a href="{{ route('admin.janazah-contents.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">Cancel</a>
            <a href="{{ route('janazah.show') }}" target="_blank" class="text-sm text-emerald-700 hover:text-emerald-900 ml-auto">View public page ↗</a>
        </div>
    </form>
</div>

<template id="item-row-template">
    @include('admin.janazah-contents._item-row', [
        'index' => '__INDEX__',
        'row' => ['id' => '', 'title' => '', 'content' => '', 'sort_order' => '', 'is_visible' => '1'],
        'itemLabel' => $meta['item_label'],
    ])
</template>

<script>
(function () {
    const list = document.getElementById('items-list');
    const addBtn = document.getElementById('add-item-btn');
    const template = document.getElementById('item-row-template');

    function reindex() {
        Array.from(list.querySelectorAll('[data-item-row]')).forEach((row, i) => {
            row.querySelectorAll('[name]').forEach((el) => {
                el.name = el.name.replace(/items\[(?:\d+|__INDEX__)\]/g, 'items[' + i + ']');
            });
            const badge = row.querySelector('[data-step-number]');
            if (badge) badge.textContent = i + 1;
            const sort = row.querySelector('[data-sort-order]');
            if (sort && (!sort.value || sort.dataset.auto === '1')) {
                sort.value = i + 1;
                sort.dataset.auto = '1';
            }
        });
    }

    addBtn?.addEventListener('click', () => {
        const html = template.innerHTML.replace(/__INDEX__/g, String(list.querySelectorAll('[data-item-row]').length));
        const wrap = document.createElement('div');
        wrap.innerHTML = html.trim();
        const node = wrap.firstElementChild;
        list.appendChild(node);
        reindex();
        node.querySelector('input[name*="[title]"]')?.focus();
    });

    list?.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-remove-row]');
        if (!btn) return;
        const row = btn.closest('[data-item-row]');
        const idInput = row.querySelector('input[name*="[id]"]');
        const deleteInput = row.querySelector('input[name*="[delete]"]');

        if (idInput && idInput.value) {
            // Existing row: mark for deletion and hide
            if (deleteInput) deleteInput.value = '1';
            row.classList.add('opacity-50', 'pointer-events-none');
            row.style.display = 'none';
        } else {
            row.remove();
        }
        reindex();
    });

    list?.addEventListener('input', (e) => {
        if (e.target.matches('[data-sort-order]')) {
            e.target.dataset.auto = '0';
        }
    });
})();
</script>
@endsection
