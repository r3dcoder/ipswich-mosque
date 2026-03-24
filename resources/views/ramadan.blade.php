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

    <section class="relative text-white py-24 md:py-32 overflow-hidden" style="background: linear-gradient(135deg, #022c22 0%, #064e3b 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <span class="inline-block px-4 py-1 mb-6 border border-emerald-400/30 rounded-full bg-emerald-500/10 text-emerald-100 text-sm font-medium tracking-widest uppercase">
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
            <div class="p-5 shadow-lg rounded-r-xl border-l-4 border-amber-500" style="background-color: #fffbeb;">
                <h4 class="font-bold flex items-center gap-2" style="color: #78350f;">🌙 Isha & Tarawih</h4>
                <p class="text-sm" style="color: #92400e;">Please check the calendar below for daily updated times.</p>
            </div>
            <div class="text-white p-5 shadow-lg rounded-xl" style="background-color: #059669;">
                <h4 class="font-bold flex items-center gap-2">🕌 Eid Jamat Times</h4>
                <p class="text-xs opacity-90">1st: 8:00am | 2nd: 9:00am | 3rd: 10:30am</p>
            </div>
            <div class="bg-white border p-5 shadow-lg rounded-xl flex items-center">
                <p class="text-xs text-gray-500 italic">* All Islamic dates and festivals are subject to the sighting of the moon.</p>
            </div>
        </div>
    </div>

    @if($setting && $setting->timetable_image)
    <section class="py-20" style="background-color: #f9fafb;">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900">Ramadan Timetable 2027</h2>
                    <p class="font-medium" style="color: #047857;">Official prayer times for Ipswich Mosque</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ Storage::url($setting->timetable_image) }}" target="_blank" class="px-6 py-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm font-medium">View Full Size</a>
                    <a href="{{ Storage::url($setting->timetable_image) }}" download class="px-6 py-3 text-white rounded-xl transition shadow-md font-medium" style="background-color: #047857;">Download Image</a>
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
                            <span style="color: #059669;" class="text-4xl">01</span> What is Ramadan?
                        </h2>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            The month of Ramadan is the ninth month of the Islamic calendar and it is observed by Muslims all over the world as a month of <strong>Sawm (fasting)</strong>. It begins immediately upon the end of the eighth month and lasts for 29 to 30 days.
                        </p>
                        <blockquote class="border-l-4 border-emerald-500 pl-4 py-2 italic text-gray-700 bg-emerald-50/50">
                            As Holy Prophet Muhammad ﷺ said: "It is Allah's Own month". It is the chief of all months and the most glorious one.
                        </blockquote>
                    </div>

                    <div class="p-8 rounded-3xl border" style="background-color: #ecfdf5; border-color: #d1fae5;">
                        <h3 class="text-xl font-bold mb-4" style="color: #064e3b;">Sunnah of Fasting</h3>
                        <ul class="grid md:grid-cols-2 gap-4 text-sm" style="color: #065f46;">
                            <li class="flex items-start gap-2"><span>✔</span> Pre-dawn meal (Suhoor)</li>
                            <li class="flex items-start gap-2"><span>✔</span> Delaying Suhoor is Sunnah</li>
                            <li class="flex items-start gap-2"><span>✔</span> Hastening in Iftar</li>
                            <li class="flex items-start gap-2"><span>✔</span> Breaking fast before Maghrib</li>
                            <li class="flex items-start gap-2"><span>✔</span> Virtues of Dua at Iftar</li>
                            <li class="flex items-start gap-2"><span>✔</span> Studying the Qur’an</li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="p-8 rounded-3xl border relative overflow-hidden" style="background-color: #fffbeb; border-color: #fef3c7;">
                        <h3 class="text-2xl font-bold mb-4" style="color: #78350f;">Breaking Fast With Dates</h3>
                        <p class="text-sm leading-relaxed" style="color: #92400e;">
                            "When one of you is fasting, he should break his fast with dates, but if he cannot get any, then he should break his fast with water as that is very purifying." (Prophet Mohammed ﷺ)
                        </p>
                        <p class="text-xs mt-4" style="color: #b45309;">Dates are rich in sugar and nutrients, helping to increase glucose levels quickly after a long day of fasting.</p>
                    </div>

                    <div class="text-white p-8 rounded-[2rem] shadow-2xl" style="background-color: #064e3b;">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold uppercase tracking-wider">ZAKAT-UL-FITR</h3>
                                <p class="text-emerald-300 text-xs">Required before Eid Prayers</p>
                            </div>
                            <div class="text-white px-4 py-2 rounded-2xl font-bold text-3xl shadow-inner" style="background-color: #059669;">
                                £5.00
                            </div>
                        </div>
                        <p class="text-sm opacity-90 mb-6 leading-relaxed">
                            Every adult Muslim who possesses food in excess of their needs must pay Fitrana. This can be paid during Ramadan so that the poor can enjoy the day of Eid.
                        </p>
                        <a href="/donate" class="block w-full text-center bg-white font-bold py-4 rounded-xl hover:bg-emerald-50 transition" style="color: #064e3b;">
                            Pay Fitrana Online
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($setting && $setting->events->isNotEmpty())
    <section class="py-20 border-t" style="background-color: #f9fafb;">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Ramadan Events</h2>
                <div class="w-20 h-1 mx-auto rounded-full" style="background-color: #059669;"></div>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($setting->events->sortBy('event_date') as $event)
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                        <span class="text-xs font-bold px-3 py-1 rounded-full uppercase" style="background-color: #ecfdf5; color: #059669;">
                            {{ $event->event_date->format('l, d M') }}
                        </span>
                        <h3 class="text-xl font-bold mt-4 mb-2 text-gray-800">{{ $event->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4">{{ Str::limit($event->description, 120) }}</p>
                        <div class="flex items-center text-xs text-gray-400 gap-4">
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

@section('footer')
    @include('partials.footer')
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