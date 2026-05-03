@php
$title = $data['title'] ?? '';
$html = $data['html'] ?? '';
@endphp

<section class="py-12 px-6">
    <div class="max-w-4xl mx-auto">
        @if($title)
            <h2 class="text-3xl font-bold text-gray-900 mb-6">
                {{ $title }}
            </h2>
        @endif

        @if($html)
            <div class="prose prose-lg max-w-none text-gray-700">
                {!! $html !!}
            </div>
        @endif
    </div>
</section>