@extends('main-layout')

@section('title', $newsletter->title . ' - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('newsletters.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Newsletter Archive
            </a>
        </div>

        <!-- Newsletter Content -->
        <article class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="p-8">
                <!-- Header -->
                <div class="flex items-center gap-4 mb-6">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700">
                        Newsletter
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $newsletter->sent_at->format('F d, Y') }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $newsletter->title }}</h1>

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($newsletter->content)) !!}
                </div>

                <!-- Footer Info -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500">
                        This newsletter was sent to {{ $newsletter->sent_count }} subscribers.
                    </p>
                </div>
            </div>
        </article>

        <!-- Share Section -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this newsletter</h3>
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

        <!-- Subscribe CTA -->
        <div class="mt-8 bg-emerald-50 border border-emerald-200 rounded-lg p-6">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Want to receive our newsletters?</h3>
                <p class="text-sm text-gray-600 mb-4">Subscribe to get updates directly in your inbox</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="Your email address" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">Subscribe</button>
                </form>
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
    const title = encodeURIComponent("{{ addslashes($newsletter->title) }}");
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