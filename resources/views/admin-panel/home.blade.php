@extends('layouts.dashboard')

@section('title','Admin Panel')
@section('header','Admin Panel')

@section('content')
<div class="space-y-6">
    
    {{-- Welcome Section --}}
    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-2xl p-8 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Ipswich Mosque Admin Panel</h1>
                <p class="text-emerald-100 text-lg">Manage all mosque content and services</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Admin Sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Communications --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Communications</h3>
                <span class="text-sm text-gray-500">Notices & newsletters</span>
            </div>
            
            <div class="space-y-4">
                
                {{-- Notices --}}
                <a href="{{ route('admin.notices.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-emerald-300 hover:bg-emerald-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-emerald-700">Notice Board</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage announcements and notices</p>
                        </div>
                        <div class="ml-auto text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Newsletter --}}
                <a href="{{ route('admin.newsletter.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">Newsletter</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage subscribers and send emails</p>
                        </div>
                        <div class="ml-auto text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        {{-- Content Management --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Content Management</h3>
                <span class="text-sm text-gray-500">Videos, pages, and media</span>
            </div>
            
            <div class="space-y-4">
                
                {{-- Khutbah Videos --}}
                <a href="{{ route('admin.khutbahs.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-emerald-300 hover:bg-emerald-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-emerald-700">Khutbah Videos</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage Friday sermons and religious videos</p>
                        </div>
                        <div class="ml-auto text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Pages --}}
                <a href="{{ route('admin.pages.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">Pages</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage website pages and content</p>
                        </div>
                        <div class="ml-auto text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Carousel --}}
                <a href="{{ route('admin.carousel-slides.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-purple-700">Carousel</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage homepage slideshow images</p>
                        </div>
                        <div class="ml-auto text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Prayer Times --}}
                <a href="{{ route('admin.prayer-times.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-orange-700">Prayer Times</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage daily prayer schedules</p>
                        </div>
                        <div class="ml-auto text-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

            </div>
        </div>

        {{-- Services Management --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Services Management</h3>
                <span class="text-sm text-gray-500">Bookings and requests</span>
            </div>
            
            <div class="space-y-4">
                
                {{-- Marriage Bookings --}}
                <a href="{{ route('admin.marriage-bookings.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-pink-300 hover:bg-pink-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center group-hover:bg-pink-200 transition-colors">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-pink-700">Marriage Bookings</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage marriage ceremony bookings</p>
                        </div>
                        <div class="ml-auto text-pink-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Funeral Bookings --}}
                <a href="{{ route('admin.funeral-bookings.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-red-700">Funeral Bookings</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage funeral service requests</p>
                        </div>
                        <div class="ml-auto text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Contacts --}}
                <a href="{{ route('admin.contacts.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-indigo-700">Contact Messages</h4>
                            <p class="text-sm text-gray-600 mt-1">View and respond to contact form messages</p>
                        </div>
                        <div class="ml-auto text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- People --}}
                <a href="{{ route('admin.people.index') }}" 
                   class="group block p-6 border border-gray-200 rounded-lg hover:border-teal-300 hover:bg-teal-50 transition-all duration-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center group-hover:bg-teal-200 transition-colors">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-teal-700">People Directory</h4>
                            <p class="text-sm text-gray-600 mt-1">Manage mosque member directory</p>
                        </div>
                        <div class="ml-auto text-teal-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>

            </div>
        </div>

    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Total Videos --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Videos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $khutbahsCount ?? 0 }}</p>
                </div>
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-500">Khutbah videos</span>
                <a href="{{ route('admin.khutbahs.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Manage</a>
            </div>
        </div>

        {{-- Active Videos --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Videos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activeVideos ?? 0 }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-500">Publicly visible</span>
                <a href="{{ route('admin.khutbahs.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">Manage</a>
            </div>
        </div>

        {{-- Marriage Bookings --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Marriage Bookings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $marriageBookings ?? 0 }}</p>
                </div>
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-500">Pending requests</span>
                <a href="{{ route('admin.marriage-bookings.index') }}" class="text-pink-600 hover:text-pink-700 text-sm font-medium">View</a>
            </div>
        </div>

        {{-- Funeral Bookings --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Funeral Bookings</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $funeralBookings ?? 0 }}</p>
                </div>
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-500">Recent requests</span>
                <a href="{{ route('admin.funeral-bookings.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium">View</a>
            </div>
        </div>

        {{-- Total Donations --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Donations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">£{{ number_format($totalDonations ?? 0, 2) }}</p>
                </div>
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-500">{{ $donationsCount ?? 0 }} total donations</span>
                <a href="{{ route('admin.donations') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">View</a>
            </div>
        </div>

    </div>

    {{-- Administration --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Administration</h3>
            <span class="text-sm text-gray-500">User management and settings</span>
        </div>
        
        <div class="space-y-4">
            
            {{-- Admin Users --}}
            <a href="{{ route('admin.users.index') }}" 
               class="group block p-6 border border-gray-200 rounded-lg hover:border-emerald-300 hover:bg-emerald-50 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-emerald-700">Admin Users</h4>
                        <p class="text-sm text-gray-600 mt-1">Manage admin panel users and permissions</p>
                    </div>
                    <div class="ml-auto text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Mosque Settings --}}
            <a href="{{ route('admin.mosque-settings.edit') }}" 
               class="group block p-6 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-blue-700">Mosque Settings</h4>
                        <p class="text-sm text-gray-600 mt-1">Configure mosque information and settings</p>
                    </div>
                    <div class="ml-auto text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

        </div>
    </div>

    {{-- Footer Info --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Admin Panel Summary</h3>
            <p class="text-gray-600 mb-4">Use the sidebar navigation or the quick links above to manage all mosque content and services.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-500">
                <div class="text-center">
                    <span class="font-medium text-gray-700">Content:</span> Videos, Pages, Images
                </div>
                <div class="text-center">
                    <span class="font-medium text-gray-700">Services:</span> Bookings, Messages
                </div>
                <div class="text-center">
                    <span class="font-medium text-gray-700">Management:</span> Users, Settings
                </div>
            </div>
        </div>
    </div>

</div>
@endsection