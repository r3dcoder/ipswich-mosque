@extends('layouts.dashboard')

@section('title', 'Edit Page')
@section('header', 'Edit Page')

@section('content')
<div class="max-w-5xl">
    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Page settings --}}
    <form action="{{ route('admin.pages.update', $page) }}" method="POST"
          class="bg-white border rounded-xl p-6 space-y-5 mb-6">
        @csrf
        @method('PUT')

        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
                <h2 class="text-lg font-semibold">Page Settings</h2>
                <p class="text-sm text-gray-600">URL: <span class="font-mono">/{{ $page->slug }}</span></p>
            </div>

            <a href="{{ url('/'.$page->slug) }}" target="_blank"
               class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">
                View Page
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input name="title" value="{{ old('title', $page->title) }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Slug</label>
                <input name="slug" value="{{ old('slug', $page->slug) }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Excerpt</label>
            <textarea name="excerpt" rows="2"
                      class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('excerpt', $page->excerpt) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                <input name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>

            <div class="flex items-center gap-2 pt-7">
                <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300"
                       {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                <span class="text-sm text-gray-700">Published</span>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Meta Description</label>
            <textarea name="meta_description" rows="2"
                      class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('meta_description', $page->meta_description) }}</textarea>
        </div>

        <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
            Save Page Settings
        </button>
    </form>

    {{-- Add block --}}
    <div class="bg-white border rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
                <h2 class="text-lg font-semibold">Blocks</h2>
                <p class="text-sm text-gray-600">Add blocks like Hero, Text, Download, Image, Lists, Eid Jamaat etc.</p>
            </div>

            <form action="{{ route('admin.pages.blocks.store', $page) }}" method="POST" class="flex gap-2">
                @csrf
                <select name="type" class="rounded-lg border-gray-300 text-sm">
                    <option value="hero">Hero</option>
                    <option value="rich_text">Rich Text</option>
                    <option value="download">Download (PDF/File)</option>
                    <option value="image">Image</option>
                    <option value="repeater">List (Bullets)</option>
                    <option value="eid_times">Eid Jamaat Times</option>
                </select>
                <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                    + Add Block
                </button>
            </form>
        </div>
    </div>

    {{-- Blocks list (drag-drop) --}}
    <div class="space-y-4" id="blocksList">
        @forelse($page->blocks as $block)
            <div class="bg-white border rounded-xl overflow-hidden" data-block-id="{{ $block->id }}">
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b">
                    <div class="flex items-center gap-3">
                        <button type="button"
                                class="cursor-move px-2 py-1 rounded border text-xs bg-white"
                                title="Drag to reorder">
                            ☰
                        </button>
                        <div class="font-semibold text-gray-900">
                            {{ strtoupper(str_replace('_',' ', $block->type)) }}
                        </div>
                        <div class="text-xs text-gray-500">#{{ $block->id }}</div>
                    </div>

                    <form action="{{ route('admin.pages.blocks.destroy', [$page, $block]) }}" method="POST"
                          onsubmit="return confirm('Delete this block?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                            Delete
                        </button>
                    </form>
                </div>

                <div class="p-4">
                    @includeIf('admin.pages.blocks.forms.'.$block->type, ['page' => $page, 'block' => $block])
                </div>
            </div>
        @empty
            <div class="bg-white border rounded-xl p-8 text-center text-gray-600">
                No blocks yet. Add one from above.
            </div>
        @endforelse
    </div>
</div>

{{-- Drag + Drop reorder (Vanilla JS) --}}
<script>
(function () {
    const list = document.getElementById('blocksList');
    if (!list) return;

    let draggingEl = null;

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('[data-block-id]:not(.dragging)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    // Make all blocks draggable
    list.querySelectorAll('[data-block-id]').forEach(card => {
        card.setAttribute('draggable', 'true');

        card.addEventListener('dragstart', () => {
            draggingEl = card;
            card.classList.add('dragging');
        });

        card.addEventListener('dragend', () => {
            card.classList.remove('dragging');
            draggingEl = null;
            saveOrder();
        });
    });

    list.addEventListener('dragover', e => {
        e.preventDefault();
        const afterEl = getDragAfterElement(list, e.clientY);
        const dragging = list.querySelector('.dragging');
        if (!dragging) return;

        if (afterEl == null) {
            list.appendChild(dragging);
        } else {
            list.insertBefore(dragging, afterEl);
        }
    });

    async function saveOrder() {
        const ids = [...list.querySelectorAll('[data-block-id]')].map(el => parseInt(el.dataset.blockId, 10));

        try {
            await fetch("{{ route('admin.pages.blocks.reorder', $page) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order: ids })
            });
        } catch (e) {
            console.error(e);
        }
    }
})();
</script>
@endsection
