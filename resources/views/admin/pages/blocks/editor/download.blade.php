<form id="downloadEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" value="{{ $data['title'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Download title...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
        <input type="text" name="button_text" value="{{ $data['button_text'] ?? 'Download' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Download">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">File URL</label>
        <input type="text" name="file_path" value="{{ $data['file_path'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="https://example.com/file.pdf">
    </div>

    <button type="button" onclick="saveThisBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

<script>
function saveThisBlock() {
    const form = document.getElementById('downloadEditorForm');
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