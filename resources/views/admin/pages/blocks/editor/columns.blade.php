@php
    use App\Models\PageBlock;

    $heading = (string) ($data['heading'] ?? '');
    $count = (int) ($data['count'] ?? 2);
    $layout = (string) ($data['layout'] ?? '50-50');
    $gap = (string) ($data['gap'] ?? 'md');
    $align = (string) ($data['vertical_align'] ?? 'top');
    $stack = (bool) ($data['stack_on_mobile'] ?? true);

    $items = array_values(array_filter((array) ($data['items'] ?? []), 'is_array'));

    $layoutConfig = [
        2 => PageBlock::columnLayouts(2),
        3 => PageBlock::columnLayouts(3),
        4 => PageBlock::columnLayouts(4),
    ];

    $selectClass = 'w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent';
@endphp

<form id="columnsEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Section heading (optional)</label>
        <input type="text" name="heading" value="{{ $heading }}" class="{{ $selectClass }}" placeholder="e.g. Our Services">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Number of columns</label>
        <div class="grid grid-cols-3 gap-2">
            @foreach(PageBlock::columnCounts() as $option)
                <label class="relative cursor-pointer">
                    <input type="radio" name="count" value="{{ $option }}" class="peer sr-only pb-count"
                           {{ $count === $option ? 'checked' : '' }} onchange="updateColumnsLayout()">
                    <div class="border rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                        <div class="text-lg mb-1">{{ $option === 2 ? '▐▌' : ($option === 3 ? '▐▐▌' : '▐▐▐▌') }}</div>
                        <div class="text-xs font-medium">{{ $option }} columns</div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Column widths</label>
        <select name="layout" id="columnsLayout" class="{{ $selectClass }}"></select>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gap</label>
            <select name="gap" class="{{ $selectClass }}">
                @foreach(['none' => 'None', 'sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large'] as $value => $label)
                    <option value="{{ $value }}" {{ $gap === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Vertical align</label>
            <select name="vertical_align" class="{{ $selectClass }}">
                @foreach(['top' => 'Top', 'center' => 'Center', 'bottom' => 'Bottom', 'stretch' => 'Stretch'] as $value => $label)
                    <option value="{{ $value }}" {{ $align === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-700">
        <input type="checkbox" name="stack_on_mobile" value="1" {{ $stack ? 'checked' : '' }} class="rounded">
        Stack columns on mobile
    </label>

    <div class="border-t pt-4 space-y-4">
        <p class="text-xs text-gray-500">
            Each column has its own rich text editor and optional image.
        </p>

        @for($i = 0; $i < 4; $i++)
            @php
                $item = $items[$i] ?? ['html' => '', 'image_path' => '', 'image_alt' => '', 'image_position' => 'top'];
            @endphp
            <div class="pb-col-card border rounded-lg p-3 space-y-3 {{ $i >= $count ? 'hidden' : '' }}" data-col-index="{{ $i }}">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-800">Column {{ $i + 1 }}</span>
                    <span class="text-xs text-gray-500 pb-col-width"></span>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-medium text-gray-600">Column image (optional)</label>

                    <div class="pb-col-preview border rounded-lg bg-gray-50 p-2 flex items-center justify-center min-h-[60px]">
                        @if(!empty($item['image_path']))
                            <img src="{{ $item['image_path'] }}" alt="" class="max-h-24 object-contain rounded">
                        @else
                            <span class="text-xs text-gray-400 italic">No image</span>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <label class="flex-1 text-center px-2 py-1.5 border rounded-lg text-xs cursor-pointer hover:bg-gray-50">
                            📤 Upload image
                            <input type="file" accept="image/*" class="hidden pb-col-file">
                        </label>
                        <button type="button" class="px-2 py-1.5 border rounded-lg text-xs text-red-600 hover:bg-red-50 pb-col-remove">
                            Remove
                        </button>
                    </div>

                    <input type="text" class="w-full border rounded-lg px-2 py-1.5 text-xs pb-col-image"
                           value="{{ $item['image_path'] ?? '' }}" placeholder="Or paste an image URL">
                    <input type="text" class="w-full border rounded-lg px-2 py-1.5 text-xs pb-col-alt"
                           value="{{ $item['image_alt'] ?? '' }}" placeholder="Alt text (accessibility)">
                    <select class="w-full border rounded-lg px-2 py-1.5 text-xs pb-col-position">
                        @foreach(['top' => 'Image above text', 'bottom' => 'Image below text', 'left' => 'Image left of text', 'right' => 'Image right of text'] as $value => $label)
                            <option value="{{ $value }}" {{ ($item['image_position'] ?? 'top') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Column content</label>
                    <div class="pb-col-editor"></div>
                    <textarea class="hidden pb-col-source">{{ $item['html'] ?? '' }}</textarea>
                </div>
            </div>
        @endfor
    </div>

    <button type="button" onclick="saveThisBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

<script>
window.PB_COLUMN_LAYOUTS = @json($layoutConfig);
window.PB_ACTIVE_LAYOUT = @json($layout);
</script>

<script>
// Wait for the TipTap bundle (loaded on the builder page) to be ready
function whenEditorReady(callback) {
    if (window.PageBuilderEditor) { callback(); return; }

    let tries = 0;
    const timer = setInterval(function () {
        tries++;
        if (window.PageBuilderEditor) {
            clearInterval(timer);
            callback();
        } else if (tries > 100) {
            clearInterval(timer);
            if (typeof window.showNotification === 'function') {
                window.showNotification('Editor failed to load - please refresh the page', 'error');
            }
        }
    }, 50);
}

function columnsForm() {
    return document.getElementById('columnsEditorForm');
}

function selectedCount() {
    const checked = columnsForm().querySelector('input[name="count"]:checked');
    return checked ? parseInt(checked.value, 10) : 2;
}

/** Rebuild the width dropdown + show/hide column cards for the chosen count */
window.updateColumnsLayout = function () {
    const count = selectedCount();
    const layouts = window.PB_COLUMN_LAYOUTS[count] || {};
    const select = document.getElementById('columnsLayout');
    const keys = Object.keys(layouts);
    const current = select.value;

    select.innerHTML = '';
    keys.forEach(function (key) {
        const option = document.createElement('option');
        option.value = key;
        option.textContent = key.replace(/-/g, ' / ') + '%';
        select.appendChild(option);
    });

    select.value = keys.indexOf(current) !== -1 ? current : keys[0];

    columnsForm().querySelectorAll('.pb-col-card').forEach(function (card) {
        const index = parseInt(card.dataset.colIndex, 10);
        card.classList.toggle('hidden', index >= count);
    });

    window.updateColumnWidthLabels();
};

/** Show each column's resolved width next to its heading */
window.updateColumnWidthLabels = function () {
    const count = selectedCount();
    const layout = document.getElementById('columnsLayout').value;
    const widths = (window.PB_COLUMN_LAYOUTS[count] || {})[layout] || [];

    columnsForm().querySelectorAll('.pb-col-card').forEach(function (card) {
        const index = parseInt(card.dataset.colIndex, 10);
        const label = card.querySelector('.pb-col-width');
        if (label) label.textContent = widths[index] ? 'Width: ' + widths[index] : '';
    });
};

function setColumnPreview(card, url) {
    const preview = card.querySelector('.pb-col-preview');
    preview.innerHTML = url
        ? '<img src="' + url + '" alt="" class="max-h-24 object-contain rounded">'
        : '<span class="text-xs text-gray-400 italic">No image</span>';
}

window.initColumnsEditor = function () {
    const form = columnsForm();
    if (!form || form.dataset.ready === '1') return;
    form.dataset.ready = '1';

    window.updateColumnsLayout();

    document.getElementById('columnsLayout').addEventListener('change', window.updateColumnWidthLabels);

    // Per-column image upload / removal / URL typing
    form.querySelectorAll('.pb-col-card').forEach(function (card) {
        const fileInput = card.querySelector('.pb-col-file');
        const urlInput = card.querySelector('.pb-col-image');

        fileInput.addEventListener('change', function () {
            const file = fileInput.files && fileInput.files[0];
            if (!file) return;

            whenEditorReady(function () {
                window.PageBuilderEditor.uploadImage(file)
                    .then(function (url) {
                        urlInput.value = url;
                        setColumnPreview(card, url);
                        window.showNotification('Image uploaded');
                    })
                    .catch(function (err) {
                        window.showNotification(err.message || 'Image upload failed', 'error');
                    })
                    .finally(function () {
                        fileInput.value = '';
                    });
            });
        });

        card.querySelector('.pb-col-remove').addEventListener('click', function () {
            urlInput.value = '';
            setColumnPreview(card, '');
        });

        urlInput.addEventListener('input', function () {
            setColumnPreview(card, urlInput.value.trim());
        });
    });

    // One TipTap editor per column
    whenEditorReady(function () {
        form.querySelectorAll('.pb-col-card').forEach(function (card) {
            const mount = card.querySelector('.pb-col-editor');
            const source = card.querySelector('.pb-col-source');

            window.PageBuilderEditor.create(mount, {
                html: source ? source.value : '',
                placeholder: 'Column content...',
                minHeight: '140px',
                maxHeight: '320px'
            });
        });
    });
};

function saveThisBlock() {
    const form = columnsForm();
    const count = selectedCount();
    const items = [];

    form.querySelectorAll('.pb-col-card').forEach(function (card) {
        const index = parseInt(card.dataset.colIndex, 10);
        if (index >= count) return;

        const mount = card.querySelector('.pb-col-editor');

        items.push({
            html: window.PageBuilderEditor ? window.PageBuilderEditor.getHtml(mount) : '',
            image_path: card.querySelector('.pb-col-image').value.trim(),
            image_alt: card.querySelector('.pb-col-alt').value.trim(),
            image_position: card.querySelector('.pb-col-position').value
        });
    });

    const data = {
        heading: form.querySelector('input[name="heading"]').value,
        count: count,
        layout: document.getElementById('columnsLayout').value,
        gap: form.querySelector('select[name="gap"]').value,
        vertical_align: form.querySelector('select[name="vertical_align"]').value,
        stack_on_mobile: !!form.querySelector('input[name="stack_on_mobile"]').checked,
        items: items
    };

    fetch('/admin/pages/{{ $page->id }}/blocks/' + window.selectedBlockId + '?_method=PUT', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ data: data })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            window.showNotification('Block saved!');
            window.refreshBlockPreview(window.selectedBlockId);
        }
    })
    .catch(error => {
        window.showNotification('Error saving block', 'error');
    });
}

window.initColumnsEditor();
</script>

