@php
$caption = $data['caption'] ?? '';
$imagePath = $data['image_path'] ?? '';
@endphp

@if($imagePath)
<section class="py-12 px-6">
    <div class="max-w-4xl mx-auto">
        <figure class="text-center">
            <img src="{{ $imagePath }}" alt="{{ $caption }}" class="max-w-full h-auto rounded-lg shadow-lg">
            @if($caption)
                <figcaption class="mt-4 text-gray-600 text-sm italic">
                    {{ $caption }}
                </figcaption>
            @endif
        </figure>
    </div>
</section>
@endif