<form action="{{ route('admin.pages.blocks.update', [$page, $block]) }}" method="POST" enctype="multipart/form-data"
      class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium text-gray-700">Title (optional)</label>
        <input name="title" value="{{ $block->data['title'] ?? '' }}"
               class="mt-1 w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Button Text</label>
        <input name="button_text" value="{{ $block->data['button_text'] ?? 'Download' }}"
               class="mt-1 w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">File Upload (PDF recommended)</label>
        <input type="file" name="file" class="mt-1 block w-full text-sm">

        @if(!empty($block->data['file_path']))
            <p class="text-sm text-green-700 mt-2">
                Current file:
                <a class="underline" target="_blank" href="{{ asset('storage/'.$block->data['file_path']) }}">
                    View / Download
                </a>
            </p>
        @endif
    </div>

    <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        Save Download Block
    </button>
</form>
