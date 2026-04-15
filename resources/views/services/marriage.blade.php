@extends('main-layout')

@section('title', 'Marriage & Nikah Services - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
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
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                </div>

                <div class="relative">
                    <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-2xl border border-gray-100">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg" style="background-color: rgba(10, 81, 52, 0.1);">
                                <svg class="w-8 h-8" style="color: var(--brand-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Inquire for Booking</h3>
                            <p class="text-gray-500">Fill the details below to check availability</p>
                        </div>

                        @if(session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('marriage.booking.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                                    <input type="text" id="name" name="name" required placeholder="Full Name"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email Address</label>
                                    <input type="email" id="email" name="email" required placeholder="email@example.com"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" placeholder="07123 456789"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label for="service_type" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Service Type</label>
                                    <select id="service_type" name="service_type" required
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all bg-white">
                                        <option value="">Select type</option>
                                        <option value="nikah">Nikah Only</option>
                                        <option value="reception">Reception Only</option>
                                        <option value="both">Nikah & Reception</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="proposed_date" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Proposed Date</label>
                                    <input type="date" id="proposed_date" name="proposed_date"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label for="proposed_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Proposed Time</label>
                                    <input type="time" id="proposed_time" name="proposed_time"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                                <div>
                                    <label for="expected_guests" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Number of Guests</label>
                                    <input type="number" id="expected_guests" name="expected_guests" min="1" placeholder="e.g. 50"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Additional Requirements</label>
                                <textarea id="message" name="message" rows="3" placeholder="Tell us about special requirements..."
                                          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full text-white font-bold py-4 px-6 rounded-xl transition duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg"
                                    style="background-color: var(--brand-green);">
                                Submit Booking Request
                            </button>
                        </form>
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