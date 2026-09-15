@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        Edit Ramadan Setting - {{ $ramadan->year }}
    </h1>

    <form action="{{ route('admin.ramadan.update', $ramadan->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6 bg-white p-8 rounded-3xl shadow">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Year (Read Only or Disabled usually recommended for Unique keys) --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Year <span class="text-red-500">*</span></label>
                    <input type="number" name="year"
                        value="{{ old('year', $ramadan->year) }}"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">
                    @error('year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title"
                        value="{{ old('title', $ramadan->title) }}"
                        required
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Start Date</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', $ramadan->start_date?->format('Y-m-d')) }}"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                </div>

                {{-- Countdown --}}
                <div>
                    <label class="block text-sm font-medium mb-2">Countdown Target</label>
                    <input type="datetime-local" name="countdown_target"
                        value="{{ old('countdown_target', $ramadan->countdown_target ? date('Y-m-d\TH:i', strtotime($ramadan->countdown_target)) : '') }}"
                        class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                </div>
            </div>

            <div class="p-6 bg-teal-50 rounded-2xl border border-teal-100">
                <h2 class="text-lg font-bold mb-4 text-teal-800">Ramadan Info Cards</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Fitrana --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Fitrana (£)</label>
                        <input type="text" name="fitrana"
                            value="{{ old('fitrana', $ramadan->fitrana) }}"
                            placeholder="5.00"
                            class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>

                    {{-- Eid Jamat --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Eid Jamat</label>
                        <input type="text" name="eid_jamat"
                            value="{{ old('eid_jamat', $ramadan->eid_jamat) }}"
                            placeholder="8:00, 9:00, 10:30"
                            class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>

                    {{-- Isha & Taraweeh --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Isha & Taraweeh</label>
                        <input type="text" name="esha_and_taraweeh"
                            value="{{ old('esha_and_taraweeh', $ramadan->esha_and_taraweeh) }}"
                            placeholder="See calendar for times"
                            class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                </div>
            </div>


            <div class="p-6 bg-amber-50 rounded-2xl border border-amber-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-amber-900">Iftar Sponsorship Section</h2>
                        <p class="text-xs text-amber-800/70 mt-1">Shown on the public Ramadan page. Leave fields blank to hide parts.</p>
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-amber-900">
                        <input type="hidden" name="iftar_enabled" value="0">
                        <input type="checkbox" name="iftar_enabled" value="1"
                               {{ old('iftar_enabled', $ramadan->iftar_enabled ?? true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                        Show on public page
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Section title</label>
                        <input type="text" name="iftar_title"
                               value="{{ old('iftar_title', $ramadan->iftar_title ?? 'IFTAR') }}"
                               placeholder="IFTAR"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Intro message</label>
                        <textarea name="iftar_intro" rows="2"
                                  placeholder="If anyone wish to provide Iftar or pay for an Iftar, please contact Mosque committee."
                                  class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">{{ old('iftar_intro', $ramadan->iftar_intro) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Sponsor / arrange Iftar text</label>
                        <textarea name="iftar_sponsor_text" rows="3"
                                  placeholder="IFTAR at Ipswich Mosque - you can be part of this blessing!..."
                                  class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">{{ old('iftar_sponsor_text', $ramadan->iftar_sponsor_text) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Cost for one day Iftar (£)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">£</span>
                                <input type="text" name="iftar_cost"
                                       value="{{ old('iftar_cost', $ramadan->iftar_cost) }}"
                                       placeholder="e.g. 150"
                                       class="w-full border border-gray-300 rounded-2xl pl-10 pr-5 py-4 focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Contact</label>
                            <input type="text" name="iftar_contact"
                                   value="{{ old('iftar_contact', $ramadan->iftar_contact ?? 'Mosque Committee') }}"
                                   placeholder="Mosque Committee"
                                   class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Iftar contribution items</label>
                        <textarea name="iftar_items" rows="6"
                                  placeholder="One item per line, e.g.&#10;Dates&#10;Plates&#10;Cups"
                                  class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-teal-500 font-mono text-sm">{{ old('iftar_items', $ramadan->iftar_items) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Enter one item per line (or comma-separated). Shown as a checklist on the public page.</p>
                    </div>
                </div>
            </div>

            {{-- Hero Message --}}
            <div>
                <label class="block text-sm font-medium mb-2">Hero Message</label>
                <textarea name="hero_message" rows="3"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4">{{ old('hero_message', $ramadan->hero_message) }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div>
                <label class="block text-sm font-medium mb-2">Timetable Image</label>
                
                @if($ramadan->timetable_image)
                    <div class="mb-4 relative w-32 group">
                        <img src="{{ Storage::url($ramadan->timetable_image) }}" 
                             class="h-32 w-32 object-cover rounded-2xl border">
                        <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-white text-xs">Current</span>
                        </div>
                    </div>
                @endif

                <input type="file" name="timetable_image" accept="image/*"
                    class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-50 text-sm">
                <p class="text-gray-500 text-xs mt-2">Uploading a new image will replace the old one.</p>
                @error('timetable_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex gap-4">
            <a href="{{ route('admin.ramadan.index') }}" 
               class="flex-1 text-center py-4 bg-gray-200 hover:bg-gray-300 rounded-2xl font-medium transition">
                Cancel
            </a>
            <button type="submit" 
                    class="flex-1 py-4 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl font-medium transition">
                Update Ramadan Setting
            </button>
        </div>
    </form>
</div>
@endsection