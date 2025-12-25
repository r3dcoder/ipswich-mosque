@php($slide = $slide ?? null)

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Page (slug) *</label>
        <input name="page" value="{{ old('page', $slide?->page ?? 'home') }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
               placeholder="home" required>
        <p class="text-xs text-gray-500 mt-1">Example: home, donate, events</p>
        @error('page') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Order *</label>
        <input type="number" name="sort_order" min="1" max="9999"
               value="{{ old('sort_order', $slide?->sort_order ?? 1) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
        @error('sort_order') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Title *</label>
        <input name="title" value="{{ old('title', $slide?->title) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
        @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Subtitle</label>
        <input name="subtitle" value="{{ old('subtitle', $slide?->subtitle) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
        @error('subtitle') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Button Text</label>
        <input name="button_text" value="{{ old('button_text', $slide?->button_text) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
               placeholder="Donate Now">
        @error('button_text') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Button URL</label>
        <input name="button_url" value="{{ old('button_url', $slide?->button_url) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
               placeholder="/donate">
        @error('button_url') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Image {{ $slide ? '(optional to replace)' : '*' }}</label>
        <input type="file" name="image" accept="image/*"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
        @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

        @if($slide)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$slide->image_path) }}" class="h-24 rounded border object-cover" alt="">
            </div>
        @endif
    </div>

    <div class="md:col-span-2 flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $slide?->is_active ?? true) ? 'checked' : '' }}
               class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
        <label class="text-sm">Active</label>
    </div>
</div>
