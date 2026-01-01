@php
  $title = $data['title'] ?? '';
  $btn = $data['button_text'] ?? 'Download';
  $file = $data['file_path'] ?? null;
@endphp

<section class="mt-6 bg-white border rounded-2xl p-6">
    @if($title)
        <h2 class="text-xl font-semibold">{{ $title }}</h2>
    @endif

    @if($file)
        <a href="{{ asset('storage/'.$file) }}" target="_blank"
           class="inline-flex mt-3 px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
            {{ $btn }}
        </a>
    @else
        <p class="text-gray-600 mt-2 text-sm">No file uploaded yet.</p>
    @endif
</section>
