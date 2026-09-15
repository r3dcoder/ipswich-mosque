@php
    $index = $index ?? 0;
    $row = $row ?? [];
    $itemLabel = $itemLabel ?? 'Item';
    $id = $row['id'] ?? '';
    $title = $row['title'] ?? '';
    $content = $row['content'] ?? '';
    $sortOrder = $row['sort_order'] ?? '';
    $isVisible = ($row['is_visible'] ?? '1') == '1' || ($row['is_visible'] ?? true) === true;
@endphp

<div data-item-row class="rounded-xl border border-gray-200 bg-slate-50/70 p-4 md:p-5">
    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $id }}">
    <input type="hidden" name="items[{{ $index }}][delete]" value="0">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-3">
            <span data-step-number class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-emerald-100 text-emerald-800 font-bold text-sm">
                {{ is_numeric($index) ? ((int) $index + 1) : '•' }}
            </span>
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ $itemLabel }}</p>
                <p class="text-xs text-gray-400">{{ $id ? 'ID #' . $id : 'New item' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="hidden" name="items[{{ $index }}][is_visible]" value="0">
                <input type="checkbox" name="items[{{ $index }}][is_visible]" value="1"
                       {{ $isVisible ? 'checked' : '' }}
                       class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                Visible
            </label>
            <button type="button" data-remove-row class="text-sm text-red-600 hover:text-red-800 font-medium">
                Remove
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="items[{{ $index }}][title]" value="{{ $title }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500"
                   placeholder="e.g. Ghusl">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Order</label>
            <input type="number" min="0" data-sort-order data-auto="{{ $sortOrder === '' ? '1' : '0' }}"
                   name="items[{{ $index }}][sort_order]" value="{{ $sortOrder }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div class="md:col-span-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea name="items[{{ $index }}][content]" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500"
                      placeholder="Description or dua text...">{{ $content }}</textarea>
        </div>
    </div>
</div>
