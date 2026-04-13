@extends('main-layout')

@section('title', 'Visit Mosque - Ipswich Mosque')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">
                        Visit Our Mosque
                    </h1>
                    <p class="text-lg text-gray-300 mb-8">
                        We welcome visitors of all faiths to experience our mosque, 
                        learn about Islam, and participate in our community activities.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Guided Tours Available</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Open Days & Events</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Educational Programs</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Interfaith Dialogue</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-2xl">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Visit Us</h3>
                            <p class="text-gray-600 mb-6">123 Mosque Road, Ipswich, IP1 1AB</p>
                            <div class="space-y-3">
                                <div class="flex items-center justify-center space-x-2 text-gray-700">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Open Daily: 5:00 AM - 9:00 PM</span>
                                </div>
                                <a href="{{ url('/contact') }}" class="w-full inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                                    Contact Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Visitor Information</h2>
                <p class="text-lg text-gray-600">Everything you need to know about visiting our mosque</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Dress Code</h3>
                    <p class="text-gray-600">
                        Please dress modestly. Women should cover their hair, arms, and legs. 
                        Men should wear long trousers. Head coverings are provided at the entrance.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Prayer Times</h3>
                    <p class="text-gray-600">
                        Visitors are welcome to observe or participate in our five daily prayers. 
                        Please arrive 10-15 minutes before prayer time.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Community</h3>
                    <p class="text-gray-600">
                        Our mosque is a welcoming space for people of all backgrounds. 
                        Feel free to ask questions and engage with our community members.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection