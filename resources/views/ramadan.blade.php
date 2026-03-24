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

    <section class="relative text-white py-20 md:py-28 overflow-hidden" style="background: linear-gradient(135deg, #022c22 0%, #064e3b 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-5 py-2 mb-8 rounded-full bg-white/10 border border-white/20 backdrop-blur-md">
                <span class="text-amber-400 text-lg">🌙</span>
                <span class="text-white font-bold tracking-widest uppercase text-sm">Ipswich Mosque & Islamic Centre</span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black mb-8 tracking-tighter leading-tight">
                {{ $setting->title ?? 'Ramadan Mubarak' }}
            </h1>
            
            <p class="text-2xl md:text-3xl mb-12 max-w-3xl mx-auto font-medium leading-relaxed" style="color: #a7f3d0;">
                {{ $setting->hero_message ?? 'May Allah accept our fasting, prayers and good deeds.' }}
            </p>

            <div class="mx-auto max-w-2xl">
                <div id="countdown" class="grid grid-cols-4 gap-4 md:gap-8">
                    <div class="bg-white/10 backdrop-blur-xl border-2 border-white/20 rounded-[2rem] py-6 shadow-2xl">
                        <span id="days" class="text-5xl md:text-7xl font-black block mb-1">00</span>
                        <span class="text-xs md:text-sm uppercase font-black tracking-widest opacity-70">Days</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xl border-2 border-white/20 rounded-[2rem] py-6 shadow-2xl">
                        <span id="hours" class="text-5xl md:text-7xl font-black block mb-1">00</span>
                        <span class="text-xs md:text-sm uppercase font-black tracking-widest opacity-70">Hours</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-xl border-2 border-white/20 rounded-[2rem] py-6 shadow-2xl">
                        <span id="minutes" class="text-5xl md:text-7xl font-black block mb-1">00</span>
                        <span class="text-xs md:text-sm uppercase font-black tracking-widest opacity-70">Mins</span>
                    </div>
                    <div class="bg-emerald-500/30 backdrop-blur-xl border-2 border-emerald-400/40 rounded-[2rem] py-6 shadow-2xl">
                        <span id="seconds" class="text-5xl md:text-7xl font-black block mb-1 text-emerald-300">00</span>
                        <span class="text-xs md:text-sm uppercase font-black tracking-widest text-emerald-200">Secs</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="relative z-30 -mt-12 container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-[2rem] shadow-2xl border-b-8 border-amber-500 transform hover:-translate-y-1 transition-transform">
                <div class="flex items-center gap-4 mb-3">
                    <span class="text-3xl">⭐</span>
                    <h4 class="text-xl font-black text-gray-900 uppercase">Isha & Tarawih</h4>
                </div>
                <p class="text-gray-600 font-medium">Please see the calendar below for updated daily prayer times.</p>
            </div>
            
            <div class="p-8 rounded-[2rem] shadow-2xl text-white transform hover:-translate-y-1 transition-transform" style="background-color: #059669;">
                <div class="flex items-center gap-4 mb-3">
                    <span class="text-3xl">🕌</span>
                    <h4 class="text-xl font-black uppercase">Eid Jamat</h4>
                </div>
                <p class="text-lg font-bold">1st: 8:00 | 2nd: 9:00 | 3rd: 10:30</p>
            </div>

            <div class="bg-gray-900 p-8 rounded-[2rem] shadow-2xl text-gray-300 flex flex-col justify-center">
                <p class="text-sm italic leading-relaxed font-medium">
                    "All Islamic dates and festivals are subject to the sighting of the moon."
                </p>
            </div>
        </div>
    </div>

    @if($setting && $setting->timetable_image)
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">Official Timetable 2027</h2>
                <div class="w-24 h-2 bg-emerald-600 mx-auto rounded-full"></div>
            </div>

            <div class="max-w-5xl mx-auto group">
                <div class="bg-white p-4 md:p-8 rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden relative">
                    <img src="{{ Storage::url($setting->timetable_image) }}" 
                         alt="Ramadan Timetable" 
                         class="w-full h-auto rounded-[2rem] shadow-inner transition-transform duration-500 group-hover:scale-[1.01]">
                    
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a href="{{ Storage::url($setting->timetable_image) }}" target="_blank" 
                           class="px-10 py-5 bg-gray-900 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-black transition shadow-xl text-sm">
                           🔍 View Full Resolution
                        </a>
                        <a href="{{ Storage::url($setting->timetable_image) }}" download 
                           class="px-10 py-5 bg-emerald-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-xl text-sm">
                           📥 Download Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-12 gap-16">
                
                <div class="lg:col-span-8 space-y-16">
                    <div>
                        <h2 class="text-4xl font-black text-gray-900 mb-8 border-l-8 border-emerald-600 pl-6">What is the Month of Ramadan?</h2>
                        <div class="text-xl text-gray-700 leading-relaxed space-y-6">
                            <p>
                                The month of Ramadan is the ninth month of the Islamic calendar and it is observed by Muslims all over the world as a month of <strong>Sawm (fasting)</strong>. 
                            </p>
                            <p class="bg-emerald-50 p-8 rounded-[2rem] border-2 border-emerald-100 italic font-medium text-emerald-900">
                                "It is Allah's Own month. It is the chief of all months and the most glorious one." — Prophet Muhammad ﷺ
                            </p>
                            <p>
                                Fasting is one of the important five 'pillars' of Islam and it is during Ramadan which fasting has been made obligatory for all adult Muslims.
                            </p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="p-10 rounded-[2.5rem] border-2 border-gray-100 bg-emerald-50">
                            <h3 class="text-2xl font-black text-emerald-900 mb-6 uppercase">Sunnah of Fasting</h3>
                            <ul class="space-y-4 text-lg text-emerald-800 font-bold">
                                <li class="flex gap-3"><span>✅</span> Pre-dawn meal (Suhoor)</li>
                                <li class="flex gap-3"><span>✅</span> Delaying Suhoor</li>
                                <li class="flex gap-3"><span>✅</span> Hastening in Iftar</li>
                                <li class="flex gap-3"><span>✅</span> Breaking fast with Dates</li>
                                <li class="flex gap-3"><span>✅</span> Sincere Dua at Iftar</li>
                                <li class="flex gap-3"><span>✅</span> Studying the Holy Qur’an</li>
                            </ul>
                        </div>
                        <div class="p-10 rounded-[2.5rem] border-2 border-gray-100 bg-amber-50">
                            <h3 class="text-2xl font-black text-amber-900 mb-6 uppercase">Breaking with Dates</h3>
                            <p class="text-lg text-amber-800 leading-relaxed font-medium">
                                "He should break his fast with dates, but if he cannot get any, then he should break his fast with water as that is very purifying."
                            </p>
                            <p class="mt-6 text-base text-amber-700/80 italic">
                                Dates help increase glucose levels quickly after a long day of fasting and start the digestive process.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-8">
                    <div class="sticky top-8">
                        <div class="bg-gray-900 rounded-[3rem] p-10 text-white shadow-2xl border-4 border-emerald-500/30">
                            <h3 class="text-3xl font-black mb-4 tracking-tighter uppercase">Zakat-ul-Fitr</h3>
                            <p class="text-gray-400 font-medium mb-8 leading-relaxed">Required for every adult Muslim and their dependants before Eid prayers.</p>
                            
                            <div class="bg-white/10 p-6 rounded-3xl mb-8 flex justify-between items-center border border-white/10">
                                <span class="text-lg font-bold opacity-70">Amount</span>
                                <span class="text-5xl font-black text-emerald-400">£5.00</span>
                            </div>
                            
                            <a href="/donate" class="block w-full py-6 text-center bg-emerald-600 rounded-2xl font-black text-xl hover:bg-emerald-500 transition shadow-lg uppercase tracking-widest">
                                Donate Now
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

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
            document.getElementById('countdown').innerHTML = `<div class="text-4xl font-black text-emerald-300 uppercase tracking-widest col-span-4 py-10">Ramadan Mubarak! 🌙</div>`;
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