@php
$title = $data['title'] ?? '';
$style = $data['style'] ?? 'bullet';
$items = $data['items'] ?? [];
$items = array_filter($items, function($v) { return trim($v) !== ''; });
@endphp

@if(count($items) > 0 || $title)
<section class="py-12 px-6">
    <div class="max-w-4xl mx-auto">
        @if($title)
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ $title }}
            </h2>
        @endif

        @if(count($items) > 0)
            @if($style === 'bullet')
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    @foreach($items as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @elseif($style === 'numbered')
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    @foreach($items as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ol>
            @elseif($style === 'checklist')
                <ul class="space-y-2">
                    @foreach($items as $item)
                        <li class="flex items-center gap-3 text-gray-700">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>
</section>
@endif