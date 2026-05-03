@php
$title = $data['title'] ?? '';
$buttonText = $data['button_text'] ?? 'Download';
$filePath = $data['file_path'] ?? '';
@endphp

@if($filePath)
<section class="py-12 px-6">
    <div class="max-w-4xl mx-auto">
        @if($title)
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                {{ $title }}
            </h2>
        @endif

        <a href="{{ $filePath }}"
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
           download>
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            {{ $buttonText }}
        </a>
    </div>
</section>
@endif