@extends('main-layout')

@section('title', 'Newsletter Archive - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Newsletter Archive</h1>
            <p class="text-gray-600">Browse past newsletters and stay informed about our community activities</p>
        </div>

        <!-- Subscribe Call-to-Action -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mb-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Never Miss an Update</h3>
                <p class="text-sm text-gray-600 mb-4">Subscribe to receive our newsletters directly in your inbox</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="Your email address" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">Subscribe</button>
                </form>
            </div>
        </div>

        <!-- Newsletter List -->
        <div class="space-y-6">
            @forelse($newsletters as $newsletter)
                <article class="bg-white rounded-lg shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                Newsletter
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $newsletter->sent_at->format('F d, Y') }}
                            </span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $newsletter->title }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($newsletter->content), 200) }}</p>
                        <a href="{{ route('newsletters.show', $newsletter) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                            Read more
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No newsletters yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for updates, or subscribe to be notified when new newsletters are published.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($newsletters->hasPages())
            <div class="mt-8">
                {{ $newsletters->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection