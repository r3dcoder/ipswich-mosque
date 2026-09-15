@php
    $image = (string) ($data['image_path'] ?? '');
    $alt = (string) ($data['image_alt'] ?? '');
    $position = ($data['image_position'] ?? 'left') === 'right' ? 'right' : 'left';
    $width = (int) ($data['image_width'] ?? 45);
    $align = (string) ($data['vertical_align'] ?? 'center');
    $rounded = (bool) ($data['rounded'] ?? true);
    $gap = (string) ($data['gap'] ?? 'md');
    $html = (string) ($data['html'] ?? '');

    $selectClass = 'w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent';
@endphp

<form id="imageTextEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>

        <div id="imageTextPreview" class="border rounded-lg bg-gray-50 p-2 flex items-center justify-center min-h-[90px] mb-2">
            @if($image !== '')
                <img src="{{ $image }}" alt="" class="max-h-32 object-contain rounded">
            @else
                <span class="text-xs text-gray-400 italic">No image</span>
            @endif
        </div>

        <div class="flex gap-2 mb-2">
            <label class="flex-1 text-center px-2 py-1.5 border rounded-lg text-xs cursor-pointer hover:bg-gray-50">
                📤 Upload image
                <input type="file" id="imageTextFile" accept="image/*" class="hidden">
            </label>
            <button type="button" id="imageTextRemove" class="px-2 py-1.5 border rounded-lg text-xs text-red-600 hover:bg-red-50">
                Remove
            </button>
        </div>

        <input type="text" id="imageTextPath" value="{{ $image }}" class="{{ $selectClass }} mb-2"
               placeholder="Or paste an image URL">
        <input type="text" name="image_alt" value="{{ $alt }}" class="{{ $selectClass }}"
               placeholder="Alt text (accessibility)">
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image side</label>
            <select name="image_position" class="{{ $selectClass }}">
                <option value="left" {{ $position === 'left' ? 'selected' : '' }}>Left</option>
                <option value="right" {{ $position === 'right' ? 'selected' : '' }}>Right</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Vertical align</label>
            <select name="vertical_align" class="{{ $selectClass }}">
                @foreach(['top' => 'Top', 'center' => 'Center', 'bottom' => 'Bottom'] as $value => $label)
                    <option value="{{ $value }}" {{ $align === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Image width: <span id="imageTextWidthLabel">{{ $width }}</span>%
        </label>
        <input type="range" name="image_width" id="imageTextWidth" min="20" max="70" step="5" value="{{ $width }}"
               class="w-full">
        <p class="text-xs text-gray-500 mt-1">The text takes the remaining space.</p>
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
        <div class="flex items-end pb-2">
            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="rounded" value="1" {{ $rounded ? 'checked' : '' }} class="rounded">
                Rounded corners
            </label>
        </div>
    </div>

    <div class="border-t pt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Text content</label>
        <div id="imageTextTipTap"></div>
        <textarea id="imageTextSource" class="hidden">{{ $html }}</textarea>
    </div>

    <button type="button" onclick="saveThisBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

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

function imageTextForm() {
    return document.getElementById('imageTextEditorForm');
}

function setImageTextPreview(url) {
    document.getElementById('imageTextPreview').innerHTML = url
        ? '<img src="' + url + '" alt="" class="max-h-32 object-contain rounded">'
        : '<span class="text-xs text-gray-400 italic">No image</span>';
}

window.initImageTextEditor = function () {
    const form = imageTextForm();
    if (!form || form.dataset.ready === '1') return;
    form.dataset.ready = '1';

    const pathInput = document.getElementById('imageTextPath');
    const fileInput = document.getElementById('imageTextFile');
    const widthInput = document.getElementById('imageTextWidth');
    const widthLabel = document.getElementById('imageTextWidthLabel');

    fileInput.addEventListener('change', function () {
        const file = fileInput.files && fileInput.files[0];
        if (!file) return;

        whenEditorReady(function () {
            window.PageBuilderEditor.uploadImage(file)
                .then(function (url) {
                    pathInput.value = url;
                    setImageTextPreview(url);
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

    document.getElementById('imageTextRemove').addEventListener('click', function () {
        pathInput.value = '';
        setImageTextPreview('');
    });

    pathInput.addEventListener('input', function () {
        setImageTextPreview(pathInput.value.trim());
    });

    widthInput.addEventListener('input', function () {
        widthLabel.textContent = widthInput.value;
    });

    whenEditorReady(function () {
        const source = document.getElementById('imageTextSource');

        window.PageBuilderEditor.create(document.getElementById('imageTextTipTap'), {
            html: source ? source.value : '',
            placeholder: 'Write the text that sits beside the image...',
            minHeight: '180px'
        });
    });
};

function saveThisBlock() {
    const form = imageTextForm();

    const data = {
        image_path: document.getElementById('imageTextPath').value.trim(),
        image_alt: form.querySelector('input[name="image_alt"]').value,
        image_position: form.querySelector('select[name="image_position"]').value,
        image_width: document.getElementById('imageTextWidth').value,
        vertical_align: form.querySelector('select[name="vertical_align"]').value,
        gap: form.querySelector('select[name="gap"]').value,
        rounded: !!form.querySelector('input[name="rounded"]').checked,
        html: window.PageBuilderEditor
            ? window.PageBuilderEditor.getHtml('#imageTextTipTap')
            : (document.getElementById('imageTextSource') || {}).value || ''
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

window.initImageTextEditor();
</script>

