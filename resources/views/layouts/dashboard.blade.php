<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin Panel') - Ipswich Mosque</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme {
                :root, :host {
                    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                    --font-serif: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
                    --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
                    --color-emerald-50: oklch(.979 .021 166.113);
                    --color-emerald-100: oklch(.95 .052 163.051);
                    --color-emerald-200: oklch(.905 .093 164.15);
                    --color-emerald-300: oklch(.845 .143 164.978);
                    --color-emerald-400: oklch(.765 .177 163.223);
                    --color-emerald-500: oklch(.696 .17 162.48);
                    --color-emerald-600: oklch(.596 .145 163.225);
                    --color-emerald-700: oklch(.508 .118 165.612);
                    --color-emerald-800: oklch(.432 .095 166.913);
                    --color-emerald-900: oklch(.378 .077 168.94);
                    --color-emerald-950: oklch(.262 .051 172.552);
                    --color-gray-50: oklch(.985 .002 247.839);
                    --color-gray-100: oklch(.967 .003 264.542);
                    --color-gray-200: oklch(.928 .006 264.531);
                    --color-gray-300: oklch(.872 .01 258.338);
                    --color-gray-400: oklch(.707 .022 261.325);
                    --color-gray-500: oklch(.551 .027 264.364);
                    --color-gray-600: oklch(.446 .03 256.802);
                    --color-gray-700: oklch(.373 .034 259.733);
                    --color-gray-800: oklch(.278 .033 256.848);
                    --color-gray-900: oklch(.21 .034 264.665);
                    --color-gray-950: oklch(.13 .028 261.692);
                    --color-white: #fff;
                    --color-black: #000;
                    --spacing: .25rem;
                    --text-xs: .75rem;
                    --text-sm: .875rem;
                    --text-base: 1rem;
                    --text-lg: 1.125rem;
                    --text-xl: 1.25rem;
                    --text-2xl: 1.5rem;
                    --text-3xl: 1.875rem;
                    --font-weight-normal: 400;
                    --font-weight-medium: 500;
                    --font-weight-semibold: 600;
                    --font-weight-bold: 700;
                    --radius-sm: .25rem;
                    --radius-md: .375rem;
                    --radius-lg: .5rem;
                    --radius-xl: .75rem;
                    --radius-2xl: 1rem;
                }
            }
            @layer base {
                *, :after, :before, ::backdrop { box-sizing: border-box; border: 0 solid; margin: 0; padding: 0 }
                html, :host { -webkit-text-size-adjust: 100%; tab-size: 4; line-height: 1.5; font-family: var(--font-sans, ui-sans-serif, system-ui, sans-serif) }
                body { line-height: inherit }
                a { color: inherit; -webkit-text-decoration: inherit; text-decoration: inherit }
                img, svg, video { vertical-align: middle; display: block }
                img, video { max-width: 100%; height: auto }
                button, input, select, optgroup, textarea { font: inherit; font-feature-settings: inherit; font-variation-settings: inherit; letter-spacing: inherit; color: inherit; opacity: 1; background-color: #0000; border-radius: 0 }
                ::placeholder { opacity: 1; color: color-mix(in oklab, currentColor 50%, transparent) }
                button, input:where([type=button], [type=reset], [type=submit]) { -webkit-appearance: button; appearance: button }
                [hidden]:where(:not([hidden=until-found])) { display: none !important }
            }
            @layer components;
            @layer utilities {
                .absolute { position: absolute }
                .relative { position: relative }
                .fixed { position: fixed }
                .inset-0 { inset: calc(var(--spacing)*0) }
                .flex { display: flex }
                .hidden { display: none }
                .inline-flex { display: inline-flex }
                .h-16 { height: calc(var(--spacing)*16) }
                .min-h-screen { min-height: 100vh }
                .w-64 { width: calc(var(--spacing)*64) }
                .w-full { width: 100% }
                .max-w-7xl { max-width: 80rem }
                .flex-1 { flex: 1 }
                .flex-col { flex-direction: column }
                .items-center { align-items: center }
                .justify-center { justify-content: center }
                .justify-between { justify-content: space-between }
                .gap-2 { gap: calc(var(--spacing)*2) }
                .gap-3 { gap: calc(var(--spacing)*3) }
                .overflow-hidden { overflow: hidden }
                .overflow-x-auto { overflow-x: auto }
                .rounded-lg { border-radius: var(--radius-lg) }
                .rounded-xl { border-radius: var(--radius-xl) }
                .rounded-2xl { border-radius: var(--radius-2xl) }
                .border { border-style: var(--tw-border-style); border-width: 1px }
                .border-r { border-right-style: var(--tw-border-style); border-right-width: 1px }
                .border-b { border-bottom-style: var(--tw-border-style); border-bottom-width: 1px }
                .border-gray-200 { border-color: var(--color-gray-200) }
                .bg-gray-50 { background-color: var(--color-gray-50) }
                .bg-white { background-color: var(--color-white) }
                .bg-emerald-50 { background-color: var(--color-emerald-50) }
                .bg-emerald-500 { background-color: var(--color-emerald-500) }
                .bg-gray-900 { background-color: var(--color-gray-900) }
                .p-4 { padding: calc(var(--spacing)*4) }
                .p-6 { padding: calc(var(--spacing)*6) }
                .px-3 { padding-inline: calc(var(--spacing)*3) }
                .py-2 { padding-block: calc(var(--spacing)*2) }
                .py-3 { padding-block: calc(var(--spacing)*3) }
                .text-xs { font-size: var(--text-xs) }
                .text-sm { font-size: var(--text-sm) }
                .text-lg { font-size: var(--text-lg) }
                .text-xl { font-size: var(--text-xl) }
                .text-2xl { font-size: var(--text-2xl) }
                .font-medium { font-weight: var(--font-weight-medium) }
                .font-semibold { font-weight: var(--font-weight-semibold) }
                .font-bold { font-weight: var(--font-weight-bold) }
                .text-gray-600 { color: var(--color-gray-600) }
                .text-gray-700 { color: var(--color-gray-700) }
                .text-gray-900 { color: var(--color-gray-900) }
                .text-emerald-600 { color: var(--color-emerald-600) }
                .text-emerald-700 { color: var(--color-emerald-700) }
                .text-white { color: var(--color-white) }
                .shadow-sm { --tw-shadow: 0 1px 2px 0 #0000000d; box-shadow: var(--tw-shadow) }
                .transition { transition-property: color,background-color,border-color,text-decoration-color,fill,stroke; transition-timing-function: cubic-bezier(.4,0,.2,1); transition-duration: .15s }
                .hover\:bg-gray-100:hover { background-color: var(--color-gray-100) }
                .hover\:bg-emerald-600:hover { background-color: var(--color-emerald-600) }
                .hover\:text-emerald-700:hover { color: var(--color-emerald-700) }
            }
        </style>
    @endif
</head>

<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r flex flex-col">
            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-lg">Ipswich Mosque</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 overflow-x-auto">
                <div class="flex flex-col gap-1">
                    
                    {{-- Main Section --}}
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2">Main</p>
                        <a href="{{ route('admin') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🏠</span><span>Admin Home</span>
                        </a>
                    </div>

                    {{-- Content Management --}}
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2">Content</p>
                        
                        <a href="{{ route('admin.khutbahs.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.khutbahs.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🎥</span><span>Khutbah Videos</span>
                        </a>

                        <a href="{{ route('admin.prayer-times.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.prayer-times.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🕐</span><span>Prayer Times</span>
                        </a>

                        <a href="{{ route('admin.pages.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.pages.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>📄</span><span>Pages</span>
                        </a>

                        <a href="{{ route('admin.carousel-slides.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.carousel-slides.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🖼️</span><span>Carousel</span>
                        </a>
                    </div>

                    
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2">Courses & Events</p>

                        <a href="{{ route('admin.courses.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.courses.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>📖</span><span>Courses</span>
                        </a>

                        <a href="{{ route('admin.events.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.events.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>📅</span><span>Events</span>
                        </a>

                        <a href="{{ route('admin.ramadan.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.ramadan.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🌙</span><span>Ramadan</span>
                        </a>
                    </div>

                    
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2">Religious</p>

                        <a href="{{ route('admin.jummah.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.jummah.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🕌</span><span>Jummah</span>
                        </a>

                        <a href="{{ route('admin.duas.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.duas.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>🤲</span><span>Duas</span>
                        </a>

                        <a href="{{ route('admin.dua_categories.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.dua_categories.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>📂</span><span>Duas Category</span>
                        </a>
                    </div>

                    
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2">Services</p>

                        <a href="{{ route('admin.marriage-bookings.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.marriage-bookings.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>💍</span><span>Marriage Bookings</span>
                        </a>

                        <a href="{{ route('admin.funeral-bookings.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.funeral-bookings.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>⚰️</span><span>Funeral Bookings</span>
                        </a>
                    </div>

                    <a href="{{ route('admin.ramadan.index') }}"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('admin.ramadan.index') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span>🕌 </span><span>ramadan</span>
                    </a>
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2">Management</p>

                        <a href="{{ route('admin.contacts.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.contacts.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>📧</span><span>Contacts</span>
                        </a>

                        <a href="{{ route('admin.people.index') }}"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                            {{ request()->routeIs('admin.people.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                            <span>👥</span><span>People</span>
                        </a>
                    </div>

                </div>
            </nav>

            {{-- User Section --}}
            <div class="border-t p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? 'admin@mosque.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-gray-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Topbar --}}
            <header class="h-16 bg-white border-b flex items-center justify-between px-4 md:px-6">
                <div class="font-semibold text-lg">@yield('header', 'Admin Panel')</div>
                <div class="text-sm text-gray-600">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </header>

            <main class="flex-1 p-4 md:p-6 overflow-x-auto">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>