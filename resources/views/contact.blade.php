@extends('main-layout')

@section('title', 'Contact Us')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-green-50 via-white to-green-50">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRkZGRkZGMDIiLz4KPHBhdGggZD0iTTMwIDNMNDIgMTVMMTggNDdMMCAzNUwzMCAzTDQyIDE1TDE4IDQ3TDAtM0wzMCAzWiIgZmlsbD0iI0ZGRkZGRjAyIi8+Cjwvc3ZnPgo=')] opacity-20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="text-center">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-4 tracking-tight">
                    Get In Touch
                </h1>
                <p class="text-xl lg:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class=" ">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="mb-8">

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Send us a Message</h2>
                    <p class="text-gray-600">Fill out the form below and we'll get back to you soon.</p>
                </div>


                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror"
                               placeholder="your.email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone (Optional) -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Optional)</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('phone') border-red-500 @enderror"
                               placeholder="+44 123 456 7890">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('subject') border-red-500 @enderror"
                               placeholder="What is this about?">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Contact Method</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" name="contact_method" value="email" {{ old('contact_method', 'any') == 'email' ? 'checked' : '' }} class="form-radio text-green-600">
                                <span class="text-gray-700">Email</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" name="contact_method" value="phone" {{ old('contact_method') == 'phone' ? 'checked' : '' }} class="form-radio text-green-600">
                                <span class="text-gray-700">Phone</span>
                            </label>
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" name="contact_method" value="any" {{ old('contact_method') == 'any' ? 'checked' : '' }} class="form-radio text-green-600">
                                <span class="text-gray-700">Any</span>
                            </label>
                        </div>
                        @error('contact_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 resize-none @error('message') border-red-500 @enderror"
                                  placeholder="Please enter your message here...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-[#0a5134] text-white py-4 px-6 rounded-lg font-semibold hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class=" w-full space-y-2">
                <!-- Contact Info Cards -->
                <div class=" ">
                  @include('partials.map-section')
                </div>

                <!-- Office Hours -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Office Hours</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday - Friday</span>
                            <span class="font-medium">{{ $mapSettings->office_monday_friday ?? '9:00 AM - 5:00 PM' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saturday</span>
                            <span class="font-medium">{{ $mapSettings->office_saturday ?? '10:00 AM - 2:00 PM' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday</span>
                            <span class="font-medium">{{ $mapSettings->office_sunday ?? 'Closed' }}</span>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-700">For urgent matters during prayer times, please contact the office directly.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection