@php
    use App\Models\PageBlock;

    $heading = trim((string) ($data['heading'] ?? ''));
    $count = (int) ($data['count'] ?? 2);
    $layout = $data['layout'] ?? null;
    $gap = $data['gap'] ?? 'md';
    $align = $data['vertical_align'] ?? 'top';
    $stack = (bool) ($data['stack_on_mobile'] ?? true);
    $items = array_values(array_filter((array) ($data['items'] ?? []), 'is_array'));

    $widths = PageBlock::widthsFor($count, $layout);
    $gapValue = PageBlock::gapValue($gap);
    $alignValue = PageBlock::alignValue($align);
    $gapCount = max(0, $count - 1);

    // Take the gap out of each column so the row never overflows
    $basis = collect($widths)->map(function ($width) use ($gapValue, $gapCount, $count) {
        return "calc({$width} - ({$gapValue} * {$gapCount} / {$count}))";
    })->all();
@endphp

@if(count($items) > 0)
    <section class="py-10 px-2">
        <div class="max-w-6xl mx-auto">
            @if($heading !== '')
                <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $heading }}</h2>
            @endif

            <div class="pb-columns {{ $stack ? 'pb-columns--stack' : '' }}"
                 style="gap: {{ $gapValue }}; align-items: {{ $alignValue }};">
                @foreach($items as $index => $item)
                    @php
                        $html = (string) ($item['html'] ?? '');
                        $image = (string) ($item['image_path'] ?? '');
                        $alt = (string) ($item['image_alt'] ?? '');
                        $position = $item['image_position'] ?? 'top';
                        $width = $basis[$index] ?? 'auto';
                        $sideBySide = in_array($position, ['left', 'right'], true) && $image !== '';
                    @endphp

                    <div class="pb-col" style="flex: 0 1 {{ $width }}; max-width: {{ $width }};">
                        @if($sideBySide)
                            <div class="pb-col-body pb-image-{{ $position }}">
                                <div class="pb-col-media">
                                    <img src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
                                </div>
                                <div class="pb-rich-text">{!! $html !!}</div>
                            </div>
                        @else
                            @if($image !== '')
                                <div class="pb-col-media {{ $position === 'bottom' ? 'pb-col-media--bottom' : '' }}">
                                    <img src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
                                </div>
                            @endif

                            <div class="pb-col-body pb-rich-text">{!! $html !!}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
