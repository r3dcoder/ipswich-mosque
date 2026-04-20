@extends('main-layout')

@section('title', 'Unsubscribed - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-lg mx-auto">
        <!-- Success Card -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="p-8 text-center">
                <!-- Success Icon -->
                <div class="mx-auto w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Heading -->
                <h1 class="text-2xl font-bold text-gray-900 mb-4">You've been unsubscribed</h1>

                <!-- Message -->
                <p class="text-gray-600 mb-2">
                    @if(isset($subscriber) && $subscriber->name)
                        Thank you, {{ $subscriber->name }}.
                    @endif
                    You have been successfully unsubscribed from our newsletter.
                </p>
                <p class="text-gray-600 mb-6">
                    You will no longer receive newsletter emails at <strong>{{ $subscriber->email ?? 'your email address' }}</strong>.
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('newsletters.index') }}" class="px-6 py-3 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition font-medium">
                        View Newsletter Archive
                    </a>
                    <a href="/" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                        Return to Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Resubscribe Option -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Changed your mind?</h3>
            <p class="text-sm text-gray-600 mb-4">You can resubscribe at any time to receive updates again.</p>
            <form action="{{ route('newsletter.resubscribe', $subscriber->subscription_token ?? '') }}" method="GET">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium">
                    Resubscribe to Newsletter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection