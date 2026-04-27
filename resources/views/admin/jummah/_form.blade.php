@php
    $schedule = $schedule ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Effective From *</label>
        <input type="date" name="effective_from"
               value="{{ old('effective_from', $schedule?->effective_from?->format('Y-m-d')) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
        @error('effective_from') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Effective Till (optional)</label>
        <input type="date" name="effective_till"
               value="{{ old('effective_till', $schedule?->effective_till?->format('Y-m-d')) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
        @error('effective_till') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Khutbah Time (HH:MM)</label>
        <input type="time" name="khutbah_time"
               value="{{ old('khutbah_time', $schedule?->khutbah_time_for_form) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
        @error('khutbah_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Salah Time (HH:MM)</label>
        <input type="time" name="salah_time"
               value="{{ old('salah_time', $schedule?->salah_time_for_form) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
        @error('salah_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Note (optional)</label>
        <input type="text" name="note"
               value="{{ old('note', $schedule?->note) }}"
               class="w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900"
               placeholder="e.g. Ramadan schedule / winter time change">
        @error('note') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-2">Status</label>
        <label class="inline-flex items-center cursor-pointer group">
            <input type="checkbox" id="is_active" name="is_active" value="1"
                   {{ old('is_active', $schedule?->is_active) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-gray-400 text-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 ease-in-out cursor-pointer">
            <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-gray-900 transition-colors">
                <span class="inline-flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ old('is_active', $schedule?->is_active) ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                    {{ old('is_active', $schedule?->is_active) ? 'Active' : 'Inactive' }}
                </span>
            </span>
        </label>
        @error('is_active') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
