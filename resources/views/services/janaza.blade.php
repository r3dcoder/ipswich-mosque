@extends('main-layout')

@section('title', 'Janaza Services - Ipswich Mosque')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">
                        Janaza (Funeral) Services
                    </h1>
                    <p class="text-lg text-gray-300 mb-8">
                        We provide compassionate funeral services following Islamic traditions, 
                        supporting families during their time of loss.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Janaza Prayer</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Burial Arrangements</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Ghusl (Washing) Services</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Family Support</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-2xl">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Contact for Janaza</h3>
                            <p class="text-gray-600 mb-6">For immediate assistance, please call us</p>
                            <a href="tel:+441473123456" class="w-full inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                                Call: +44 (0) 1473 123 456
                            </a>
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
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Janaza Services</h2>
                <p class="text-lg text-gray-600">We provide comprehensive funeral services with dignity and respect</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Janaza Prayer</h3>
                    <p class="text-gray-600">
                        We conduct Janaza prayers at the mosque following the Islamic tradition, 
                        with the community coming together to pray for the deceased.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Burial Services</h3>
                    <p class="text-gray-600">
                        We assist with burial arrangements at local Muslim cemeteries, 
                        ensuring the deceased is laid to rest according to Islamic guidelines.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Family Support</h3>
                    <p class="text-gray-600">
                        Our community provides emotional and practical support to bereaved families 
                        during their time of grief, including meal coordination and counseling.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection