@php
$heading = $data['heading'] ?? '';
$subheading = $data['subheading'] ?? '';
$buttonText = $data['button_text'] ?? '';
$buttonUrl = $data['button_url'] ?? '#';
$bgImage = $data['bg_image_path'] ?? '';
$alignment = $data['alignment'] ?? 'left';
$columnLeft = $data['column_left'] ?? '';
$columnRight = $data['column_right'] ?? '';

$alignClass = match($alignment) {
    'center' => 'text-center items-center',
    'right' => 'text-right items-end',
    default => 'text-left items-start',
};
@endphp

<section class="relative py-16 px-6 overflow-hidden" style="@if($bgImage) background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center; @endif">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative max-w-7xl mx-auto">
        <div class="flex flex-col {{ $alignClass }} gap-6">
            @if($heading)
                <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight">
                    {{ $heading }}
                </h2>
            @endif

            @if($subheading)
                <p class="text-lg md:text-xl text-white/90 max-w-2xl">
                    {{ $subheading }}
                </p>
            @endif

            @if($columnLeft || $columnRight)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 w-full">
                    @if($columnLeft)
                        <div class="text-white/90">
                            {!! nl2br(e($columnLeft)) !!}
                        </div>
                    @endif
                    @if($columnRight)
                        <div class="text-white/90">
                            {!! nl2br(e($columnRight)) !!}
                        </div>
                    @endif
                </div>
            @endif

            @if($buttonText)
                <div class="mt-4">
                    <a href="{{ $buttonUrl }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        {{ $buttonText }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>