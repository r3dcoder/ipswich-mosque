@extends('main-layout')

@section('title', $setting->title ?? 'Ramadan - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection


@section('content')
    @php
        $setting = \App\Models\RamadanSetting::where('year', 2026)->first();
        $today = now()->format('Y-m-d');
        $todayTimes = $setting?->dailyTimes()->where('date', $today)->first();
    @endphp

    @if(!$setting)
        <div class="container mx-auto p-8 text-center">
            <h1 class="text-4xl font-bold">Ramadan information coming soon...</h1>
        </div>
    @else
        <!-- Hero -->
        <section class="relative bg-gradient-to-b from-emerald-900 to-emerald-950 text-white py-24">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">{{ $setting->title }}</h1>
                <p class="text-2xl md:text-4xl mb-8 text-emerald-200">{{ $setting->hero_message ?? 'Welcome to the Blessed Month' }}</p>

                <!-- Countdown -->
                <div id="countdown" class="inline-block bg-white/10 backdrop-blur-md rounded-2xl px-10 py-8 border border-emerald-700/30">
                    <p class="text-3xl md:text-5xl font-mono grid grid-cols-4 gap-6">
                        <span id="days">00</span><span id="hours">00</span><span id="minutes">00</span><span id="seconds">00</span>
                    </p>
                    <div class="grid grid-cols-4 gap-6 text-sm mt-2">
                        <div>Days</div><div>Hours</div><div>Minutes</div><div>Seconds</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timetable Image -->
        @if($setting->timetable_image)
            <section class="py-12 bg-gray-50">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-4xl font-bold text-emerald-800 mb-8">Ramadan Timetable 2026</h2>
                    <img src="{{ Storage::url($setting->timetable_image) }}" alt="Ramadan Timetable" class="mx-auto max-w-4xl rounded-xl shadow-2xl">
                </div>
            </section>
        @endif

        <!-- Today's Times -->
        @if($todayTimes)
            <section class="py-16 bg-white">
                <div class="container mx-auto px-6">
                    <h2 class="text-4xl font-bold text-center text-emerald-800 mb-10">Today's Timings ({{ now()->format('d M Y') }})</h2>
                    <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6 max-w-5xl mx-auto">
                        <div class="bg-emerald-50 p-6 rounded-xl text-center">
                            <h3 class="font-bold text-emerald-700">Sehr Ends</h3>
                            <p class="text-2xl">{{ $todayTimes->sehr_end ? $todayTimes->sehr_end->format('H:i') : 'N/A' }}</p>
                        </div>
                        <!-- Repeat for fajr, sunrise, dhuhr, asr, maghrib/iftar, isha -->
                    </div>
                </div>
            </section>
        @endif

        <!-- Events -->
        <section class="py-16 bg-emerald-50">
            <div class="container mx-auto px-6">
                <h2 class="text-4xl font-bold text-center text-emerald-900 mb-12">Upcoming Events</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($setting->events()->where('event_date', '>=', $today)->orderBy('event_date')->get() as $event)
                        <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">
                            <h3 class="text-2xl font-semibold text-emerald-700 mb-4">{{ $event->title }}</h3>
                            <p class="text-gray-700 mb-4">{{ $event->description }}</p>
                            <p class="font-medium">{{ $event->event_date->format('d M Y') }}
                                @if($event->start_time) {{ $event->start_time->format('H:i') }} @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Quran Verse section (static or from DB if you want) -->
@endsection



@section('footer')
    @include('partials.footer')

@endsection

@section('scripts')
    <script>
        const target = new Date("{{ $setting->countdown_target ?? '2026-02-18T00:00:00' }}").getTime();
        // same countdown logic as before...
    </script>
@endsection