@extends('main-layout')

@section('title', 'Our Team')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 tracking-tight">
                The People Behind <span class="text-green-600">Ipswich Mosque</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Our team is committed to fostering a welcoming environment and providing 
                steadfast support to our growing community.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        @php
            // Fetch all people, no longer grouping by role
            $people = \App\Models\People::orderBy('name')->get();
        @endphp

        @if($people->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Our team list is being updated.</h3>
                <p class="text-gray-500 mt-2">Please check back shortly.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-8 gap-y-12">
                @foreach($people as $person)
                    <div class="group">
                        <div class="relative aspect-[4/5] mb-6 overflow-hidden rounded-2xl bg-gray-100 shadow-sm transition-all duration-500 group-hover:shadow-xl group-hover:-translate-y-1">
                            @if($person->image_url)
                                <img src="{{ $person->image_url }}" 
                                     alt="{{ $person->name }}"
                                     class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition-all duration-700 scale-100 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100">
                                    <span class="text-5xl font-light text-green-300">{{ substr($person->name, 0, 1) }}</span>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-[2px]">
                                <div class="flex space-x-4">
                                    @if($person->email)
                                        <a href="mailto:{{ $person->email }}" class="p-3 bg-white rounded-full text-green-600 hover:bg-green-600 hover:text-white transition-colors" title="Email {{ $person->name }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </a>
                                    @endif
                                    @if($person->phone)
                                        <a href="tel:{{ $person->phone }}" class="p-3 bg-white rounded-full text-green-600 hover:bg-green-600 hover:text-white transition-colors" title="Call {{ $person->name }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <h3 class="text-xl font-bold text-gray-900 tracking-tight group-hover:text-green-600 transition-colors">
                                {{ $person->name }}
                            </h3>
                            <p class="text-sm font-medium text-green-600 uppercase tracking-widest">
                                {{ $person->role }}
                            </p>
                            
                            <div class="flex flex-col space-y-1 mt-3 md:hidden">
                                @if($person->email)
                                    <span class="text-xs text-gray-500 break-all">{{ $person->email }}</span>
                                @endif
                                @if($person->phone)
                                    <span class="text-xs text-gray-500">{{ $person->phone }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <section class="bg-gray-50 py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Want to get involved?</h2>
            <p class="text-gray-600 mb-8">We are always looking for dedicated volunteers to help serve the Ipswich community.</p>
            <a href="/contact" class="inline-flex items-center px-8 py-3 bg-gray-900 text-white font-semibold rounded-full hover:bg-green-600 transition-all shadow-lg hover:shadow-green-200">
                Contact Us Today
            </a>
        </div>
    </section>
@endsection

@section('footer')
    @include('partials.footer')
@endsection