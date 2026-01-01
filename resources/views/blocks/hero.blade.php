@php
  $heading = $data['heading'] ?? '';
  $subheading = $data['subheading'] ?? '';
  $btnText = $data['button_text'] ?? '';
  $btnUrl = $data['button_url'] ?? '';
  $bg = $data['bg_image_path'] ?? null;
@endphp

<section class="relative overflow-hidden rounded-2xl border bg-gray-900 text-white">
    <div class="absolute inset-0">
        @if($bg)
            <img src="{{ asset('storage/'.$bg) }}" class="w-full h-full object-cover opacity-70" alt="">
        @endif
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <div class="relative px-6 py-12 md:px-10 md:py-16">
        <h1 class="text-3xl md:text-4xl font-bold">{{ $heading }}</h1>
        @if($subheading)
            <p class="mt-3 text-white/90 max-w-2xl">{{ $subheading }}</p>
        @endif

        @if($btnText && $btnUrl)
            <a href="{{ $btnUrl }}"
               class="inline-flex mt-6 px-5 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-sm font-semibold">
                {{ $btnText }}
            </a>
        @endif
    </div>
</section>
