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
        <div x-data="{ sidebarOpen: false, collapsed: false }" class="min-h-screen lg:flex">
            <aside
                :class="collapsed ? 'lg:w-20' : 'lg:w-64'"
                class="bg-slate-900 text-slate-100 w-72 fixed inset-y-0 left-0 z-40 transform transition-all duration-200 lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
                <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800">
                    <span x-show="!collapsed" x-cloak class="font-semibold">Brunei Worker Management</span>
                    <span x-show="collapsed" x-cloak class="hidden lg:inline text-lg font-semibold">B</span>
                    <button @click="collapsed = !collapsed" class="hidden lg:inline text-xs bg-slate-800 px-2 py-1 rounded" title="Toggle sidebar">[]</button>
                    <button @click="sidebarOpen = false" class="lg:hidden text-lg" title="Close sidebar">X</button>
                </div>

                <nav class="p-3 space-y-1 text-sm">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800' : '' }}" title="Dashboard">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-slate-700 text-[10px] font-bold">DB</span>
                        <span x-show="!collapsed" x-cloak>Dashboard</span>
                    </a>

                    @if(auth()->user()->hasAnyRole(['boesl-admin', 'super-admin']))
                        <a href="{{ route('boesl.applicants.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('boesl.*') ? 'bg-slate-800' : '' }}" title="BOESL Applicants">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-slate-700 text-[10px] font-bold">BO</span>
                            <span x-show="!collapsed" x-cloak>BOESL Applicants</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasAnyRole(['bhc-admin', 'super-admin']))
                        <a href="{{ route('bhc.applicants.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('bhc.*') ? 'bg-slate-800' : '' }}" title="BHC Applicants">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-slate-700 text-[10px] font-bold">BH</span>
                            <span x-show="!collapsed" x-cloak>BHC Applicants</span>
                        </a>
                    @endif

                    @role('super-admin')
                        <a href="{{ route('super-admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('super-admin.users.*') ? 'bg-slate-800' : '' }}" title="User Management">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-slate-700 text-[10px] font-bold">UM</span>
                            <span x-show="!collapsed" x-cloak>User Management</span>
                        </a>
                    @endrole

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('profile.*') ? 'bg-slate-800' : '' }}" title="Profile">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-slate-700 text-[10px] font-bold">PR</span>
                        <span x-show="!collapsed" x-cloak>Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center gap-3 px-3 py-2 rounded hover:bg-slate-800 text-left" title="Logout">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded bg-slate-700 text-[10px] font-bold">LO</span>
                            <span x-show="!collapsed" x-cloak>Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <div :class="collapsed ? 'lg:ml-20' : 'lg:ml-64'" class="flex-1 transition-all duration-200">
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden text-lg" title="Open sidebar">|||</button>
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
