<form id="imageEditorForm" class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
        <input type="file" id="imageUpload" accept="image/*"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               onchange="handleImageUpload(event)">
        <p class="text-xs text-gray-500 mt-1">Upload an image file (JPG, PNG, GIF)</p>
    </div>

    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="px-2 bg-white text-gray-500">OR</span>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
        <input type="text" name="image_path" id="imagePathInput" value="{{ $data['image_path'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="https://example.com/image.jpg"
               oninput="updateImagePreview()">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
        <input type="text" name="caption" value="{{ $data['caption'] ?? '' }}"
               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"
               placeholder="Image caption...">
    </div>

    <!-- Preview -->
    <div class="border-t pt-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
        <div id="imagePreview" class="border rounded-lg p-3 bg-gray-50 min-h-[100px] flex items-center justify-center">
            @if(!empty($data['image_path']))
                <img src="{{ $data['image_path'] }}" alt="Preview" class="max-w-full max-h-40 object-contain">
            @else
                <p class="text-sm text-gray-400 italic">No image</p>
            @endif
        </div>
    </div>

    <button type="button" onclick="saveThisBlock()"
            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
        Save Block
    </button>
</form>

<script>
// Handle image upload
function handleImageUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validate file type
    if (!file.type.startsWith('image/')) {
        window.showNotification('Please select an image file', 'error');
        return;
    }

    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="max-w-full max-h-40 object-contain">`;
        
        // Store the base64 data for saving
        window.uploadedImageData = e.target.result;
        
        // Clear the URL input since we're using uploaded image
        document.getElementById('imagePathInput').value = '';
    };
    reader.readAsDataURL(file);
}

function updateImagePreview() {
    const url = document.getElementById('imagePathInput').value;
    const preview = document.getElementById('imagePreview');
    
    if (url) {
        preview.innerHTML = `<img src="${url}" alt="Preview" class="max-w-full max-h-40 object-contain">`;
        window.uploadedImageData = null; // Clear uploaded data if URL is entered
    } else if (!window.uploadedImageData) {
        preview.innerHTML = '<p class="text-sm text-gray-400 italic">No image</p>';
    }
}

function saveThisBlock() {
    const imagePath = document.getElementById('imagePathInput').value;
    const caption = document.querySelector('input[name="caption"]').value;
    
    // If we have uploaded image data, use that; otherwise use URL
    const finalImagePath = window.uploadedImageData || imagePath;
    
    const data = {
        image_path: finalImagePath,
        caption: caption
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
</script>