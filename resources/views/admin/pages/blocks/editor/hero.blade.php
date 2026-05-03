<form id="heroEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
        <input type="text" name="heading" value="{{ $data['heading'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Main heading...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Subheading</label>
        <textarea name="subheading" rows="3"
                  class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Subheading or tagline...">{{ $data['subheading'] ?? '' }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Alignment</label>
        <select name="alignment"
                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="left" {{ ($data['alignment'] ?? 'left') === 'left' ? 'selected' : '' }}>Left</option>
            <option value="center" {{ ($data['alignment'] ?? '') === 'center' ? 'selected' : '' }}>Center</option>
            <option value="right" {{ ($data['alignment'] ?? '') === 'right' ? 'selected' : '' }}>Right</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
        <input type="text" name="button_text" value="{{ $data['button_text'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Button label...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
        <input type="text" name="button_url" value="{{ $data['button_url'] ?? '#' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="https://...">
    </div>

    <button type="button" onclick="saveThisBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

<script>
function saveThisBlock() {
    const form = document.getElementById('heroEditorForm');
    const formData = new FormData(form);
    const data = {};
    formData.forEach((value, key) => data[key] = value);

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
</script>