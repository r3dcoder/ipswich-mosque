@php
    use App\Models\PageBlock;

    $image = (string) ($data['image_path'] ?? '');
    $alt = (string) ($data['image_alt'] ?? '');
    $position = ($data['image_position'] ?? 'left') === 'right' ? 'right' : 'left';
    $width = (string) ($data['image_width'] ?? '45');
    $align = $data['vertical_align'] ?? 'center';
    $rounded = (bool) ($data['rounded'] ?? true);
    $gap = $data['gap'] ?? 'md';
    $html = (string) ($data['html'] ?? '');

    $gapValue = PageBlock::gapValue($gap);
    $alignClass = 'pb-image-text--' . $align;
    $mediaBasis = "calc({$width}% - ({$gapValue} / 2))";
@endphp

@if($image !== '' || trim($html) !== '')
    <section class="py-10 px-2">
        <div class="max-w-6xl mx-auto">
            <div class="pb-image-text {{ $position === 'right' ? 'pb-image-text--right' : '' }} {{ $alignClass }}"
                 style="gap: {{ $gapValue }};">
                @if($image !== '')
                    <div class="pb-image-text__media {{ $rounded ? '' : 'pb-rounded-none' }}"
                         style="flex: 0 0 {{ $mediaBasis }}; max-width: {{ $mediaBasis }};">
                        <img src="{{ $image }}" alt="{{ $alt }}" loading="lazy">
                    </div>
                @endif

                <div class="pb-image-text__body pb-rich-text">{!! $html !!}</div>
            </div>
        </div>
    </section>
@endif
