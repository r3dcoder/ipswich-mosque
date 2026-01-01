@php
  $v = fn($key, $default='') => old($key, $prayer->$key ?? $default);
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Month</label>
        <input name="month" value="{{ $v('month') }}" class="w-full rounded-lg border-gray-300" placeholder="APRIL">
        @error('month') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Date (1-31)</label>
        <input type="number" min="1" max="31" name="date" value="{{ $v('date') }}" class="w-full rounded-lg border-gray-300" required>
        @error('date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Day</label>
        <input name="day" value="{{ $v('day') }}" class="w-full rounded-lg border-gray-300" placeholder="TUE" required>
        @error('day') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div class="border rounded-lg p-4">
        <h3 class="font-semibold mb-3">Fajr</h3>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="text-sm">Begins</label><input name="fajr_begins" value="{{ $v('fajr_begins') }}" class="w-full rounded-lg border-gray-300"></div>
            <div><label class="text-sm">Jama'at</label><input name="fajr_jamaat" value="{{ $v('fajr_jamaat') }}" class="w-full rounded-lg border-gray-300"></div>
        </div>
        <div class="mt-3"><label class="text-sm">Sunrise</label><input name="sunrise" value="{{ $v('sunrise') }}" class="w-full rounded-lg border-gray-300"></div>
    </div>

    <div class="border rounded-lg p-4">
        <h3 class="font-semibold mb-3">Zuhr</h3>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="text-sm">Begins</label><input name="zuhr_begins" value="{{ $v('zuhr_begins') }}" class="w-full rounded-lg border-gray-300"></div>
            <div><label class="text-sm">Jama'at</label><input name="zuhr_jamaat" value="{{ $v('zuhr_jamaat') }}" class="w-full rounded-lg border-gray-300"></div>
        </div>
    </div>

    <div class="border rounded-lg p-4">
        <h3 class="font-semibold mb-3">Asr</h3>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="text-sm">Begins</label><input name="asr_begins" value="{{ $v('asr_begins') }}" class="w-full rounded-lg border-gray-300"></div>
            <div><label class="text-sm">Jama'at</label><input name="asr_jamaat" value="{{ $v('asr_jamaat') }}" class="w-full rounded-lg border-gray-300"></div>
        </div>
    </div>

    <div class="border rounded-lg p-4">
        <h3 class="font-semibold mb-3">Maghrib</h3>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="text-sm">Begins</label><input name="maghrib_begins" value="{{ $v('maghrib_begins') }}" class="w-full rounded-lg border-gray-300"></div>
            <div><label class="text-sm">Jama'at</label><input name="maghrib_jamaat" value="{{ $v('maghrib_jamaat') }}" class="w-full rounded-lg border-gray-300"></div>
        </div>
    </div>

    <div class="border rounded-lg p-4 md:col-span-2">
        <h3 class="font-semibold mb-3">Isha</h3>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="text-sm">Begins</label><input name="isha_begins" value="{{ $v('isha_begins') }}" class="w-full rounded-lg border-gray-300"></div>
            <div><label class="text-sm">Jama'at</label><input name="isha_jamaat" value="{{ $v('isha_jamaat') }}" class="w-full rounded-lg border-gray-300"></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    <div>
        <label class="block text-sm font-medium mb-1">Hijri Date</label>
        <input type="number" name="hijri_date" value="{{ $v('hijri_date') }}" class="w-full rounded-lg border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Hijri Month</label>
        <input name="hijri_month" value="{{ $v('hijri_month') }}" class="w-full rounded-lg border-gray-300" placeholder="SHAWWAL">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Hijri Year</label>
        <input type="number" name="hijri_year" value="{{ $v('hijri_year') }}" class="w-full rounded-lg border-gray-300">
    </div>
</div>
