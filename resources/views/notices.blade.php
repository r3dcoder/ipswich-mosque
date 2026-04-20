@extends('main-layout')

@section('title', 'Notice Board - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Notice Board</h1>
            <p class="text-gray-600">Stay updated with the latest announcements from Ipswich Mosque</p>
        </div>

        <!-- Newsletter Subscription -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mb-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Subscribe to Updates</h3>
                <p class="text-sm text-gray-600 mb-4">Get notified when new notices are posted</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="Your email address" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">Subscribe</button>
                </form>
            </div>
        </div>

        <!-- Notices List -->
        <div class="space-y-6">
            @forelse($notices as $notice)
                <article class="bg-white rounded-lg shadow-sm border overflow-hidden hover:shadow-md transition">
                    @if($notice->image_path)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $notice->image_path) }}" alt="{{ $notice->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            @if($notice->is_pinned)
                                <span class="text-yellow-500" title="Pinned">📌</span>
                            @endif
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if($notice->category == 'urgent') bg-red-100 text-red-700
                                @elseif($notice->category == 'event') bg-blue-100 text-blue-700
                                @elseif($notice->category == 'prayer') bg-emerald-100 text-emerald-700
                                @elseif($notice->category == 'announcement') bg-purple-100 text-purple-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ $notice->category_label }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $notice->published_at ? $notice->published_at->format('M d, Y') : '' }}</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $notice->title }}</h2>
                        @if($notice->summary)
                            <p class="text-gray-600 mb-4">{{ $notice->summary }}</p>
                        @else
                            <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($notice->content), 200) }}</p>
                        @endif
                        <a href="{{ route('notices.show', $notice) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                            Read more
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notices available</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for updates.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notices->hasPages())
            <div class="mt-8">
                {{ $notices->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection