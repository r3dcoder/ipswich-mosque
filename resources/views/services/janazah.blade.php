@extends('main-layout')

@section('title', 'Janazah Services - Ipswich Mosque')
@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="janazah-page">
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 text-white">
        <div class="absolute inset-0 opacity-20 pointer-events-none" aria-hidden="true">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-emerald-500 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-16 w-80 h-80 rounded-full bg-teal-600 blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 text-emerald-300 text-sm font-semibold tracking-wide uppercase mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Support when you need it most
                </p>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-5 leading-tight">
                    {{ $hero->title ?? 'Janazah & Funeral Services' }}
                </h1>

                @if($hero && $hero->content)
                    <div class="text-gray-300 text-lg md:text-xl mb-8 leading-relaxed space-y-4">
                        {!! nl2br(e($hero->content)) !!}
                    </div>
                @else
                    <p class="italic text-emerald-300 mb-4 text-xl">"Inna Lillahi wa inna ilayhi raji'un"</p>
                    <p class="text-gray-300 text-lg md:text-xl mb-8 leading-relaxed">
                        The Ipswich Mosque offers full support during difficult times, including body wash (Ghusl) facilities,
                        shrouding (Kafan), and Janazah prayers before burial.
                    </p>
                @endif

                @if($emergencyContacts->isNotEmpty())
                    <a href="#emergency-contacts"
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl transition shadow-lg shadow-emerald-900/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        View emergency contacts
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- Emergency Contacts --}}
    @if($emergencyContacts->isNotEmpty())
    <section id="emergency-contacts" class="py-14 md:py-16 bg-white scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
                <div>
                    <p class="text-emerald-700 font-semibold text-sm uppercase tracking-wide mb-2">Available 24/7</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Emergency Contacts</h2>
                    <p class="text-gray-500 mt-2 max-w-xl">
                        Please call one of the contacts below for immediate funeral assistance. Tap a number to call directly.
                    </p>
                </div>
                <div class="inline-flex items-center gap-2 self-start sm:self-auto rounded-full bg-emerald-50 text-emerald-800 text-sm font-medium px-4 py-2 border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ $emergencyContacts->count() }} {{ Str::plural('contact', $emergencyContacts->count()) }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($emergencyContacts as $contact)
                    @php
                        $tel = preg_replace('/\s+/', '', $contact->phone_number);
                        $initials = collect(preg_split('/\s+/', trim($contact->name)))
                            ->filter()
                            ->take(2)
                            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                            ->implode('');
                    @endphp
                    <article class="group relative flex flex-col rounded-2xl border border-gray-100 bg-gradient-to-b from-white to-slate-50 p-6 shadow-sm hover:shadow-md hover:border-emerald-200 transition">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm tracking-wide">
                                {{ $initials ?: '•' }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-bold text-gray-900 text-lg leading-snug truncate" title="{{ $contact->name }}">
                                    {{ $contact->name }}
                                </h3>
                                @if($contact->role_in_committee)
                                    <p class="text-sm text-emerald-700 font-medium mt-0.5 truncate" title="{{ $contact->role_in_committee }}">
                                        {{ $contact->role_in_committee }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 mt-0.5">Committee contact</p>
                                @endif
                            </div>
                        </div>

                        <a href="tel:{{ $tel }}"
                           class="mt-auto flex items-center justify-between gap-3 rounded-xl bg-slate-900 text-white px-4 py-3.5 group-hover:bg-emerald-700 transition"
                           aria-label="Call {{ $contact->name }} at {{ $contact->phone_number }}">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="flex-shrink-0 w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </span>
                                <span class="font-semibold tracking-wide truncate">{{ $contact->phone_number }}</span>
                            </span>
                            <span class="flex-shrink-0 text-xs font-semibold uppercase tracking-wider text-white/70 group-hover:text-white">
                                Call
                            </span>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Funeral Rites --}}
    @if($rites->isNotEmpty() && (!isset($ritesHeading) || !$ritesHeading || $ritesHeading->is_visible))
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">{{ $ritesHeading->title ?? 'Funeral Rites in Islam' }}</h2>
            @if(($ritesHeading->content ?? null))
                <p class="text-gray-500 mb-12 max-w-2xl mx-auto">{{ $ritesHeading->content }}</p>
            @else
                <p class="text-gray-500 mb-12 max-w-2xl mx-auto">A brief overview of the key steps observed in Islamic funeral practice.</p>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($rites as $index => $rite)
                    <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 border-b-4 border-b-emerald-700 text-left sm:text-center hover:shadow-md transition">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-50 text-emerald-800 font-bold text-lg mb-3">
                            {{ $index + 1 }}
                        </span>
                        <h4 class="font-bold text-gray-900">{{ $rite->title }}</h4>
                        @if($rite->content)
                            <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $rite->content }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Janazah Prayer --}}
    @if($prayers->isNotEmpty() && (!isset($prayersHeading) || !$prayersHeading || $prayersHeading->is_visible))
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $prayersHeading->title ?? 'How to Pray Janazah Prayer' }}</h2>
                @if(($prayersHeading->content ?? null))
                    <p class="text-emerald-700 font-semibold mt-2">{{ $prayersHeading->content }}</p>
                @else
                    <p class="text-emerald-700 font-semibold mt-2">(Hanafi Madhhab)</p>
                @endif
            </div>

            <div class="space-y-6">
                @foreach($prayers as $index => $prayer)
                    <div class="flex gap-5 p-5 rounded-2xl border border-gray-100 bg-slate-50/60 hover:bg-white hover:shadow-sm transition">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-lg">
                            {{ $index + 1 }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-lg text-gray-900">{{ $prayer->title }}</h4>
                            @if($prayer->content)
                                <div class="text-gray-600 mt-2 leading-relaxed space-y-2">
                                    {!! nl2br(e($prayer->content)) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

@include('partials.janazah-terms', ['terms' => $terms, 'termsPoints' => $termsPoints])

<style>
    .modern-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        outline: none;
        color: #1e293b !important;
        background: #fff !important;
    }
    .modern-input:focus { border-color: var(--brand-green); box-shadow: 0 0 0 3px rgba(10, 81, 52, 0.1); }
</style>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
