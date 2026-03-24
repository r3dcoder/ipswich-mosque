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

    <section class="relative text-white py-24 md:py-32 overflow-hidden" style="background: linear-gradient(to bottom right, #022c22, #064e3b);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <span class="inline-block px-4 py-1 mb-6 border border-emerald-400/30 rounded-full bg-emerald-500/10 text-emerald-200 text-sm font-medium tracking-widest uppercase">
                Ipswich Mosque & Islamic Centre
            </span>
            <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight">
                {{ $setting->title ?? 'Ramadan Mubarak 1448 AH' }}
            </h1>
            <p class="text-xl md:text-2xl mb-12 max-w-2xl mx-auto font-light" style="color: #d1fae5;">
                {{ $setting->hero_message ?? 'May Allah accept our fasting, prayers and good deeds.' }}
            </p>

            <div class="mx-auto max-w-xl bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 shadow-2xl">
                <div id="countdown" class="grid grid-cols-4 gap-4 text-center">
                    <div class="bg-white/10 rounded-2xl py-4"><span id="days" class="text-4xl md:text-5xl font-bold block">00</span><span class="text-[10px] uppercase tracking-tighter opacity-70">Days</span></div>
                    <div class="bg-white/10 rounded-2xl py-4"><span id="hours" class="text-4xl md:text-5xl font-bold block">00</span><span class="text-[10px] uppercase tracking-tighter opacity-70">Hours</span></div>
                    <div class="bg-white/10 rounded-2xl py-4"><span id="minutes" class="text-4xl md:text-5xl font-bold block">00</span><span class="text-[10px] uppercase tracking-tighter opacity-70">Mins</span></div>
                    <div class="bg-white/10 rounded-2xl py-4"><span id="seconds" class="text-4xl md:text-5xl font-bold block">00</span><span class="text-[10px] uppercase tracking-tighter opacity-70">Secs</span></div>
                </div>
            </div>
        </div>
    </section>

    <div class="relative z-20 -mt-10 container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-amber-50 border-l-4 border-amber-500 p-5 shadow-lg rounded-r-xl">
                <h4 class="font-bold text-amber-900 flex items-center gap-2">🌙 Isha & Tarawih</h4>
                <p class="text-sm text-amber-800">Please check the calendar below for daily updated times.</p>
            </div>
            <div class="bg-emerald-600 text-white p-5 shadow-lg rounded-xl">
                <h4 class="font-bold flex items-center gap-2">🕌 Eid Jamat Times</h4>
                <p class="text-xs opacity-90">1st: 8:00am | 2nd: 9:00am | 3rd: 10:30am</p>
            </div>
            <div class="bg-white border p-5 shadow-lg rounded-xl flex items-center">
                <p class="text-xs text-gray-500 italic">* All Islamic dates are subject to the sighting of the moon.</p>
            </div>
        </div>
    </div>

    @if($setting && $setting->timetable_image)
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900">Ramadan Timetable</h2>
                    <p class="text-emerald-700 font-medium">Ipswich Mosque Official Prayer Times</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ Storage::url($setting->timetable_image) }}" target="_blank" class="px-6 py-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium">View Full Size</a>
                    <a href="{{ Storage::url($setting->timetable_image) }}" download class="px-6 py-3 bg-emerald-700 text-white rounded-xl hover:bg-emerald-800 transition shadow-md font-medium">Download Image</a>
                </div>
            </div>

            <div class="bg-white p-4 rounded-[2.5rem] shadow-xl border border-gray-100">
                <img src="{{ Storage::url($setting->timetable_image) }}" alt="Ramadan Timetable" class="w-full rounded-[2rem]">
            </div>
        </div>
    </section>
    @endif

    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                
                <div class="space-y-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span class="text-emerald-600 text-4xl">01</span> What is Ramadan?
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            The month of Ramadan is the ninth month of the Islamic calendar and it is observed by Muslims all over the world as a month of <strong>Sawm (fasting)</strong>. As Holy Prophet Muhammad ﷺ said: "It is Allah's Own month."
                        </p>
                    </div>

                    <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                        <h3 class="text-xl font-bold text-emerald-900 mb-4">The Sunnah of Fasting</h3>
                        <ul class="grid md:grid-cols-2 gap-4 text-sm text-emerald-800">
                            <li class="flex items-start gap-2"><span>✔</span> Taking pre-dawn meal (Suhoor)</li>
                            <li class="flex items-start gap-2"><span>✔</span> Hastening in Iftar</li>
                            <li class="flex items-start gap-2"><span>✔</span> Virtues of Dua at Iftar</li>
                            <li class="flex items-start gap-2"><span>✔</span> Studying the Qur’an</li>
                            <li class="flex items-start gap-2"><span>✔</span> Being extra generous</li>
                            <li class="flex items-start gap-2"><span>✔</span> Striving in the last 10 days</li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-amber-50 p-8 rounded-3xl border border-amber-100 relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold text-amber-900 mb-4">Why break fast with Dates?</h3>
                            <p class="text-amber-800 text-sm leading-relaxed">
                                Prophet Mohammed ﷺ said: "When one of you is fasting, he should break his fast with dates, but if he cannot get any, then he should break his fast with water as that is very purifying." Dates are rich in nutrients and help increase glucose levels quickly after a long day of fasting.
                            </p>
                        </div>
                        <span class="absolute -bottom-4 -right-4 text-7xl opacity-10">🌴</span>
                    </div>

                    <div class="bg-emerald-900 text-white p-8 rounded-[2rem] shadow-2xl">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold uppercase tracking-wider">Zakat-ul-Fitr</h3>
                                <p class="text-emerald-300 text-xs">Fitrana 1448 AH</p>
                            </div>
                            <div class="bg-emerald-500 text-white px-4 py-2 rounded-2xl font-bold text-2xl">
                                £5.00
                            </div>
                        </div>
                        <p class="text-sm opacity-80 mb-6">Every adult Muslim who possesses food in excess of their needs must pay this before Eid prayer. The head of household can pay for all dependants.</p>
                        <a href="/donate" class="block w-full text-center bg-white text-emerald-900 font-bold py-4 rounded-xl hover:bg-emerald-50 transition">Pay Fitrana Online</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if($setting && $setting->events->isNotEmpty())
    <section class="py-20 bg-gray-50 border-t">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Masjid Programs</h2>
                <div class="w-20 h-1 bg-emerald-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($setting->events->sortBy('event_date') as $event)
                    <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full uppercase">{{ $event->event_date->format('l, d M') }}</span>
                        <h3 class="text-xl font-bold mt-4 mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-800 text-sm mb-4">{{ Str::limit($event->description) }}</p>
                        <div class="flex items-center text-xs text-red-800 gap-4">
                            <span>🕒 {{ $event->start_time->format('H:i') }}</span>
                            @if($event->location)<span>📍 {{ $event->location }}</span>@endif
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
            document.getElementById('countdown').innerHTML = `<div class="col-span-4 text-3xl font-bold text-emerald-300">Ramadan Mubarak! 🌙</div>`;
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