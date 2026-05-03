<form id="richTextEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" value="{{ $data['title'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Section title...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
        <div id="quillToolbar" class="border rounded-t-lg p-2 bg-gray-50">
            <button type="button" class="ql-bold" title="Bold"><strong>B</strong></button>
            <button type="button" class="ql-italic" title="Italic"><em>I</em></button>
            <button type="button" class="ql-underline" title="Underline"><u>U</u></button>
            <button type="button" class="ql-strike" title="Strikethrough"><s>S</s></button>
            <span class="mx-2">|</span>
            <button type="button" class="ql-list" value="ordered" title="Numbered List">1.</button>
            <button type="button" class="ql-list" value="bullet" title="Bullet List">•</button>
            <span class="mx-2">|</span>
            <button type="button" class="ql-align" value="" title="Align Left">Left</button>
            <button type="button" class="ql-align" value="center" title="Align Center">Center</button>
            <button type="button" class="ql-align" value="right" title="Align Right">Right</button>
            <span class="mx-2">|</span>
            <button type="button" class="ql-link" title="Insert Link">🔗</button>
        </div>
        <div id="quillEditor" class="border-t-0 border rounded-b-lg min-h-[200px] bg-white"></div>
        <input type="hidden" name="html" id="richTextHtml" value="{{ $data['html'] ?? '' }}">
    </div>

    <button type="button" onclick="saveThisBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

<script>
// Load Quill CSS if not already loaded
if (!document.querySelector('link[href*="quill.snow"]')) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css';
    document.head.appendChild(link);
}

// Load Quill JS if not already loaded
if (!document.querySelector('script[src*="quill.min"]')) {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js';
    script.onload = function() {
        if (typeof window.initQuillEditor === 'function') {
            window.initQuillEditor();
        }
    };
    document.head.appendChild(script);
}

window.initQuillEditor = function() {
    if (window.quillInstance) return; // Already initialized

    window.quillInstance = new Quill('#quillEditor', {
        theme: 'snow',
        modules: {
            toolbar: '#quillToolbar'
        },
        placeholder: 'Start typing your content...'
    });

    // Set initial content
    const initialHtml = document.getElementById('richTextHtml').value;
    if (initialHtml) {
        window.quillInstance.root.innerHTML = initialHtml;
    }

    // Sync content to hidden input on every change
    window.quillInstance.on('text-change', function() {
        document.getElementById('richTextHtml').value = window.quillInstance.root.innerHTML;
    });
};

// Initialize if Quill is already loaded
if (typeof Quill !== 'undefined') {
    setTimeout(function() {
        if (typeof window.initQuillEditor === 'function') {
            window.initQuillEditor();
        }
    }, 100);
}

function saveThisBlock() {
    const form = document.getElementById('richTextEditorForm');
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