<form id="richTextEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" value="{{ $data['title'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Section title...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>

        {{-- TipTap mounts its toolbar + editable area inside this element --}}
        <div id="richTextTipTap"></div>

        {{-- Existing HTML, escaped by Blade and read back on init --}}
        <textarea id="richTextSource" class="hidden">{{ $data['html'] ?? '' }}</textarea>

        <div class="mt-2 text-xs text-gray-500 space-y-1">
            <p><strong>Images:</strong> click the 🖼 button to upload. Then click the inserted image to unlock
                <em>width</em> and <em>text wrapping</em> controls in the toolbar.</p>
            <p><strong>Layouts:</strong> for side-by-side content use the <em>Columns</em> or <em>Image + Text</em> blocks.</p>
        </div>
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

window.initRichTextEditor = function () {
    const mount = document.getElementById('richTextTipTap');
    if (!mount || mount.dataset.ready === '1') return;

    whenEditorReady(function () {
        const source = document.getElementById('richTextSource');

        window.PageBuilderEditor.create(mount, {
            html: source ? source.value : '',
            placeholder: 'Start typing your content...',
            minHeight: '220px'
        });

        mount.dataset.ready = '1';
    });
};

function saveThisBlock() {
    const title = document.querySelector('#richTextEditorForm input[name="title"]').value;
    const html = window.PageBuilderEditor
        ? window.PageBuilderEditor.getHtml('#richTextTipTap')
        : (document.getElementById('richTextSource') || {}).value || '';

    const data = { title: title, html: html };

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

window.initRichTextEditor();
</script>
