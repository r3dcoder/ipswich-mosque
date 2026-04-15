@extends('main-layout')

@section('title', 'Visit Us - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="visit-page-wrapper bg-white">
    
    <section class="relative py-20 bg-emerald-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/islamic-art.png');"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold mb-4 border border-emerald-400/30 bg-emerald-400/10 text-emerald-300">
                Welcome to our Place of Worship
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">Visit Ipswich Mosque</h1>
            <p class="text-xl text-emerald-100 max-w-3xl mx-auto leading-relaxed">
                Muslims are always delighted to show others their place of worship. It allows them to share something very dear to their heart. We welcome anyone who would like to visit, observe prayers, and participate in our activities.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-3xl font-bold mb-6 text-slate-900">Group & School Visits</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        The Ipswich and Suffolk Bangladeshi Mosque and Community Centre host many guests, visitors and dignitaries every year. 
                        Schools plan visits as part of their religious education curriculum and academics visit for historical and research purposes.
                    </p>
                    <div class="bg-slate-50 border border-slate-100 rounded-3xl p-8 mb-8">
                        <h4 class="font-bold text-emerald-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tour Information
                        </h4>
                        <p class="text-sm text-gray-500 mb-4 italic">Group visits are limited to a maximum of 30 people and last around one hour.</p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6 text-sm text-gray-700">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Mosque & Centre Tour</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> History and Role</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> The Purpose of the Imam</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Understanding Islam</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Questions & Answers</li>
                        </ul>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href={{ url('/contact') }} class="px-8 py-4 rounded-xl text-white font-bold text-center shadow-lg transition hover:opacity-90" style="background-color: var(--brand-green);">
                            Book via Email
                        </a>
                        <div class="p-4 border border-dashed border-gray-300 rounded-xl text-xs text-gray-500">
                            <strong>Note:</strong> All visits must be <br> arranged in advance.
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-emerald-100 rounded-3xl -rotate-2"></div>
                        <img src="{{ asset('images/inside of ipswichmosque.jpg') }}" class="relative rounded-3xl shadow-xl w-full object-cover h-[450px]" alt="Mosque Interior">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl font-bold mb-4">Etiquette & Dress Code</h2>
                <p class="text-gray-500">As a place of worship, we kindly ask our guests to observe the following decorum to maintain the sanctity of the prayer halls.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">What to Wear</h3>
                    <p class="text-gray-500 text-sm mb-4">Modest, loose-fitting clothes are required.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>• Men: Long pants and sleeves.</li>
                        <li>• Women: Baggy pants or full-length skirts.</li>
                        <li>• Headscarves for women in prayer halls.</li>
                        <li>• No shorts or revealing clothing.</li>
                    </ul>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Inside the Mosque</h3>
                    <p class="text-gray-500 text-sm mb-4">Help us keep the carpeted areas pure for prayer.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>• Remove shoes at the entry point.</li>
                        <li>• Storage racks are provided.</li>
                        <li>• Silence or power-off cell phones.</li>
                        <li>• Avoid walking in front of those praying.</li>
                    </ul>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] shadow-sm hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Interactions</h3>
                    <p class="text-gray-500 text-sm mb-4">Cultural sensitivity is appreciated.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>• Limit noise during congregational prayer.</li>
                        <li>• Respect gender boundaries (handshakes).</li>
                        <li>• Take loud conversations to the lobby.</li>
                        <li>• Ask first before photography.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Frequently Asked Questions</h2>
                <div class="h-1 w-20 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <details class="group border border-gray-100 bg-gray-50 rounded-2xl p-6 transition-all open:ring-2 open:ring-emerald-500/20">
                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-slate-800">
                        Where do the women pray?
                        <span class="text-emerald-600 transition group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                        Women offer prayers towards the back of the prayer hall or in the upstairs gallery that provides them privacy and comfort.
                    </p>
                </details>

                <details class="group border border-gray-100 bg-gray-50 rounded-2xl p-6 transition-all open:ring-2 open:ring-emerald-500/20">
                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-slate-800">
                        What are the foot sinks in the bathroom for?
                        <span class="text-emerald-600 transition group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                        Muslims are supposed to be in a state of physical purification (Wudu) before making the prayer, which includes washing the feet to ensure cleanliness before standing before Allah.
                    </p>
                </details>

                <details class="group border border-gray-100 bg-gray-50 rounded-2xl p-6 transition-all open:ring-2 open:ring-emerald-500/20">
                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-slate-800">
                        What happens when people join the prayer late?
                        <span class="text-emerald-600 transition group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="mt-4 text-gray-600 text-sm leading-relaxed">
                        They join the prayer already in progress. After the imam has finished the prayer with the final 'Salam', latecomers stand up to complete whatever cycles (Rak'ahs) they missed individually.
                    </p>
                </details>

                <details class="group border border-gray-100 bg-gray-50 rounded-2xl p-6 transition-all open:ring-2 open:ring-emerald-500/20">
                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-slate-800">
                        How do Friday prayers work?
                        <span class="text-emerald-600 transition group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <div class="mt-4 text-gray-600 text-sm leading-relaxed space-y-2">
                        <p>Friday is the day of congregational prayers. The service begins with the call to prayer (Adhan), followed by a sermon (Khutbah) which consists of two short lectures with a brief pause in the middle.</p>
                        <p>After the sermon, the congregation stands to follow the Imam in a short prayer.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group relative overflow-hidden bg-emerald-800 rounded-[2.5rem] p-10 text-white shadow-lg transition-transform hover:-translate-y-2">
                    <div class="absolute -right-10 -bottom-10 opacity-10 transition-transform group-hover:scale-125">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-4">Support Our Mosque</h3>
                        <p class="text-emerald-100 mb-8 max-w-sm">Your generosity allows us to maintain the center and continue our community services.</p>
                        <a href="/donate" class="inline-block bg-white text-emerald-900 px-8 py-3 rounded-xl font-bold shadow-md hover:bg-emerald-50 transition">Donate Now</a>
                    </div>
                </div>

                <div class="group relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-lg transition-transform hover:-translate-y-2">
                    <div class="absolute -right-10 -bottom-10 opacity-10 transition-transform group-hover:scale-125">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2zm0-7h2v5h-2z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-bold mb-4">Principles of Islam</h3>
                        <p class="text-slate-400 mb-8 max-w-sm">Discover the core beliefs, history, and the beautiful way of life for millions of Muslims.</p>
                        <a href="/principles" class="inline-block bg-slate-800 border border-slate-700 text-white px-8 py-3 rounded-xl font-bold shadow-md hover:bg-slate-700 transition">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* Prevent default marker on accordion */
    summary::-webkit-details-marker { display: none; }
</style>
@endsection

@section('footer')
    @include('partials.footer')
@endsection