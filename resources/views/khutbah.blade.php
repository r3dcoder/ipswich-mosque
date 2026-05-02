@extends('main-layout')

@section('title', 'Khutbah Library - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="khutbah-hub bg-slate-50 min-h-screen pb-20">
    
    <!-- Hero Section with Featured Khutbah -->
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900 pt-20 pb-24 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-sm font-semibold px-4 py-1.5 rounded-full mb-4 inline-block backdrop-blur-sm">
                    📹 Khutbah Library
                </span>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Islamic Sermons & Lectures</h1>
                <p class="text-slate-300 text-lg max-w-2xl mx-auto">Watch and learn from our collection of Friday sermons and special Islamic lectures</p>
            </div>

            @if($liveStream)
                <!-- Live Stream Banner -->
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="bg-red-600/90 backdrop-blur-md rounded-2xl p-6 border-2 border-red-400 shadow-2xl animate-pulse">
                        <div class="flex items-center justify-center gap-3 mb-4">
                            <span class="bg-white text-red-600 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                <span class="w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
                                LIVE NOW
                            </span>
                            <span class="text-white font-semibold">Friday Jumu'ah Live Stream</span>
                        </div>
                        <h2 class="text-xl font-bold text-white text-center mb-4">{{ $liveStream['title'] }}</h2>
                        <div class="flex justify-center">
                            <button onclick="openVideoModal('{{ $liveStream['youtube_id'] }}', '{{ addslashes($liveStream['title']) }}', '{{ addslashes($liveStream['description'] ?? '') }}', 'Ipswich Mosque', '{{ now()->format('M d, Y') }}', 'LIVE')" 
                                    class="px-8 py-3 bg-white text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all flex items-center gap-2">
                                <i class="fas fa-play"></i>
                                Watch Live
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($upcomingStreams) > 0)
                <!-- Upcoming Streams Slider -->
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="bg-gradient-to-r from-emerald-800/90 to-emerald-900/90 backdrop-blur-md rounded-2xl p-6 border border-emerald-500/30 shadow-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-clock text-emerald-400"></i>
                                <span class="text-emerald-300">Coming Up</span>
                                <span class="bg-emerald-500/30 text-emerald-200 text-xs px-3 py-1 rounded-full">{{ count($upcomingStreams) }} Stream{{ count($upcomingStreams) > 1 ? 's' : '' }}</span>
                            </h3>
                            <div class="flex gap-2">
                                <button onclick="prevSlide()" class="w-10 h-10 rounded-full bg-emerald-700/50 hover:bg-emerald-600/70 text-white flex items-center justify-center transition-all border border-emerald-500/30">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button onclick="nextSlide()" class="w-10 h-10 rounded-full bg-emerald-700/50 hover:bg-emerald-600/70 text-white flex items-center justify-center transition-all border border-emerald-500/30">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Slider Container -->
                        <div class="relative overflow-hidden">
                            <div id="upcomingSlider" class="flex transition-transform duration-500 ease-in-out">
                                @foreach($upcomingStreams as $index => $stream)
                                    <div class="w-full flex-shrink-0 px-2">
                                        <div class="bg-white/10 rounded-2xl p-5 border border-white/20 hover:border-emerald-400/50 transition-all group">
                                            <div class="flex items-start gap-4">
                                                <div class="relative flex-shrink-0">
                                                    <img src="{{ $stream['thumbnail_url'] }}" alt="{{ $stream['title'] }}" class="w-32 h-20 object-cover rounded-xl group-hover:scale-105 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent rounded-xl"></div>
                                                    <div class="absolute bottom-2 left-2 right-2">
                                                        <span class="bg-blue-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 w-fit">
                                                            <i class="fas fa-broadcast-tower"></i>
                                                            Upcoming
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-base font-semibold text-white line-clamp-2 leading-tight">{{ $stream['title'] }}</h4>
                                                    <div class="flex items-center gap-3 mt-2 text-xs text-slate-300">
                                                        <span class="flex items-center gap-1">
                                                            <i class="fas fa-calendar text-emerald-400"></i>
                                                            {{ $stream['formatted_date'] ?? 'Coming Soon' }}
                                                        </span>
                                                        <span class="flex items-center gap-1">
                                                            <i class="fas fa-video text-emerald-400"></i>
                                                            Ipswich Mosque
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-3 mt-4">
                                                <button onclick="openVideoModal('{{ $stream['youtube_id'] }}', '{{ addslashes($stream['title']) }}', '{{ addslashes($stream['description'] ?? '') }}', 'Ipswich Mosque', '{{ $stream['formatted_date'] ?? 'Coming Soon' }}', 'Upcoming')" 
                                                        class="flex-1 px-4 py-2.5 bg-emerald-500/30 hover:bg-emerald-500/50 text-emerald-200 text-sm font-semibold rounded-xl transition-all border border-emerald-500/30 flex items-center justify-center gap-2">
                                                    <i class="fas fa-info-circle"></i>
                                                    View Details
                                                </button>
                                                <button onclick="setReminder('{{ $stream['youtube_id'] }}', '{{ addslashes($stream['title']) }}', '{{ $stream['formatted_date'] ?? '' }}')" 
                                                        class="px-4 py-2.5 bg-blue-500/30 hover:bg-blue-500/50 text-blue-200 text-sm font-semibold rounded-xl transition-all border border-blue-500/30 flex items-center gap-2">
                                                    <i class="fas fa-bell"></i>
                                                    Remind
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Slider Dots -->
                            <div class="flex justify-center gap-2 mt-4" id="sliderDots">
                                @foreach($upcomingStreams as $index => $stream)
                                    <button onclick="goToSlide({{ $index }})" 
                                            class="w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-emerald-400 w-6' : 'bg-white/30 hover:bg-white/50' }}"
                                            data-slide="{{ $index }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($featuredKhutbah)
                <!-- Featured Khutbah Card -->
                <div class="max-w-5xl mx-auto">
                    <div class="bg-white/5 backdrop-blur-md rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                        <div class="grid md:grid-cols-2 gap-0">
                            <!-- Video Thumbnail -->
                            <div class="relative aspect-video md:aspect-auto cursor-pointer group" onclick="openVideoModal('{{ $featuredKhutbah->youtube_id }}', '{{ addslashes($featuredKhutbah->title) }}', '{{ addslashes($featuredKhutbah->description ?? '') }}', '{{ $featuredKhutbah->speaker ?? 'Unknown Speaker' }}', '{{ $featuredKhutbah->formatted_date }}', '{{ $featuredKhutbah->formatted_duration }}')">
                                <img src="{{ $featuredKhutbah->thumbnail_url }}" 
                                     alt="{{ $featuredKhutbah->title }}" 
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                                     onerror="this.src='https://img.youtube.com/vi/{{ $featuredKhutbah->youtube_id }}/maxresdefault.jpg'; this.onerror=function(){this.src='https://placehold.co/640x360/1e293b/64748b?text=No+Thumbnail';}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-emerald-500/90 rounded-full flex items-center justify-center text-white shadow-lg transform transition duration-300 group-hover:scale-110 group-hover:bg-emerald-400">
                                        <i class="fas fa-play text-2xl ml-1"></i>
                                    </div>
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">Featured Khutbah</span>
                                </div>
                            </div>
                            
                            <!-- Info Panel -->
                            <div class="p-8 flex flex-col justify-center">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-emerald-400 text-sm font-semibold uppercase tracking-wider">{{ $featuredKhutbah->category_label }}</span>
                                    <span class="text-slate-500">•</span>
                                    <span class="text-slate-400 text-sm">{{ $featuredKhutbah->formatted_duration }}</span>
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold mb-4 leading-tight">{{ $featuredKhutbah->title }}</h2>
                                <p class="text-slate-300 mb-6 line-clamp-3">
                                    {{ $featuredKhutbah->description ?: 'This khutbah provides valuable insights and guidance on important Islamic topics. Watch to deepen your understanding and strengthen your faith.' }}
                                </p>
                                <div class="flex flex-wrap gap-4 text-sm text-slate-400">
                                    <span class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-xs"></i>
                                        </div>
                                        {{ $featuredKhutbah->speaker ?? 'Unknown Speaker' }}
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar text-xs"></i>
                                        </div>
                                        {{ $featuredKhutbah->formatted_date }}
                                    </span>
                                </div>
                                <button onclick="openVideoModal('{{ $featuredKhutbah->youtube_id }}', '{{ addslashes($featuredKhutbah->title) }}', '{{ addslashes($featuredKhutbah->description ?? '') }}', '{{ $featuredKhutbah->speaker ?? 'Unknown Speaker' }}', '{{ $featuredKhutbah->formatted_date }}', '{{ $featuredKhutbah->formatted_duration }}')" 
                                        class="mt-8 w-full md:w-auto px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                                    <i class="fas fa-play"></i>
                                    Watch Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(!$liveStream)
                <div class="max-w-3xl mx-auto text-center">
                    <div class="bg-white/5 backdrop-blur-md rounded-3xl p-12 border border-white/10">
                        <div class="w-20 h-20 bg-slate-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-video text-3xl text-slate-400"></i>
                        </div>
                        <h2 class="text-2xl font-bold mb-4">Khutbah Library</h2>
                        <p class="text-slate-400 mb-8">No khutbahs have been added yet. Please check back later or contact the admin to add new content.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if(count($categories) > 0)
    <!-- Category Filters -->
    <div class="max-w-7xl mx-auto px-4 -mt-8 relative z-20">
        <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-100 flex flex-wrap gap-2 justify-center">
            <a href="{{ route('khutbah.index', ['category' => 'all']) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all {{ $category === 'all' ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                All Topics
            </a>
            @foreach($categories as $key => $label)
                <a href="{{ route('khutbah.index', ['category' => $key]) }}" 
                   class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all {{ $category === $key ? 'bg-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Latest Khutbahs Grid -->
    <section id="latest-khutbahs" class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Latest Khutbahs</h2>
                    <p class="text-gray-500 mt-1">Recent Friday sermons and special lectures</p>
                </div>
                
                <!-- Sort Controls -->
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm text-gray-500">Sort by:</span>
                    
                    <div class="relative inline-block text-left" id="sortDropdown">
                        <!-- Sort Button -->
                        <button type="button" onclick="toggleSortDropdown()" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">
                            <i class="fas fa-sliders-h"></i>
                            <span id="currentSortLabel">
                                Date - Newest First
                            </span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="sortChevron"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="sortDropdownMenu" class="hidden absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1" role="menu">
                                <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                    Sort Options
                                </div>
                                
                        <!-- Date Options -->
                        <a href="{{ route('khutbah.index', array_merge(request()->except('sort', 'order'), ['sort' => 'date', 'order' => 'desc'])) }}"
                           class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">
                            <i class="fas fa-calendar-day w-5 text-gray-400"></i>
                            <span class="ml-2">Date - Newest First</span>
                        </a>
                        <a href="{{ route('khutbah.index', array_merge(request()->except('sort', 'order'), ['sort' => 'date', 'order' => 'asc'])) }}"
                           class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">
                            <i class="fas fa-calendar-day w-5 text-gray-400"></i>
                            <span class="ml-2">Date - Oldest First</span>
                        </a>
                        
                        <!-- Title Options -->
                        <a href="{{ route('khutbah.index', array_merge(request()->except('sort', 'order'), ['sort' => 'title', 'order' => 'asc'])) }}"
                           class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">
                            <i class="fas fa-font w-5 text-gray-400"></i>
                            <span class="ml-2">Title - A to Z</span>
                        </a>
                        <a href="{{ route('khutbah.index', array_merge(request()->except('sort', 'order'), ['sort' => 'title', 'order' => 'desc'])) }}"
                           class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">
                            <i class="fas fa-font w-5 text-gray-400"></i>
                            <span class="ml-2">Title - Z to A</span>
                        </a>
                        
                        <!-- Speaker Options -->
                        <a href="{{ route('khutbah.index', array_merge(request()->except('sort', 'order'), ['sort' => 'speaker', 'order' => 'asc'])) }}"
                           class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">
                            <i class="fas fa-user w-5 text-gray-400"></i>
                            <span class="ml-2">Speaker - A to Z</span>
                        </a>
                        <a href="{{ route('khutbah.index', array_merge(request()->except('sort', 'order'), ['sort' => 'speaker', 'order' => 'desc'])) }}"
                           class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50" role="menuitem">
                            <i class="fas fa-user w-5 text-gray-400"></i>
                            <span class="ml-2">Speaker - Z to A</span>
                        </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($khutbahs->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                    <div class="text-slate-400 mb-4">
                        <i class="fas fa-video text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold">No Videos Available</h3>
                        <p class="mt-2 text-gray-500">No khutbahs have been added yet. Please check back later.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="khutbahGrid">
                    @foreach($khutbahs as $khutbah)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group sortible-card" 
                         data-date="{{ $khutbah['published_at'] ?? $khutbah['formatted_date'] ?? '' }}"
                         data-title="{{ addslashes($khutbah['title']) }}"
                         data-speaker="{{ addslashes($khutbah['speaker'] ?? 'Ipswich Mosque') }}">
                        <div class="relative aspect-video bg-gray-100 cursor-pointer overflow-hidden" onclick="openVideoModal('{{ $khutbah['youtube_id'] }}', '{{ addslashes($khutbah['title']) }}', '{{ addslashes($khutbah['description'] ?? '') }}', '{{ $khutbah['speaker'] ?? 'Ipswich Mosque' }}', '{{ $khutbah['formatted_date'] }}', '{{ $khutbah['formatted_duration'] ?: ($khutbah['is_live'] ? 'LIVE' : '') }}')">
                            <img src="{{ $khutbah['thumbnail_url'] }}" 
                                 alt="{{ $khutbah['title'] }}"
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $khutbah['youtube_id'] }}/maxresdefault.jpg'; this.onerror=function(){this.src='https://placehold.co/640x360/e2e8f0/64748b?text=Video';}">
                            
                            <!-- Live Badge -->
                            @if($khutbah['is_live'])
                                <div class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 animate-pulse">
                                    <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                                    LIVE
                                </div>
                            @elseif($khutbah['was_live'] ?? false)
                                <!-- Past Live Badge -->
                                <div class="absolute top-3 left-3 bg-red-500/80 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-record-vinyl text-[10px]"></i>
                                    Past Live
                                </div>
                            @endif
                            
                            <!-- Upcoming Badge -->
                            @if($khutbah['is_upcoming'])
                                <div class="absolute top-3 left-3 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-clock text-[10px]"></i>
                                    Upcoming
                                </div>
                            @endif
                            
                            <!-- Source Badge (YouTube) -->
                            @if($khutbah['source'] === 'youtube' && !$khutbah['is_live'] && !$khutbah['is_upcoming'])
                                <div class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                    <i class="fab fa-youtube"></i>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <div class="w-14 h-14 bg-emerald-500/90 rounded-full flex items-center justify-center text-white shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                    <i class="fas fa-play text-lg ml-0.5"></i>
                                </div>
                            </div>
                            @if($khutbah['is_featured'] && $khutbah['source'] === 'database')
                                <div class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <i class="fas fa-star text-[10px]"></i>
                                    Featured
                                </div>
                            @endif
                            @if($khutbah['formatted_duration'])
                                <div class="absolute bottom-3 right-3 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                    <i class="fas fa-clock mr-1"></i>{{ $khutbah['formatted_duration'] }}
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-emerald-600 text-xs font-semibold uppercase tracking-wide">{{ $khutbah['category_label'] }}</span>
                                @if($khutbah['source'] === 'youtube')
                                    <span class="text-gray-400 text-[10px] flex items-center gap-1">
                                        <i class="fab fa-youtube text-red-600"></i>
                                        YouTube
                                    </span>
                                @endif
                            </div>
                            <h4 class="text-base font-bold text-slate-900 line-clamp-2 mb-3">{{ $khutbah['title'] }}</h4>
                            <div class="flex items-center justify-between text-gray-400 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-user"></i>
                                        <span class="truncate max-w-[100px]">{{ $khutbah['speaker'] ?? 'Ipswich Mosque' }}</span>
                                    </span>
                                </div>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-calendar"></i>
                                    {{ $khutbah['formatted_date'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
            
            @if($khutbahs->hasPages())
                <div class="mt-10 flex justify-center">
                    {{ $khutbahs->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </section>
</div>

<!-- Video Modal - Full overlay on top of everything -->
<div id="videoModal" class="fixed inset-0 z-[9999] bg-black bg-opacity-95 flex items-start justify-center pt-8 pb-8 hidden" onclick="closeVideoModal()">
    <div class="relative max-w-5xl w-full mx-4" onclick="event.stopPropagation()">
        <!-- Video Container with 16:9 Aspect Ratio -->
        <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-black">
            <div class="aspect-video" style="aspect-ratio: 16/9; max-height: 70vh;">
                <iframe id="videoIframe" class="w-full h-full" frameborder="0" allowfullscreen allow="autoplay"></iframe>
            </div>
        </div>
        
        <!-- Video Info -->
        <div class="mt-6 text-center">
            <h3 id="videoTitle" class="text-2xl font-bold text-white mb-3"></h3>
            <p id="videoDescription" class="text-slate-300 mb-4 max-w-2xl mx-auto"></p>
            <div class="flex items-center justify-center gap-6 text-sm text-slate-400">
                <span id="videoSpeaker" class="flex items-center gap-2">
                    <i class="fas fa-user"></i>
                </span>
                <span id="videoDate" class="flex items-center gap-2">
                    <i class="fas fa-calendar"></i>
                </span>
                <span id="videoDuration" class="flex items-center gap-2">
                    <i class="fas fa-clock"></i>
                </span>
            </div>
            <p class="text-slate-500 text-sm mt-6">Click outside the video or press ESC to close</p>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Modal animation */
    #videoModal.show {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    
    #videoModal.show .max-w-5xl {
        animation: slideUp 0.4s ease-out;
    }
    
    /* Ensure modal is always on top */
    #videoModal {
        position: fixed !important;
        z-index: 9999 !important;
    }
</style>

<script>
    // ==========================================
    // Video Modal Functions
    // ==========================================
    function openVideoModal(videoId, title, description, speaker, date, duration) {
        // Set video content
        document.getElementById('videoIframe').src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
        document.getElementById('videoTitle').textContent = title;
        document.getElementById('videoDescription').textContent = description || '';
        document.getElementById('videoSpeaker').innerHTML = `<i class="fas fa-user"></i> ${speaker}`;
        document.getElementById('videoDate').innerHTML = `<i class="fas fa-calendar"></i> ${date}`;
        document.getElementById('videoDuration').innerHTML = `<i class="fas fa-clock"></i> ${duration || ''}`;
        
        // Show modal
        const modal = document.getElementById('videoModal');
        modal.classList.remove('hidden');
        modal.classList.add('show');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
    
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        modal.classList.remove('show');
        
        // Wait for animation before hiding and stopping video
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('videoIframe').src = '';
            document.body.style.overflow = '';
        }, 300);
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeVideoModal();
        }
    });

    // ==========================================
    // Upcoming Streams Slider
    // ==========================================
    let currentSlide = 0;
    const totalSlides = {{ count($upcomingStreams) }};

    function updateSlider() {
        const slider = document.getElementById('upcomingSlider');
        if (slider) {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        // Update dots
        document.querySelectorAll('#sliderDots button').forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.remove('bg-white/30', 'hover:bg-white/50');
                dot.classList.add('bg-emerald-400', 'w-6');
            } else {
                dot.classList.remove('bg-emerald-400', 'w-6');
                dot.classList.add('bg-white/30', 'hover:bg-white/50');
            }
        });
    }

    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlider();
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
    }

    // Auto-advance slider every 5 seconds
    if (totalSlides > 1) {
        setInterval(() => {
            nextSlide();
        }, 5000);
    }

    // ==========================================
    // Reminder Function
    // ==========================================
    function setReminder(videoId, title, date) {
        // Check if browser supports notifications
        if (!('Notification' in window)) {
            alert('Your browser does not support notifications. But we\'ll remind you when you visit the site!');
            return;
        }

        // Check if this is iOS and needs home screen installation
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches;
        
        if (isIOS && !isStandalone) {
            // Show iOS-specific instructions
            if (confirm('📱 For iPhone/iPad notifications to work, you need to add this website to your home screen first.\n\nWould you like to see instructions?')) {
                alert('📲 How to add to Home Screen:\n\n1. Tap the Share button (square with arrow)\n2. Scroll down and tap "Add to Home Screen"\n3. Tap "Add" in the top right corner\n\nAfter adding, visit the site from your home screen and set the reminder again!');
            }
            return;
        }

        // Request permission for notifications
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                // Store reminder in localStorage
                const reminders = JSON.parse(localStorage.getItem('khutbah_reminders') || '[]');
                
                if (!reminders.find(r => r.videoId === videoId)) {
                    reminders.push({
                        videoId: videoId,
                        title: title,
                        date: date,
                        notified: false
                    });
                    localStorage.setItem('khutbah_reminders', JSON.stringify(reminders));
                    
                    // Show success notification
                    new Notification('Reminder Set! 🔔', {
                        body: `You'll be reminded about: ${title}`,
                        icon: '/images/logo.png'
                    });
                } else {
                    alert('You already have a reminder set for this stream!');
                }
            } else {
                // Fallback: Store in localStorage and show confirmation
                const reminders = JSON.parse(localStorage.getItem('khutbah_reminders') || '[]');
                
                if (!reminders.find(r => r.videoId === videoId)) {
                    reminders.push({
                        videoId: videoId,
                        title: title,
                        date: date,
                        notified: false
                    });
                    localStorage.setItem('khutbah_reminders', JSON.stringify(reminders));
                    
                    alert('Reminder set! We\'ll notify you when you visit the site.');
                }
            }
        });
    }

    // ==========================================
    // Sort Dropdown Functions
    // ==========================================
    function toggleSortDropdown() {
        const dropdown = document.getElementById('sortDropdownMenu');
        const chevron = document.getElementById('sortChevron');
        const isHidden = dropdown.classList.contains('hidden');
        
        if (isHidden) {
            dropdown.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            dropdown.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('sortDropdown');
        const button = dropdown.querySelector('button');
        
        if (!dropdown.contains(event.target) && !dropdown.classList.contains('hidden')) {
            toggleSortDropdown();
        }
    });

    // ==========================================
    // Client-Side Sort Function (using data attributes)
    // ==========================================
    function sortVideos(sortBy, sortOrder) {
        // Close dropdown
        toggleSortDropdown();
        
        // Update button label
        const labelMap = {
            'date-desc': 'Date - Newest First',
            'date-asc': 'Date - Oldest First',
            'title-asc': 'Title - A to Z',
            'title-desc': 'Title - Z to A',
            'speaker-asc': 'Speaker - A to Z',
            'speaker-desc': 'Speaker - Z to A'
        };
        document.getElementById('currentSortLabel').textContent = labelMap[sortBy + '-' + sortOrder];
        
        // Get the grid container
        const grid = document.getElementById('khutbahGrid');
        if (!grid) return;
        
        // Get all video cards with data attributes
        const cards = Array.from(grid.querySelectorAll('.sortible-card'));
        
        // Debug: Log the dates before sorting
        console.log('Sorting by:', sortBy, 'Order:', sortOrder);
        cards.forEach((card, index) => {
            console.log(`Card ${index}:`, {
                title: card.getAttribute('data-title'),
                date: card.getAttribute('data-date')
            });
        });
        
        // Sort the cards using data attributes
        cards.sort((cardA, cardB) => {
            let valueA, valueB;
            
            if (sortBy === 'date') {
                // Use data-date attribute
                const dateStrA = cardA.getAttribute('data-date') || '';
                const dateStrB = cardB.getAttribute('data-date') || '';
                
                // Parse dates - handle both ISO format and "M d, Y" format
                const parsedDateA = new Date(dateStrA);
                const parsedDateB = new Date(dateStrB);
                
                valueA = parsedDateA.getTime();
                valueB = parsedDateB.getTime();
                
                // Handle invalid dates
                if (isNaN(valueA)) valueA = 0;
                if (isNaN(valueB)) valueB = 0;
            } else if (sortBy === 'title') {
                // Use data-title attribute
                valueA = (cardA.getAttribute('data-title') || '').toLowerCase();
                valueB = (cardB.getAttribute('data-title') || '').toLowerCase();
            } else if (sortBy === 'speaker') {
                // Use data-speaker attribute
                valueA = (cardA.getAttribute('data-speaker') || '').toLowerCase();
                valueB = (cardB.getAttribute('data-speaker') || '').toLowerCase();
                
                // Put empty/ipswich mosque speakers at the end
                if (!valueA || valueA === 'ipswich mosque') return 1;
                if (!valueB || valueB === 'ipswich mosque') return -1;
            }
            
            // Compare values
            let result;
            if (typeof valueA === 'string') {
                result = valueA.localeCompare(valueB);
            } else {
                result = valueA - valueB;
            }
            
            // Apply sort order
            // For 'desc' (newest first): higher values should come first, so negate
            // For 'asc' (oldest first): lower values should come first, keep as is
            return sortOrder === 'desc' ? -result : result;
        });
        
        // Debug: Log the dates after sorting
        console.log('After sorting:');
        cards.forEach((card, index) => {
            console.log(`Card ${index}:`, {
                title: card.getAttribute('data-title'),
                date: card.getAttribute('data-date')
            });
        });
        
        // Re-append sorted cards to grid
        cards.forEach(card => grid.appendChild(card));
        
        // Add a subtle animation to show sorting happened
        grid.style.opacity = '0.5';
        setTimeout(() => {
            grid.style.opacity = '1';
            grid.style.transition = 'opacity 0.3s ease';
        }, 50);
    }

    // ==========================================
    // Check for reminders on page load
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        const reminders = JSON.parse(localStorage.getItem('khutbah_reminders') || '[]');
        const now = new Date();
        
        reminders.forEach(reminder => {
            if (!reminder.notified) {
                // Check if it's Friday and close to the reminder time
                if (now.getDay() === 5) { // Friday
                    // You could add more sophisticated timing logic here
                    if (Notification.permission === 'granted') {
                        new Notification('Upcoming Khutbah! 🔔', {
                            body: `Don't forget: ${reminder.title}`,
                            icon: '/images/logo.png'
                        });
                    }
                }
            }
        });
    });
</script>
@endsection

@section('footer')
    @include('partials.footer')
@endsection