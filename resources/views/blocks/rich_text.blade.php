@php
  $title = $data['title'] ?? '';
  $html = $data['html'] ?? '';
@endphp

<section class="mt-6 bg-white border rounded-2xl p-6 prose max-w-none">
    @if($title)
        <h2 class="mt-0">{{ $title }}</h2>
    @endif
    {!! $html !!}
</section>
