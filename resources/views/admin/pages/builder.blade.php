@extends('layouts.dashboard')

@section('title', 'Page Builder - ' . ($page->title ?? 'New Page'))
@section('header', 'Page Builder')

@section('content')
<div class="flex gap-6 h-[calc(100vh-140px)]">
    <!-- LEFT PANEL - Block Palette -->
    <div class="w-60 flex-shrink-0">
        <div class="bg-white border rounded-xl p-4 sticky top-24">
            <h3 class="font-semibold text-gray-900 mb-4">Available Blocks</h3>
            
            <div class="space-y-2" id="blockPalette">
                @foreach($blockTypes as $type)
                    <button onclick="addBlock('{{ $type['id'] }}')"
                            class="w-full text-left p-3 border rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all group">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">{{ $type['icon'] }}</span>
                            <div>
                                <div class="font-medium text-sm text-gray-900">{{ $type['name'] }}</div>
                                <div class="text-xs text-gray-500">{{ $type['description'] }}</div>
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t">
                <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Pages
                </a>
            </div>
        </div>
    </div>

    <!-- CENTER PANEL - Canvas -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <div class="bg-white border rounded-xl p-3 mb-4 flex-shrink-0">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex-1 min-w-0">
                    <input type="text" id="pageTitle" value="{{ $page->title }}"
                           class="text-base font-semibold border-0 border-b-2 border-transparent focus:border-blue-500 focus:ring-0 px-0 w-full max-w-md"
                           placeholder="Page title...">
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="/{{ $page->slug }}" target="_blank"
                       class="px-3 py-1.5 border rounded-lg text-xs hover:bg-gray-50 flex items-center gap-1.5"
                       title="View published page">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview
                    </a>
                    
                    <button onclick="togglePublish()" id="publishToggle"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $page->is_published ? 'bg-green-500' : 'bg-gray-300' }}"
                            title="{{ $page->is_published ? 'Click to unpublish' : 'Click to publish' }}">
                        <span class="sr-only">Publish page</span>
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $page->is_published ? 'translate-x-6' : 'translate-x-1' }}"></span>
                    </button>
                    <span class="text-xs font-medium {{ $page->is_published ? 'text-green-600' : 'text-gray-500' }}" id="publishStatus">
                        {{ $page->is_published ? 'Published' : 'Draft' }}
                    </span>

                    <button onclick="savePageSettings()"
                            class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- Canvas Area -->
        <div class="flex-1 overflow-y-auto bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-6" id="canvasArea">
            <!-- Empty State -->
            <div id="emptyState" class="flex flex-col items-center justify-center py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2h14m-6 4h6"/>
                </svg>
                <h3 class="text-base font-medium text-gray-700 mb-1">No blocks yet</h3>
                <p class="text-sm text-gray-400">Click a block type on the left to add it here</p>
            </div>

            <!-- Blocks Container -->
            <div class="space-y-4" id="blocksContainer">
                @forelse($page->blocks as $block)
                    <div class="bg-white border rounded-xl overflow-hidden transition-all duration-200 group"
                         data-block-id="{{ $block->id }}"
                         onclick="selectBlock({{ $block->id }})">
                        <!-- Block Header -->
                        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b">
                            <div class="flex items-center gap-3">
                                <span class="cursor-move text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                </span>
                                <span class="font-medium text-gray-900">{{ strtoupper(str_replace('_', ' ', $block->type)) }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2" onclick="event.stopPropagation();">
                                <button onclick="moveBlockUp({{ $block->id }})"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Move Up">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                </button>
                                <button onclick="moveBlockDown({{ $block->id }})"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Move Down">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <button onclick="duplicateBlock({{ $block->id }})"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Duplicate">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.pages.blocks.destroy', [$page, $block]) }}" 
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Delete this block?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Block Preview -->
                        <div class="p-4 block-preview-body">
                            @includeIf('blocks.' . $block->type, ['data' => $block->data, 'page' => $page])
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL - Block Editor -->
    <div class="w-80 flex-shrink-0" id="editorSidebar" style="display: none;">
        <div class="bg-white border rounded-xl p-4 sticky top-24">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Edit Block</h3>
                <button onclick="closeEditor()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div id="blockEditorForm">
                <div class="text-sm text-gray-500 text-center py-8">
                    Select a block to edit
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.block-selected {
    border-color: #3B82F6 !important;
    box-shadow: 0 0 0 2px #3B82F6 !important;
}
</style>

<script>
window.selectedBlockId = null;

// Add block type
function addBlock(type) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/pages/{{ $page->id }}/blocks';
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    form.appendChild(csrf);
    
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'type';
    typeInput.value = type;
    form.appendChild(typeInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Select block for editing
function selectBlock(blockId) {
    window.selectedBlockId = blockId;
    
    document.querySelectorAll('.block-selected').forEach(el => el.classList.remove('block-selected'));
    const block = document.querySelector(`[data-block-id="${blockId}"]`);
    if (block) block.classList.add('block-selected');
    
    document.getElementById('editorSidebar').style.display = 'block';
    
    fetch('/admin/pages/{{ $page->id }}/blocks/' + blockId + '/edit')
        .then(response => response.text())
        .then(html => {
            document.getElementById('blockEditorForm').innerHTML = html;
            executeScripts(document.getElementById('blockEditorForm'));
            // Call initialization functions if they exist
            setTimeout(function() {
                if (typeof window.initQuillEditor === 'function') window.initQuillEditor();
                if (typeof window.initRepeaterEditor === 'function') window.initRepeaterEditor();
            }, 100);
        });
}

// Execute scripts after AJAX load
function executeScripts(container) {
    const scripts = container.querySelectorAll('script');
    scripts.forEach(oldScript => {
        const newScript = document.createElement('script');
        Array.from(oldScript.attributes).forEach(attr => {
            newScript.setAttribute(attr.name, attr.value);
        });
        newScript.textContent = oldScript.textContent;
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });
}

// Close editor
function closeEditor() {
    document.getElementById('editorSidebar').style.display = 'none';
    window.selectedBlockId = null;
    document.querySelectorAll('.block-selected').forEach(el => el.classList.remove('block-selected'));
}

// Show notification
window.showNotification = function(message, type) {
    type = type || 'success';
    const notification = document.createElement('div');
    notification.className = 'fixed bottom-4 right-4 px-4 py-2 rounded-lg text-white z-50 ' + 
        (type === 'error' ? 'bg-red-600' : 'bg-green-600');
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}

// Save page settings
function savePageSettings() {
    const title = document.getElementById('pageTitle').value;
    const isPublished = document.getElementById('publishToggle').classList.contains('bg-green-500');
    
    fetch('/admin/pages/{{ $page->id }}?_method=PUT', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            title: title,
            is_published: isPublished ? 1 : 0
        })
    })
    .then(response => response.json())
    .then(data => {
        window.showNotification('Page saved!');
    })
    .catch(error => {
        window.showNotification('Error saving page', 'error');
    });
}

