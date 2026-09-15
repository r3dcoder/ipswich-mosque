@extends('layouts.dashboard')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Create Ramadan Year</h1>

    <form action="{{ route('admin.ramadan.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Year --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Year <span class="text-red-500">*</span>
                </label>
                <input type="number" name="year"
                    value="{{ old('year', date('Y')+1) }}"
                    required
                    class="w-full border rounded px-3 py-2 @error('year') border-red-500 @enderror">
                @error('year')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title"
                    value="{{ old('title', 'Ramadan Mubarak ' . (date('Y')+1)) }}"
                    required
                    class="w-full border rounded px-3 py-2">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Start Date --}}
            <div>
                <label class="block text-sm font-medium mb-1">Start Date</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date') }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Countdown --}}
            <div>
                <label class="block text-sm font-medium mb-1">Countdown Target (JS Countdown)</label>
                <input type="datetime-local" name="countdown_target"
                    value="{{ old('countdown_target') }}"
                    class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
            <h2 class="text-lg font-bold mb-4 text-teal-800">Ramadan Info Cards Data</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Fitrana --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Fitrana Amount (e.g. 5.00)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">£</span>
                        <input type="text" name="fitrana"
                            value="{{ old('fitrana', '5.00') }}"
                            placeholder="5.00"
                            class="w-full border rounded pl-7 pr-3 py-2">
                    </div>
                </div>

                {{-- Eid Jamat --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Eid Jamat Times</label>
                    <input type="text" name="eid_jamat"
                        value="{{ old('eid_jamat') }}"
                        placeholder="1st: 8:00am | 2nd: 9:00am"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- Isha & Taraweeh --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Isha & Taraweeh Note</label>
                    <input type="text" name="esha_and_taraweeh"
                        value="{{ old('esha_and_taraweeh') }}"
                        placeholder="See calendar for times"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>
        </div>


            <div class="mt-8 p-6 bg-amber-50 rounded-2xl border border-amber-100">
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
        <div class="mt-6">
            <label class="block text-sm font-medium mb-1">Hero Message</label>
            <textarea name="hero_message" rows="3"
                placeholder="May Allah accept our fasting..."
                class="w-full border rounded px-3 py-2">{{ old('hero_message') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div class="mt-6">
            <label class="block text-sm font-medium mb-1">Timetable Image (JPG/PNG)</label>
            <input type="file" name="timetable_image" accept="image/*"
                class="w-full border rounded px-3 py-2 bg-white">
            @error('timetable_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.ramadan.index') }}"
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium transition">
                Cancel
            </a>

            <button type="submit"
                class="px-8 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 font-bold shadow-lg transition">
                Create Ramadan Year
            </button>
        </div>

    </form>
</div>
@endsection