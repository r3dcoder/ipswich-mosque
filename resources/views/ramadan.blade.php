@extends('main-layout')

@section('title', $setting->title ?? 'Ramadan 2027 - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection


@section('content')
    @php
        $setting = \App\Models\RamadanSetting::where('year', 2027)
                    ->with('events')
                    ->first();
    @endphp

    <!---git Hero Section -->
    <section 
    class="relative text-white py-28 md:py-36 overflow-hidden" 
    style="background: linear-gradient(to bottom right, #022c22, #042f2e);"
>
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">
            {{ $setting->title ?? 'Ramadan Mubarak 1448 AH / 2027' }}
        </h1>
        
        <p class="text-2xl mb-12 max-w-3xl mx-auto" style="color: #d1fae5;">
            {{ $setting->hero_message ?? 'May Allah accept our fasting, prayers and good deeds.' }}
        </p>

        <div class="mx-auto max-w-md bg-white/10 backdrop-blur-xl border border-white/30 rounded-3xl p-10">
            <p class="text-lg mb-6 font-medium" style="color: #a7f3d0;">Ramadan Begins In</p>
            <div id="countdown" class="grid grid-cols-4 gap-6 text-center">
                <div><span id="days" class="text-6xl font-bold">00</span><br><span class="text-xs tracking-widest">DAYS</span></div>
                <div><span id="hours" class="text-6xl font-bold">00</span><br><span class="text-xs tracking-widest">HOURS</span></div>
                <div><span id="minutes" class="text-6xl font-bold">00</span><br><span class="text-xs tracking-widest">MINUTES</span></div>
                <div><span id="seconds" class="text-6xl font-bold">00</span><br><span class="text-xs tracking-widest">SECONDS</span></div>
            </div>
        </div>
    </div>
</section>
    <!-- Timetable Section with View & Download Buttons -->
    @if($setting && $setting->timetable_image)
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-emerald-800 mb-6">Ramadan Timetable 2027</h2>
                <p class="text-gray-600 mb-10 max-w-md mx-auto">Official prayer times for Ipswich Mosque</p>

                <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Timetable Image -->
                    <img src="{{ Storage::url($setting->timetable_image) }}" 
                         alt="Ramadan Timetable 2027" 
                         class="w-full">

                    <!-- Action Buttons -->
                    <div class="p-6 bg-white border-t flex flex-wrap justify-center gap-4">
                        <!-- View Full Size Button -->
                        <a href="{{ Storage::url($setting->timetable_image) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-medium transition">
                            View Full Size
                        </a>

                        <!-- Download Button -->
                        <a href="{{ Storage::url($setting->timetable_image) }}" 
                           download="Ramadan-Timetable-2027-Ipswich-Mosque.jpg"
                           class="inline-flex items-center gap-3 bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-2xl font-medium transition">
                            Download Timetable
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Events Section -->
    @if($setting && $setting->events->isNotEmpty())
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <span class="inline-block bg-amber-100 text-amber-700 text-sm font-semibold px-5 py-2 rounded-full mb-3">🌙 Special Programs</span>
                    <h2 class="text-5xl font-bold text-gray-900">Ramadan Events 2027</h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($setting->events->sortBy('event_date') as $event)
                        <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden shadow hover:shadow-xl transition-all duration-300">
                            <div class="h-1.5 bg-gradient-to-r from-emerald-500 to-amber-500"></div>
                            <div class="p-8">
                                <div class="flex justify-between mb-5">
                                    <span class="text-sm font-semibold bg-emerald-50 text-emerald-700 px-4 py-1.5 rounded-2xl">
                                        {{ $event->event_date->format('d F Y') }}
                                    </span>
                                    @if($event->start_time)
                                        <span class="text-amber-600 font-medium">
                                            {{ $event->start_time->format('H:i') }}
                                            @if($event->end_time) — {{ $event->end_time->format('H:i') }} @endif
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-2xl font-semibold text-gray-800 mb-4 group-hover:text-emerald-700 transition-colors">
                                    {{ $event->title }}
                                </h3>

                                @if($event->description)
                                    <p class="text-gray-600 leading-relaxed line-clamp-4 mb-6">
                                        {{ $event->description }}
                                    </p>
                                @endif

                                @if($event->location)
                                    <div class="flex items-center gap-2 text-gray-500 text-sm">
                                        <span>📍</span>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

 <script>
    const targetDate = "{{ $setting?->countdown_target ?? '2027-02-07 20:00:00' }}";

    function updateCountdown() {
        const now = new Date().getTime();
        const target = new Date(targetDate).getTime();
        const distance = target - now;

        if (distance < 0) {
            document.getElementById('countdown').innerHTML = `
                <div class="col-span-4 text-5xl font-bold text-emerald-300 py-6">
                    Ramadan Mubarak! 🌙
                </div>`;
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>
 