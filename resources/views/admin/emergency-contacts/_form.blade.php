@php
    $contact = $contact ?? null;
@endphp

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" required value="{{ old('name', $contact->name ?? '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
            placeholder="e.g. Mohammed Tunu Miah">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Role in Committee</label>
        <input type="text" name="role_in_committee" value="{{ old('role_in_committee', $contact->role_in_committee ?? '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
            placeholder="e.g. Funeral Coordinator">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
        <input type="text" name="phone_number" required value="{{ old('phone_number', $contact->phone_number ?? '') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
            placeholder="e.g. 07855 540993">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $contact->sort_order ?? 0) }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        <p class="text-xs text-gray-400 mt-1">Lower numbers appear first.</p>
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_visible" value="1"
                {{ old('is_visible', $contact->is_visible ?? true) ? 'checked' : '' }}
                class="rounded border-gray-300 text-green-600 focus:ring-green-500">
            <span class="text-sm text-gray-700">Visible on the public page</span>
        </label>
    </div>
</div>

<div class="flex items-center gap-3 mt-8">
    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-medium">
        {{ $submitLabel ?? 'Save' }}
    </button>
    <a href="{{ route('admin.emergency-contacts.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
</div>
