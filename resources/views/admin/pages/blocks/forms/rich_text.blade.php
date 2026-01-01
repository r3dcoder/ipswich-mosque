<form action="{{ route('admin.pages.blocks.update', [$page, $block]) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Section Title (optional)</label>
        <input name="title" value="{{ $block->data['title'] ?? '' }}"
               class="mt-1 w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Content</label>

        {{-- IMPORTANT: unique id per block --}}
        
        <textarea 
        name="html" 
        
        id="editor-{{ $block->id }}" rows="12"
                 
        class="mytextarea tinymce mt-1 w-full rounded-lg border-gray-300 font-mono text-sm"
                  
        required>{{ $block->data['html'] ?? '' }}</textarea>
    </div>

    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        Save Text Block
    </button>
</form>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

<script>
  var quill = new Quill('.editor', {
    theme: 'snow'
  });
</script>
{{-- TinyMCE --}}
 
 
<script>
(function () {
    function initEditors() {
        if (!window.tinymce) {
            console.error("TinyMCE script not loaded.");
            return;
        }

        // Remove any old instances (safe when page re-renders)
        tinymce.remove('.tinymce');

        tinymce.init({
            selector: '.tinymce',
            height: 450,
            plugins: 'link lists table code',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code',
            menubar: false,
            branding: false,

            // OPTIONAL: only if you created upload route
            // images_upload_url: "{{ route('admin.editor.upload') }}",
            // images_upload_credentials: true,
            // automatic_uploads: true,
        });
    }

    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEditors);
    } else {
        initEditors();
    }
})();
</script>
 