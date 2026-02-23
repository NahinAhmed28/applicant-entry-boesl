<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Brunei Worker Management</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak]{display:none !important;}</style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div
            x-data="{ sidebarOpen: false, collapsed: false }"
            @keydown.escape.window="sidebarOpen = false"
            class="min-h-screen lg:flex">
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-30 bg-black/40 lg:hidden"
                x-cloak
            ></div>

            <aside
                :class="[
                    collapsed ? 'lg:w-20' : 'lg:w-64',
                    sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
                ]"
                class="bg-slate-900 text-slate-100 w-72 fixed inset-y-0 left-0 z-40 transform transition-all duration-200 ease-out">
                <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800">
                    <span x-show="!collapsed" x-cloak class="font-semibold">Brunei Worker Management</span>
                    <span x-show="collapsed" x-cloak class="hidden lg:inline text-lg font-semibold">B</span>
                    <button @click="collapsed = !collapsed" class="hidden lg:inline text-xs bg-slate-800 px-2 py-1 rounded" title="Toggle sidebar">[]</button>
                    <button @click="sidebarOpen = false" class="lg:hidden text-lg" title="Close sidebar">X</button>
                </div>

                <nav class="p-3 space-y-1 text-sm">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800' : '' }}" title="Dashboard">
                        <svg class="h-5 w-5 text-slate-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5M5.25 9.75V21h13.5V9.75" />
                        </svg>
                        <span x-show="!collapsed" x-cloak>Dashboard</span>
                    </a>

                    @if(auth()->user()->hasAnyRole(['boesl-admin', 'super-admin']))
                        <a href="{{ route('boesl.applicants.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('boesl.*') ? 'bg-slate-800' : '' }}" title="BOESL Applicants">
                            <svg class="h-5 w-5 text-slate-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h7.879a2.25 2.25 0 011.591.659l2.621 2.621a2.25 2.25 0 01.659 1.591V19.5a2.25 2.25 0 01-2.25 2.25h-10.5a2.25 2.25 0 01-2.25-2.25V6a2.25 2.25 0 012.25-2.25z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 3.75V8.25h4.5M8.25 12.75h7.5M8.25 16.5h7.5" />
                            </svg>
                            <span x-show="!collapsed" x-cloak>BOESL Applicants</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasAnyRole(['bhc-admin', 'super-admin']))
                        <a href="{{ route('bhc.applicants.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('bhc.*') ? 'bg-slate-800' : '' }}" title="BHC Applicants">
                            <svg class="h-5 w-5 text-slate-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>
                            <span x-show="!collapsed" x-cloak>BHC Applicants</span>
                        </a>
                    @endif

                    @role('super-admin')
                        <a href="{{ route('super-admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('super-admin.users.*') ? 'bg-slate-800' : '' }}" title="User Management">
                            <svg class="h-5 w-5 text-slate-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="8.5" cy="8" r="2.5"></circle>
                                <circle cx="15.5" cy="8" r="2.5"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 19a5 5 0 0110 0" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19a5 5 0 0110 0" />
                            </svg>
                            <span x-show="!collapsed" x-cloak>User Management</span>
                        </a>
                    @endrole

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('profile.*') ? 'bg-slate-800' : '' }}" title="Profile">
                        <svg class="h-5 w-5 text-slate-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="7.5" r="3.5"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0116 0" />
                        </svg>
                        <span x-show="!collapsed" x-cloak>Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 text-left" title="Logout">
                            <svg class="h-5 w-5 text-slate-200 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l-5-5 5-5" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h10" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 4h4a1 1 0 011 1v14a1 1 0 01-1 1h-4" />
                            </svg>
                            <span x-show="!collapsed" x-cloak>Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <div :class="collapsed ? 'lg:ml-20' : 'lg:ml-64'" class="flex-1 transition-all duration-200">
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden text-sm font-medium px-2 py-1 rounded border border-slate-300" title="Open sidebar">Menu</button>
                    <div class="font-semibold text-slate-700">
                        @isset($header)
                            {{ $header }}
                        @else
                            Dashboard
                        @endisset
                    </div>
                    <div class="text-sm text-slate-500">{{ auth()->user()->name }}</div>
                </header>

                <main class="p-3 sm:p-4 lg:p-6">{{ $slot }}</main>
            </div>
        </div>
    </body>
</html>

