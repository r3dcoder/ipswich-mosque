@extends('main-layout')

@section('title', $notice->title . ' - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('notices.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Notice Board
            </a>
        </div>

        <!-- Notice Content -->
        <article class="bg-white rounded-lg shadow-sm border overflow-hidden">
            @if($notice->image_path)
                <div class="h-64 overflow-hidden">
                    <img src="{{ asset('storage/' . $notice->image_path) }}" alt="{{ $notice->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-8">
                <!-- Header -->
                <div class="flex items-center gap-4 mb-6">
                    @if($notice->is_pinned)
                        <span class="text-yellow-500 text-xl" title="Pinned">📌</span>
                    @endif
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        @if($notice->category == 'urgent') bg-red-100 text-red-700
                        @elseif($notice->category == 'event') bg-blue-100 text-blue-700
                        @elseif($notice->category == 'prayer') bg-emerald-100 text-emerald-700
                        @elseif($notice->category == 'announcement') bg-purple-100 text-purple-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ $notice->category_label }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $notice->published_at ? $notice->published_at->format('F d, Y') : '' }}
                    </span>
                    <span class="text-sm text-gray-400">
                        • {{ $notice->view_count }} views
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $notice->title }}</h1>

                <!-- Summary (if different from content) -->
                @if($notice->summary)
                    <div class="text-lg text-gray-600 mb-6 pb-6 border-b border-gray-200">
                        {{ $notice->summary }}
                    </div>
                @endif

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($notice->content)) !!}
                </div>

                <!-- Footer Info -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    @if($notice->expires_at)
                        <p class="text-sm text-gray-500">
                            <strong>Note:</strong> This notice will expire on {{ $notice->expires_at->format('F d, Y') }}.
                        </p>
                    @endif
                </div>
            </div>
        </article>

        <!-- Share Section -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this notice</h3>
            <div class="flex gap-4">
                <button onclick="shareOnFacebook()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Share on Facebook
                </button>
                <button onclick="shareOnTwitter()" class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                    Share on Twitter
                </button>
                <button onclick="copyLink()" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                    Copy Link
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent("{{ addslashes($notice->title) }}");
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link copied to clipboard!');
    }).catch(() => {
        alert('Failed to copy link');
    });
}
</script>
@endsection

@section('footer')
    @include('partials.footer')
@endsection