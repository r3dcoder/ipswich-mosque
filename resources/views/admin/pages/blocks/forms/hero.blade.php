<form action="{{ route('admin.pages.blocks.update', [$page, $block]) }}" method="POST" enctype="multipart/form-data"
      class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Heading</label>
        <input name="heading" value="{{ $block->data['heading'] ?? '' }}"
               class="mt-1 w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Subheading</label>
        <textarea name="subheading" rows="3" class="mt-1 w-full rounded-lg border-gray-300">{{ $block->data['subheading'] ?? '' }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-700">Button Text</label>
            <input name="button_text" value="{{ $block->data['button_text'] ?? '' }}"
                   class="mt-1 w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Button URL</label>
            <input name="button_url" value="{{ $block->data['button_url'] ?? '' }}"
                   class="mt-1 w-full rounded-lg border-gray-300" placeholder="/donate or https://...">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Background Image (optional)</label>
        <input type="file" name="bg_image" class="mt-1 block w-full text-sm">

        @if(!empty($block->data['bg_image_path']))
            <div class="mt-3">
                <img src="{{ asset('storage/'.$block->data['bg_image_path']) }}"
                     class="w-full max-h-64 object-cover rounded-lg border" alt="">
            </div>
        @endif
    </div>

    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        Save Hero Block
    </button>
</form>
