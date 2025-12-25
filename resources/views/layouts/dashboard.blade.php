<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r hidden md:flex md:flex-col">
        <div class="h-16 flex items-center px-6 border-b">
            <div class="font-semibold text-lg">Ipswich Mosque</div>
        </div>

        <nav class="p-4">
    <div class="flex flex-col gap-2">
        <a href="{{ route('dashboard') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>🏠</span><span>Home</span>
        </a>

        <a href="{{ route('dashboard.pages') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('dashboard.pages') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>📄</span><span>Pages</span>
        </a>

        <a href="{{ route('dashboard.duas') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('dashboard.duas') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>🤲</span><span>Duas</span>
        </a>

        <a href="{{ route('dashboard.settings') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('dashboard.settings') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>⚙️</span><span>Settings</span>
        </a>

        <a href="{{ route('dashboard.payments') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('dashboard.payments') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>💳</span><span>Payments</span>
        </a>

        <a href="{{ route('dashboard.contacts') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm
                  {{ request()->routeIs('dashboard.contacts') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
            <span>📞</span><span>Contacts</span>
        </a>
    </div>
</nav>


        <div class="mt-auto p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full px-3 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-gray-800">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">
        {{-- Topbar --}}
        <header class="h-16 bg-white border-b flex items-center justify-between px-4 md:px-6">
            <div class="font-medium">@yield('header', 'Dashboard')</div>
            <div class="text-sm text-gray-600">
                {{ auth()->user()->name ?? '' }}
            </div>
        </header>

        <main class="p-4 md:p-6">
            <div class="max-w-6xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>
