@extends('layouts.dashboard')

@section('title', 'Mosque Settings')
@section('header', 'Mosque Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.mosque-settings.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Contact Information Section -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <span>📞</span> Contact Information
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Mosque Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $settings->name) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $settings->phone) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="+44 1234 567890">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $settings->email) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="info@mosque.org">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea id="address" name="address" rows="2" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Mosque address...">{{ old('address', $settings->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <span>🌐</span> Social Media Links
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            Facebook URL
                        </span>
                    </label>
                    <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="https://facebook.com/yourpage">
                </div>

                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            Instagram URL
                        </span>
                    </label>
                    <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="https://instagram.com/yourpage">
                </div>

                <div>
                    <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                            YouTube URL
                        </span>
                    </label>
                    <input type="url" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings->youtube_url) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="https://youtube.com/yourchannel">
                </div>

                <div>
                    <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            Twitter/X URL
                        </span>
                    </label>
                    <input type="url" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="https://twitter.com/yourpage">
                </div>
            </div>
        </div>

        <!-- Bank Account Section -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <span>🏦</span> Bank Account Information (for Donations)
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-2">Account Name</label>
                    <input type="text" id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name', $settings->bank_account_name) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Ipswich Mosque">
                </div>

                <div>
                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $settings->bank_name) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Lloyd's Bank Plc">
                </div>

                <div>
                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-2">Account Number</label>
                    <input type="text" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $settings->bank_account_number) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="04910428">
                </div>

                <div>
                    <label for="bank_sort_code" class="block text-sm font-medium text-gray-700 mb-2">Sort Code</label>
                    <input type="text" id="bank_sort_code" name="bank_sort_code" value="{{ old('bank_sort_code', $settings->bank_sort_code) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="30-94-55">
                </div>
            </div>
        </div>

        <!-- Additional Settings -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <span>⚙️</span> Additional Settings
            </h2>
            
            <div>
                <label for="donation_standing_order_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Standing Order Form URL
                </label>
                <input type="url" id="donation_standing_order_url" name="donation_standing_order_url" value="{{ old('donation_standing_order_url', $settings->donation_standing_order_url) }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="https://example.com/storage/standing-order.pdf">
                <p class="mt-2 text-sm text-gray-500">URL to the standing order form PDF for regular donations.</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-emerald-500 text-white font-medium rounded-lg hover:bg-emerald-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection