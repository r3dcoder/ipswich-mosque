@php
  $caption = $data['caption'] ?? '';
  $img = $data['image_path'] ?? null;
@endphp

<section class="mt-6 bg-white border rounded-2xl p-6">
    @if($img)
        <img src="{{ asset('storage/'.$img) }}"
             class="w-full max-h-[560px] object-contain rounded-xl border bg-white"
             alt="">
    @else
        <div class="text-sm text-gray-600">No image uploaded yet.</div>
    @endif

    @if($caption)
        <p class="text-sm text-gray-600 mt-3">{{ $caption }}</p>
    @endif
</section>
