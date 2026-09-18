@extends('main-layout')

@section('title', 'Marriage & Nikah Services - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <div>
                    <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold mb-4 border border-emerald-500/30 bg-emerald-500/10 text-emerald-400">
                        Sunnah Marriage Services
                    </span>
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">
                        A Blessed Start to <br><span style="color: #4ade80;">Your New Journey</span>
                    </h1>
                    <p class="text-xl text-gray-300 mb-10 leading-relaxed">
                        Ipswich Mosque provides a dignified, serene, and welcoming environment for your Nikah ceremony and family reception, strictly following Islamic traditions.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left mb-10">
                        <div class="flex items-center space-x-3">
                            <div class="p-1 rounded-full bg-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-gray-200 font-medium">Official Nikah Certificates</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="p-1 rounded-full bg-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-gray-200 font-medium">Spacious Hall Hire</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="p-1 rounded-full bg-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-gray-200 font-medium">Qualified Imams</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="p-1 rounded-full bg-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-gray-200 font-medium">Community Support</span>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('contact.index') }}"
                           class="inline-flex items-center justify-center gap-2 text-white font-bold py-4 px-8 rounded-xl transition duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg"
                           style="background-color: var(--brand-green);">
                            Inquire for Booking
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <p class="text-gray-400 text-sm mt-4">Contact us to check availability for your Nikah ceremony.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Our Commitment</h2>
                <div class="h-1.5 w-20 mx-auto rounded-full mb-6" style="background-color: var(--brand-green);"></div>
                <p class="text-lg text-gray-600">We provide holistic support to ensure your Islamic union is carried out with perfection (Ihsan).</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group bg-white rounded-3xl p-10 shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-emerald-100">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300" style="background-color: rgba(10, 81, 52, 0.05);">
                        <svg class="w-7 h-7" style="color: var(--brand-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nikah Procedure</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Conducted by our experienced imams, ensuring all Islamic pillars and conditions are met for a valid union.</p>
                    <ul class="space-y-3 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Formal Imam Officiation</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Official Nikah Certificate</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Spiritual Khutbah/Talk</li>
                    </ul>
                </div>

                <div class="group bg-white rounded-3xl p-10 shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-emerald-100">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300" style="background-color: rgba(10, 81, 52, 0.05);">
                        <svg class="w-7 h-7" style="color: var(--brand-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Venue Hire</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Our hall offers a clean, well-lit space for family gatherings and celebrations post-Nikah.</p>
                    <ul class="space-y-3 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Up to 200 Guests capacity</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Segregated Seating setup</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Local Parking Access</li>
                    </ul>
                </div>

                <div class="group bg-white rounded-3xl p-10 shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-emerald-100">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300" style="background-color: rgba(10, 81, 52, 0.05);">
                        <svg class="w-7 h-7" style="color: var(--brand-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Counseling</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">Bridging hearts and minds with pre-marital guidance based on the Quran and Sunnah.</p>
                    <ul class="space-y-3 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Pre-marital Counseling</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Conflict Resolution</li>
                        <li class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Family Rights Workshops</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('partials.footer')
@endsection