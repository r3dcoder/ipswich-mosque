@extends('main-layout')

@section('title', 'Marriage/Nikah Services - Ipswich Mosque')


@section('header')
    @include('partials.header')
@endsection
@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">
                        Marriage & Nikah Services
                    </h1>
                    <p class="text-lg text-gray-300 mb-8">
                        Celebrate your special day with us. Ipswich Mosque provides a serene and welcoming 
                        environment for your nikah ceremony and reception.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Nikah Ceremonies</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Reception Venue</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Flexible Scheduling</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-gray-300">Community Support</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-2xl">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Book Your Venue</h3>
                            <p class="text-gray-600 mb-6">Fill out the form below to inquire about availability</p>
                            
                            @if(session('success'))
                                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('marriage.booking.store') }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" id="name" name="name" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <input type="email" id="email" name="email" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" id="phone" name="phone"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <div>
                                        <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                                        <select id="service_type" name="service_type" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                            <option value="">Select service type</option>
                                            <option value="nikah">Nikah Ceremony Only</option>
                                            <option value="reception">Reception Only</option>
                                            <option value="both">Nikah & Reception</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="proposed_date" class="block text-sm font-medium text-gray-700 mb-1">Proposed Date</label>
                                        <input type="date" id="proposed_date" name="proposed_date"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                    <div>
                                        <label for="proposed_time" class="block text-sm font-medium text-gray-700 mb-1">Proposed Time</label>
                                        <input type="time" id="proposed_time" name="proposed_time"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                    </div>
                                </div>

                                <div>
                                    <label for="expected_guests" class="block text-sm font-medium text-gray-700 mb-1">Expected Number of Guests</label>
                                    <input type="number" id="expected_guests" name="expected_guests" min="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Additional Information</label>
                                    <textarea id="message" name="message" rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
                                              placeholder="Any special requirements or questions..."></textarea>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                                    Submit Booking Request
                                </button>
                            </form>
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
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-lg text-gray-600">We provide comprehensive support for your special day</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Nikah Ceremonies</h3>
                    <p class="text-gray-600 mb-6">
                        Our mosque provides a beautiful and serene setting for nikah ceremonies, 
                        conducted by our qualified imams with full adherence to Islamic traditions.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Qualified imam officiation</li>
                        <li>• Traditional nikah procedure</li>
                        <li>• Flexible timing options</li>
                        <li>• Family-friendly environment</li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Reception Venue</h3>
                    <p class="text-gray-600 mb-6">
                        Spacious and well-equipped reception hall suitable for wedding celebrations 
                        and family gatherings.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Large prayer hall conversion</li>
                        <li>• Seating arrangements available</li>
                        <li>• Kitchen facilities</li>
                        <li>• Parking available</li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Community Support</h3>
                    <p class="text-gray-600 mb-6">
                        Our community volunteers provide support and assistance to ensure your 
                        special day runs smoothly.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Event coordination support</li>
                        <li>• Setup and cleanup assistance</li>
                        <li>• Guidance on mosque procedures</li>
                        <li>• Community network connections</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Have questions about our marriage services? Contact us to learn more about 
                        availability, pricing, and requirements.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email Us</h4>
                                <p class="text-gray-600">info@ipswichmosque.org</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Call Us</h4>
                                <p class="text-gray-600">+44 (0) 1473 123 456</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Visit Us</h4>
                                <p class="text-gray-600">123 Mosque Road<br>Ipswich, IP1 1AB</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Quick Contact</h3>
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" id="contact_name" name="name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="contact_email" name="email" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div>
                            <label for="contact_subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="contact_subject" name="subject" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label for="contact_message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea id="contact_message" name="message" rows="5" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    @include('partials.footer')

@endsection