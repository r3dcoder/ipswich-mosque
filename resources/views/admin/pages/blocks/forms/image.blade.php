<form action="{{ route('admin.pages.blocks.update', [$page, $block]) }}" method="POST" enctype="multipart/form-data"
      class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Caption (optional)</label>
        <input name="caption" value="{{ $block->data['caption'] ?? '' }}"
               class="mt-1 w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Image Upload</label>
        <input type="file" name="image" class="mt-1 block w-full text-sm">

        @if(!empty($block->data['image_path']))
            <div class="mt-3">
                <img src="{{ asset('storage/'.$block->data['image_path']) }}"
                     class="w-full max-h-80 object-contain rounded-lg border bg-white" alt="">
            </div>
        @endif
    </div>

    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        Save Image Block
    </button>
</form>
