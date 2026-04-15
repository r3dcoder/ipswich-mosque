@extends('main-layout')

@section('title', 'Khutbah Library - Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="khutbah-hub bg-slate-50 min-h-screen pb-20">
    
    <section class="bg-slate-900 pt-16 pb-32 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                <div class="lg:w-2/3">
                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded mb-4 inline-block">MOST VIEWED THIS MONTH</span>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">The Essence of Patience (Sabr)</h1>
                    <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/VIDEO_ID_HERE" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="lg:w-1/3 space-y-6">
                    <h3 class="text-2xl font-bold border-l-4 border-emerald-500 pl-4">Why Watch This?</h3>
                    <p class="text-slate-400 leading-relaxed">
                        This sermon has touched over 5,000 hearts this month. Sheikh [Name] discusses how to find peace during life's most difficult trials using examples from the Seerah.
                    </p>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="flex items-center gap-1"><i class="fas fa-eye"></i> 5.2k Views</span>
                        <span class="flex items-center gap-1"><i class="fas fa-clock"></i> 22 mins</span>
                    </div>
                    <button class="w-full py-4 rounded-xl font-bold transition-all hover:bg-emerald-700" style="background-color: var(--brand-green);">
                        Add to Watch Later
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 -mt-8">
        <div class="bg-white p-4 rounded-2xl shadow-xl flex flex-wrap gap-3 justify-center border border-gray-100">
            <button class="px-6 py-2 rounded-full bg-emerald-600 text-white font-semibold">All Topics</button>
            <button class="px-6 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-emerald-50 transition">Family Life</button>
            <button class="px-6 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-emerald-50 transition">Spirituality</button>
            <button class="px-6 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-emerald-50 transition">History</button>
            <button class="px-6 py-2 rounded-full bg-gray-100 text-gray-600 hover:bg-emerald-50 transition">Youth</button>
        </div>
    </div>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Latest Khutbahs</h2>
                    <p class="text-gray-500">Updated every Friday after Jumu'ah</p>
                </div>
                <a href="#" class="text-emerald-700 font-bold hover:underline">View All →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach(range(1, 3) as $item)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
                    <div class="relative aspect-video bg-gray-200">
                        <img src="https://img.youtube.com/vi/VIDEO_ID/mqdefault.jpg" class="w-full h-full object-cover" alt="Thumbnail">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition flex items-center justify-center">
                            <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center text-emerald-700 opacity-0 group-hover:opacity-100 transition transform translate-y-2 group-hover:translate-y-0">
                                ▶
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <span class="text-emerald-600 text-xs font-bold uppercase tracking-widest">Spirituality</span>
                        <h4 class="text-lg font-bold mt-2 text-slate-900 line-clamp-2">The Importance of Daily Adhkar and Connection with Allah</h4>
                        <div class="flex items-center justify-between mt-4 text-gray-400 text-xs">
                            <span>Oct 20, 2025</span>
                            <span>18:24</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12 bg-emerald-50/50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-slate-900 mb-8">Family & Marriage Series</h2>
            <div class="flex gap-6 overflow-x-auto pb-6 scrollbar-hide">
                @foreach(range(1, 4) as $item)
                <div class="flex-shrink-0 w-80 bg-white rounded-2xl shadow-sm p-4">
                    <div class="rounded-xl overflow-hidden mb-4">
                        <img src="https://img.youtube.com/vi/VIDEO_ID/default.jpg" class="w-full h-32 object-cover" alt="Thumb">
                    </div>
                    <h5 class="font-bold text-slate-800 text-sm">Raising Children with Islamic Values in the West</h5>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<style>
    /* Hide scrollbar for the category row but keep functionality */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection

@section('footer')
    @include('partials.footer')
@endsection