@extends('layouts.dashboard')

@section('title', 'Stripe Settings')
@section('header', 'Stripe Settings')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Stripe Payment Settings</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage test &amp; live credentials here. Secret keys are encrypted in the database.
                The active mode controls which keys donations use.
            </p>
        </div>

        <form action="{{ route('admin.stripe-settings.toggle-mode') }}" method="POST" class="flex-shrink-0">
            @csrf
            <button type="submit"
                    class="group relative inline-flex items-center gap-3 rounded-full px-2 py-2 border shadow-sm transition
                    {{ $settings->isLive() ? 'bg-emerald-600 border-emerald-500 text-white' : 'bg-amber-100 border-amber-300 text-amber-900' }}"
                    title="Click to switch mode">
                <span class="text-xs font-bold uppercase tracking-wider pl-3 {{ $settings->isLive() ? 'text-white/80' : 'text-amber-800' }}">Test</span>
                <span class="relative w-14 h-8 rounded-full transition
                      {{ $settings->isLive() ? 'bg-white/25' : 'bg-amber-300/80' }}">
                    <span class="absolute top-1 w-6 h-6 rounded-full bg-white shadow transition-all
                          {{ $settings->isLive() ? 'left-7' : 'left-1' }}"></span>
                </span>
                <span class="text-xs font-bold uppercase tracking-wider pr-3 {{ $settings->isLive() ? 'text-white' : 'text-amber-700/70' }}">Live</span>
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 rounded-2xl border p-4 flex flex-wrap items-center justify-between gap-3
         {{ $settings->isLive() ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200' }}">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-lg
                  {{ $settings->isLive() ? 'bg-emerald-600 text-white' : 'bg-amber-400 text-amber-950' }}">
                {{ $settings->isLive() ? '🟢' : '🧪' }}
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide {{ $settings->isLive() ? 'text-emerald-700' : 'text-amber-800' }}">
                    Currently active
                </p>
                <p class="text-lg font-bold {{ $settings->isLive() ? 'text-emerald-900' : 'text-amber-950' }}">
                    {{ $settings->isLive() ? 'LIVE / Production' : 'TEST mode' }}
                </p>
            </div>
        </div>
        <p class="text-sm {{ $settings->isLive() ? 'text-emerald-800' : 'text-amber-900' }}">
            @if($settings->isLive())
                Real charges will be taken. Make sure live keys are correct.
            @else
                No real money is charged. Use Stripe test cards.
            @endif
        </p>
    </div>

    <form action="{{ route('admin.stripe-settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- TEST --}}
            <div class="bg-white rounded-2xl border border-amber-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-amber-100 bg-amber-50 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-amber-950">Test credentials</h2>
                        <p class="text-xs text-amber-800/80">Keys starting with <code>pk_test_</code> / <code>sk_test_</code></p>
                    </div>
                    @if($settings->isTest())
                        <span class="text-xs font-bold uppercase tracking-wide bg-amber-200 text-amber-900 px-2.5 py-1 rounded-full">Active</span>
                    @endif
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publishable key</label>
                        <input type="text" name="test_public_key"
                               value="{{ old('test_public_key', $settings->test_public_key) }}"
                               placeholder="pk_test_..."
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secret key</label>
                        @if($settings->test_secret_key)
                            <p class="text-xs text-gray-500 mb-1">Saved: <span class="font-mono">{{ $settings->maskedTestSecret() }}</span> (encrypted)</p>
                        @endif
                        <input type="password" name="test_secret_key" value=""
                               placeholder="{{ $settings->test_secret_key ? 'Leave blank to keep current' : 'sk_test_...' }}"
                               autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Webhook secret</label>
                        @if($settings->test_webhook_secret)
                            <p class="text-xs text-gray-500 mb-1">Saved: <span class="font-mono">{{ $settings->maskedTestWebhook() }}</span> (encrypted)</p>
                        @endif
                        <input type="password" name="test_webhook_secret" value=""
                               placeholder="{{ $settings->test_webhook_secret ? 'Leave blank to keep current' : 'whsec_...' }}"
                               autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    </div>
                </div>
            </div>

            {{-- LIVE --}}
            <div class="bg-white rounded-2xl border border-emerald-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-emerald-950">Live / Production credentials</h2>
                        <p class="text-xs text-emerald-800/80">Keys starting with <code>pk_live_</code> / <code>sk_live_</code></p>
                    </div>
                    @if($settings->isLive())
                        <span class="text-xs font-bold uppercase tracking-wide bg-emerald-200 text-emerald-900 px-2.5 py-1 rounded-full">Active</span>
                    @endif
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publishable key</label>
                        <input type="text" name="live_public_key"
                               value="{{ old('live_public_key', $settings->live_public_key) }}"
                               placeholder="pk_live_..."
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secret key</label>
                        @if($settings->live_secret_key)
                            <p class="text-xs text-gray-500 mb-1">Saved: <span class="font-mono">{{ $settings->maskedLiveSecret() }}</span> (encrypted)</p>
                        @endif
                        <input type="password" name="live_secret_key" value=""
                               placeholder="{{ $settings->live_secret_key ? 'Leave blank to keep current' : 'sk_live_...' }}"
                               autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Webhook secret</label>
                        @if($settings->live_webhook_secret)
                            <p class="text-xs text-gray-500 mb-1">Saved: <span class="font-mono">{{ $settings->maskedLiveWebhook() }}</span> (encrypted)</p>
                        @endif
                        <input type="password" name="live_webhook_secret" value=""
                               placeholder="{{ $settings->live_webhook_secret ? 'Leave blank to keep current' : 'whsec_...' }}"
                               autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-2">Mode on save</h3>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="mode" value="test" class="text-amber-500 focus:ring-amber-400"
                           {{ old('mode', $settings->mode) === 'test' ? 'checked' : '' }}
                          >
                    <span class="text-sm font-medium text-gray-700">Use <strong>Test</strong> credentials</span>
                </label>
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="mode" value="live" class="text-emerald-600 focus:ring-emerald-500"
                           {{ old('mode', $settings->mode) === 'live' ? 'checked' : '' }}
                          >
                    <span class="text-sm font-medium text-gray-700">Use <strong>Live</strong> credentials</span>
                </label>
            </div>
            <p class="text-xs text-gray-500 mt-3">
                Leave secret / webhook fields blank to keep the currently saved encrypted values.
                If admin keys are empty, the app falls back to <code>.env</code> values.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                Save Stripe settings
            </button>
            <a href="{{ url('/donate') }}" target="_blank" class="text-sm text-gray-600 hover:text-gray-900">Open donate page ↗</a>
        </div>
    </form>
</div>
@endsection