// Toggle publish
function togglePublish() {
    const toggle = document.getElementById('publishToggle');
    const status = document.getElementById('publishStatus');
    const isPublished = toggle.classList.contains('bg-green-500');
    
    if (isPublished) {
        toggle.classList.remove('bg-green-500');
        toggle.classList.add('bg-gray-300');
        toggle.querySelector('span:last-child').classList.remove('translate-x-6');
        toggle.querySelector('span:last-child').classList.add('translate-x-1');
        status.textContent = 'Draft';
        status.classList.remove('text-green-600');
        status.classList.add('text-gray-500');
    } else {
        toggle.classList.remove('bg-gray-300');
        toggle.classList.add('bg-green-500');
        toggle.querySelector('span:last-child').classList.remove('translate-x-1');
        toggle.querySelector('span:last-child').classList.add('translate-x-6');
        status.textContent = 'Published';
        status.classList.remove('text-gray-500');
        status.classList.add('text-green-600');
    }
}

// Move block up
function moveBlockUp(blockId) {
    const block = document.querySelector(`[data-block-id="${blockId}"]`);
    const prev = block.previousElementSibling;
    if (prev) {
        block.parentNode.insertBefore(block, prev);
        sendReorder();
    }
}

// Move block down
function moveBlockDown(blockId) {
    const block = document.querySelector(`[data-block-id="${blockId}"]`);
    const next = block.nextElementSibling;
    if (next) {
        block.parentNode.insertBefore(next, block);
        sendReorder();
    }
}

// Send reorder to server
function sendReorder() {
    const blocks = document.querySelectorAll('#blocksContainer > div');
    const order = Array.from(blocks).map(block => parseInt(block.dataset.blockId));
    
    fetch('/admin/pages/{{ $page->id }}/blocks/reorder', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ order: order })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showNotification('Order updated!');
        }
    });
}

// Duplicate block
function duplicateBlock(blockId) {
    // For now, show a message - full implementation would clone the block
    window.showNotification('Duplicate functionality coming soon!');
}

// Refresh block preview
window.refreshBlockPreview = function(blockId) {
    fetch('/admin/pages/{{ $page->id }}/blocks/' + blockId + '/preview')
        .then(response => response.text())
        .then(html => {
            const block = document.querySelector(`[data-block-id="${blockId}"]`);
            if (block) {
                const previewBody = block.querySelector('.block-preview-body');
                if (previewBody) previewBody.innerHTML = html;
            }
        });
};
</script>
@endsection