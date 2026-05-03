<form id="repeaterEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" value="{{ $data['title'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="List title...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Style</label>
        <div class="grid grid-cols-3 gap-2">
            <label class="relative cursor-pointer">
                <input type="radio" name="style" value="bullet" {{ ($data['style'] ?? 'bullet') === 'bullet' ? 'checked' : '' }}
                       class="peer sr-only" onchange="updateRepeaterPreview()">
                <div class="border rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                    <div class="text-lg mb-1">•</div>
                    <div class="text-xs font-medium">Bullet</div>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" name="style" value="numbered" {{ ($data['style'] ?? '') === 'numbered' ? 'checked' : '' }}
                       class="peer sr-only" onchange="updateRepeaterPreview()">
                <div class="border rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                    <div class="text-lg mb-1">1.</div>
                    <div class="text-xs font-medium">Numbered</div>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" name="style" value="checklist" {{ ($data['style'] ?? '') === 'checklist' ? 'checked' : '' }}
                       class="peer sr-only" onchange="updateRepeaterPreview()">
                <div class="border rounded-lg p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                    <div class="text-lg mb-1">✓</div>
                    <div class="text-xs font-medium">Checklist</div>
                </div>
            </label>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Items</label>
        <div id="repeaterItems" class="space-y-2">
            @foreach(($data['items'] ?? []) as $index => $item)
                <div class="flex items-center gap-2 repeater-item">
                    <input type="text" name="items[]" value="{{ $item }}"
                           class="flex-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="List item..."
                           oninput="updateRepeaterPreview()">
                    <button type="button" onclick="removeRepeaterItem(this)"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" onclick="addRepeaterItem()"
                class="mt-3 w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-sm text-gray-500 hover:border-blue-500 hover:text-blue-500 transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Item
        </button>
    </div>

    <!-- Live Preview -->
    <div class="border-t pt-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
        <div id="repeaterPreview" class="border rounded-lg p-3 bg-gray-50 min-h-[60px]">
            <!-- Preview will be rendered here -->
        </div>
    </div>

    <button type="button" onclick="saveRepeaterBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

<script>
window.addRepeaterItem = function() {
    const container = document.getElementById('repeaterItems');
    const itemDiv = document.createElement('div');
    itemDiv.className = 'flex items-center gap-2 repeater-item';
    itemDiv.innerHTML = `
        <input type="text" name="items[]" value=""
               class="flex-1 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="List item..."
               oninput="updateRepeaterPreview()">
        <button type="button" onclick="removeRepeaterItem(this)"
                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;
    container.appendChild(itemDiv);
    updateRepeaterPreview();
};

window.removeRepeaterItem = function(btn) {
    btn.parentElement.remove();
    updateRepeaterPreview();
};

window.updateRepeaterPreview = function() {
    const items = [];
    document.querySelectorAll('#repeaterItems input[name="items[]"]').forEach(input => {
        if (input.value.trim()) {
            items.push(input.value.trim());
        }
    });

    const style = document.querySelector('input[name="style"]:checked')?.value || 'bullet';
    const title = document.querySelector('input[name="title"]').value;

    let html = '';
    if (title) {
        html += `<h4 class="font-semibold text-gray-900 mb-2">${title}</h4>`;
    }

    if (items.length > 0) {
        if (style === 'bullet') {
            html += '<ul class="list-disc list-inside space-y-1 text-sm text-gray-700">';
            items.forEach(item => html += `<li>${item}</li>`);
            html += '</ul>';
        } else if (style === 'numbered') {
            html += '<ol class="list-decimal list-inside space-y-1 text-sm text-gray-700">';
            items.forEach(item => html += `<li>${item}</li>`);
            html += '</ol>';
        } else if (style === 'checklist') {
            html += '<ul class="space-y-1 text-sm text-gray-700">';
            items.forEach(item => {
                html += `<li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>${item}</span>
                </li>`;
            });
            html += '</ul>';
        }
    } else {
        html += '<p class="text-sm text-gray-400 italic">No items yet</p>';
    }

    document.getElementById('repeaterPreview').innerHTML = html;
};

window.saveRepeaterBlock = function() {
    const items = [];
    document.querySelectorAll('#repeaterItems input[name="items[]"]').forEach(input => {
        items.push(input.value);
    });

    const data = {
        title: document.querySelector('input[name="title"]').value,
        style: document.querySelector('input[name="style"]:checked')?.value || 'bullet',
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
};

// Initialize preview on load
setTimeout(function() {
    window.updateRepeaterPreview();
}, 50);
</script>