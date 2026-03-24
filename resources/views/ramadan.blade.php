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

    <section class="relative text-white py-20 md:py-28 overflow-hidden" 
             style="background: linear-gradient(135deg, #06201e 0%, #134e4a 100%); min-height: 500px;">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-6 py-2 mb-8 border border-white/20 backdrop-blur-md" 
                 style="background-color: rgba(255,255,255,0.1); border-radius: 50px;">
                <span style="color: #fbbf24; font-size: 1.5rem;">🌙</span>
                <span class="text-white font-black tracking-widest uppercase" style="font-size: 0.85rem;">Ipswich Mosque & Islamic Centre</span>
            </div>
            
            <h1 class="font-black mb-8 tracking-tighter leading-tight" style="font-size: clamp(3rem, 10vw, 6rem);">
                {{ $setting->title ?? 'Ramadan Mubarak' }}
            </h1>
            
            <p class="mb-12 max-w-3xl mx-auto font-medium leading-relaxed" style="color: #ccfbf1; font-size: 1.75rem;">
                {{ $setting->hero_message ?? 'May Allah accept our fasting, prayers and good deeds.' }}
            </p>

            <div class="mx-auto max-w-2xl">
                <div id="countdown" class="grid grid-cols-4 gap-4 md:gap-8">
                    @foreach(['Days' => 'days', 'Hours' => 'hours', 'Mins' => 'minutes'] as $label => $id)
                    <div class="backdrop-blur-xl border-2 border-white/20 shadow-2xl py-8" 
                         style="background-color: rgba(255,255,255,0.1); border-radius: 35px;">
                        <span id="{{ $id }}" class="text-5xl md:text-7xl font-black block mb-1">00</span>
                        <span class="uppercase font-black tracking-widest opacity-70" style="font-size: 0.8rem;">{{ $label }}</span>
                    </div>
                    @endforeach
                    <div class="backdrop-blur-xl border-2 border-teal-400/40 shadow-2xl py-8" 
                         style="background-color: rgba(20, 184, 166, 0.3); border-radius: 35px;">
                        <span id="seconds" class="text-5xl md:text-7xl font-black block mb-1" style="color: #5eead4;">00</span>
                        <span class="uppercase font-black tracking-widest" style="color: #99f6e4; font-size: 0.8rem;">Secs</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="relative z-30 -mt-12 container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-8 shadow-2xl border-b-8 border-amber-500" style="border-radius: 30px;">
                <h4 class="text-2xl font-black text-gray-900 uppercase mb-3" style="color: #0f172a;">⭐ Isha & Tarawih</h4>
                <p class="text-gray-600 font-bold text-lg">{{ $setting->esha_and_taraweeh ?? 
                'Please see calendar for updated time.' }}</p>
            </div>
            
            <div class="p-8 shadow-2xl text-white" style="background-color: #0d9488; border-radius: 30px;">
                <h4 class="text-2xl font-black uppercase mb-3">🕌 Eid Jamat</h4>
                <p class="text-xl font-black">{{ $setting->eid_jamat ?? '1st: 8:00 | 2nd: 9:00 | 3rd: 10:30' }}</p>
            </div>

            <div class="bg-gray-900 p-8 shadow-2xl text-gray-300 flex items-center" style="border-radius: 30px;">
                <p class="text-sm italic leading-relaxed font-bold">
                    "All Islamic dates and festivals are subject to the sighting of the moon."
                </p>
            </div>
        </div>
    </div>

    @if($setting && $setting->timetable_image)
    <section class="py-24" style="background-color: #f3f4f6;">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-5xl font-black text-gray-900 mb-4">Official Timetable 2027</h2>
            <div class="w-32 h-3 mx-auto rounded-full mb-12" style="background-color: #0d9488;"></div>

            <div class="max-w-5xl mx-auto bg-white p-6 md:p-10 shadow-2xl border border-gray-200" style="border-radius: 50px;">
                <img src="{{ Storage::url($setting->timetable_image) }}" 
                     alt="Ramadan Timetable" 
                     class="w-full h-auto shadow-lg" style="border-radius: 30px;">
                
                <div class="mt-10 flex flex-wrap justify-center gap-6">
                    <a href="{{ Storage::url($setting->timetable_image) }}" target="_blank" 
                       class="px-10 py-5 bg-gray-900 text-white font-black uppercase tracking-widest text-sm hover:bg-black transition" style="border-radius: 20px;">
                       🔍 View Full Screen
                    </a>
                    <a href="{{ Storage::url($setting->timetable_image) }}" download 
                       class="px-10 py-5 text-white font-black uppercase tracking-widest text-sm hover:opacity-90 transition" style="background-color: #0d9488; border-radius: 20px;">
                       📥 Download Timetable
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-12 gap-16 items-start">
                
                <div class="lg:col-span-7 space-y-12">
                    <div class="article">
                        <h2 class="text-4xl font-black text-gray-900 mb-8 border-l-8 pl-8" style="border-color: #0d9488;">What is the Month of Ramadan?</h2>
                        <div class="text-xl text-gray-700 leading-relaxed space-y-8">
                            <p>The month of Ramadan is the ninth month of the Islamic calendar and it is observed by Muslims all over the world as a month of <strong>Sawm (fasting)</strong>.</p>
                            
                            <div class="p-10 italic font-bold border-4 border-dashed" style="background-color: #f0fdfa; border-color: #2dd4bf; border-radius: 40px; color: #134e4a;">
                                "It is Allah's Own month. It is the chief of all months and the most glorious one." — Prophet Muhammad ﷺ
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="p-8 border-2" style="background-color: #f0fdfa; border-color: #ccfbf1; border-radius: 35px;">
                            <h3 class="text-2xl font-black mb-6 uppercase tracking-tight" style="color: #134e4a;">Sunnah of Fasting</h3>
                            <ul class="space-y-4 text-lg font-bold" style="color: #115e59;">
                                <li>✅ Pre-dawn meal (Suhoor)</li>
                                <li>✅ Delaying Suhoor is Sunnah</li>
                                <li>✅ Hastening in Iftar</li>
                                <li>✅ Breaking fast with Dates</li>
                                <li>✅ Sincere Dua at Iftar</li>
                            </ul>
                        </div>
                        <div class="p-8 border-2" style="background-color: #fffbeb; border-color: #fef3c7; border-radius: 35px;">
                            <h3 class="text-2xl font-black text-amber-900 mb-6 uppercase tracking-tight">Why Dates?</h3>
                            <p class="text-lg text-amber-900 font-bold leading-relaxed">
                                "He should break his fast with dates, but if he cannot get any, then he should break his fast with water as that is very purifying."
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="sticky top-10">
                        <div class="text-white p-12 shadow-2xl border-4 border-teal-500/30" 
                             style="background-color: #134e4a; border-radius: 50px;">
                            <h3 class="text-4xl font-black mb-6 tracking-tighter uppercase">ZAKAT-UL-FITR</h3>
                            <p class="text-teal-100 text-lg font-medium mb-10 leading-relaxed">
                                Every adult Muslim who possesses food in excess of their needs must pay Fitrana before Eid prayers.
                            </p>
                            
                            <div class="p-8 rounded-[2rem] mb-10 flex justify-between items-center border-2 border-white/10" 
                                 style="background-color: rgba(255,255,255,0.05);">
                                <span class="text-xl font-bold opacity-80 uppercase tracking-widest">Rate {{ $setting->year??2027 }}</span>
                                <span class="text-6xl font-black text-white" style="color: #2dd4bf;">£{{ $setting->fitrana??10 }}</span>
                            </div>
                            
                            <a href="/donate" class="block w-full py-6 text-center bg-white font-black text-2xl hover:bg-teal-50 transition shadow-xl uppercase tracking-tighter" 
                               style="border-radius: 25px; color: #134e4a;">
                                PAY FITRANA NOW
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
            document.getElementById('countdown').innerHTML = `<div class="text-4xl font-black text-teal-400 uppercase tracking-widest col-span-4 py-10">Ramadan Mubarak! 🌙</div>`;
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('days').innerText = String(days).padStart(2, '0');
        document.getElementById('hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
        document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>