@extends('main-layout')

@section('title', 'Janazah Services - Ipswich Mosque')
@section('header')
    @include('partials.header')
@endsection

@section('content')
<div class="janazah-page">
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Janazah & Funeral Services</h1>
                    <p class="italic text-emerald-400 mb-6 text-xl">"Inna Lillahi wa inna ilayhi raji'un"</p>
                    <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                        The Ipswich Mosque offers full support during difficult times, including body wash (Ghusl) facilities, 
                        shrouding (Kafan), and Janazah prayers before burial.
                    </p>
                    
                    <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                        <h4 class="font-bold mb-4 text-emerald-400">Emergency Contacts:</h4>
                        <p class="mb-2"><strong>Mohammed Tunu Miah:</strong> 07855 540993</p>
                        <p><strong>Mosque Office:</strong> 01473 226879</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-2xl text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Service Inquiry</h3>
                    <p class="text-gray-500 mb-6 text-sm">Fill this form for non-emergency funeral arrangements.</p>

                    @if(session('success'))
                        <div class="bg-emerald-100 text-emerald-700 p-3 rounded-lg mb-4">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('janazah.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Your Name" required class="modern-input">
                            <input type="email" name="email" placeholder="Your Email" required class="modern-input">
                        </div>
                        <input type="tel" name="phone" placeholder="Phone Number" required class="modern-input">
                        <input type="text" name="deceased_name" placeholder="Name of Deceased (Optional)" class="modern-input">
                        <textarea name="message" rows="3" placeholder="Additional Information..." class="modern-input"></textarea>
                        
                        <button type="submit" class="w-full py-4 rounded-xl text-white font-bold transition-all hover:opacity-90" style="background-color: var(--brand-green);">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">Funeral Rites in Islam</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="p-6 bg-white rounded-xl shadow-sm border-b-4 border-emerald-700">
                    <span class="text-3xl mb-2 block">1</span>
                    <h4 class="font-bold">Ghusl</h4>
                    <p class="text-sm text-gray-500">Ritual Bathing</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border-b-4 border-emerald-700">
                    <span class="text-3xl mb-2 block">2</span>
                    <h4 class="font-bold">Kafan</h4>
                    <p class="text-sm text-gray-500">Enshrouding</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border-b-4 border-emerald-700">
                    <span class="text-3xl mb-2 block">3</span>
                    <h4 class="font-bold">Salah</h4>
                    <p class="text-sm text-gray-500">Funeral Prayer</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border-b-4 border-emerald-700">
                    <span class="text-3xl mb-2 block">4</span>
                    <h4 class="font-bold">Dafn</h4>
                    <p class="text-sm text-gray-500">Burial</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border-b-4 border-emerald-700">
                    <span class="text-3xl mb-2 block">5</span>
                    <h4 class="font-bold">Qibla</h4>
                    <p class="text-sm text-gray-500">Facing Makkah</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold">How to Pray Janazah Prayer</h2>
                <p class="text-emerald-700 font-semibold">(Hanafi Madhhab)</p>
            </div>

            <div class="space-y-8">
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">1</div>
                    <div>
                        <h4 class="font-bold text-lg">First Takbeer & Thana</h4>
                        <p class="text-gray-600">Raise hands to earlobes, say <strong>"Allahu Akbar"</strong>, and fold hands. Recite Thana with an addition:</p>
                        <p class="bg-gray-50 p-3 mt-2 rounded italic text-sm">"Subhanakal-lahumma wa bihamdika, wa tabarakasmuka, wa ta'ala jadduka, <strong>wa jalla thina'uka</strong>, wa la ilaha ghayruk."</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">2</div>
                    <div>
                        <h4 class="font-bold text-lg">Second Takbeer & Durood</h4>
                        <p class="text-gray-600">Say <strong>"Allahu Akbar"</strong> (do not raise hands). Recite Durood-e-Ibrahim as in normal Salah.</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">3</div>
                    <div>
                        <h4 class="font-bold text-lg">Third Takbeer & Dua for Deceased</h4>
                        <p class="text-gray-600">Say <strong>"Allahu Akbar"</strong>. Recite the Janazah Dua (for adults):</p>
                        <p class="bg-gray-50 p-3 mt-2 rounded text-sm font-arabic">"Allahummagh-fir lihayyina wa mayyitina, wa shahidina wa gha’ibina, wa saghirina wa kabirina, wa dhakarina wa unthana..."</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">4</div>
                    <div>
                        <h4 class="font-bold text-lg">Fourth Takbeer & Taslim</h4>
                        <p class="text-gray-600">Say <strong>"Allahu Akbar"</strong>. Then perform Salam to the right and left (as in normal prayer) while dropping the hands to the sides.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('partials.janazah-terms')

<style>
    .modern-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        outline: none;
        color: #1e293b !important; /* Ensure text is visible */
        background: #fff !important;
    }
    .modern-input:focus { border-color: var(--brand-green); box-shadow: 0 0 0 3px rgba(10, 81, 52, 0.1); }
</style>
@endsection


@section('footer')
    @include('partials.footer')
@endsection