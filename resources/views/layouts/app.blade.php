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
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div x-data="{ sidebarOpen: false, collapsed: false }" class="min-h-screen lg:flex">
            <aside :class="collapsed ? 'lg:w-20' : 'lg:w-64'" class="bg-slate-900 text-slate-100 w-72 fixed inset-y-0 left-0 z-40 transform transition-all duration-200 lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
                <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800">
                    <span x-show="!collapsed" class="font-semibold">Brunei Worker Management</span>
                    <button @click="collapsed = !collapsed" class="hidden lg:inline text-xs bg-slate-800 px-2 py-1 rounded">⇔</button>
                    <button @click="sidebarOpen = false" class="lg:hidden">✕</button>
                </div>

                <nav class="p-3 space-y-1 text-sm">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('dashboard') ? 'bg-slate-800' : '' }}">Dashboard</a>

                    @if(auth()->user()->hasAnyRole(['boesl-admin', 'super-admin']))
                        <a href="{{ route('boesl.applicants.index') }}" class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('boesl.*') ? 'bg-slate-800' : '' }}">BOESL Applicants</a>
                    @endif

                    @if(auth()->user()->hasAnyRole(['bhc-admin', 'super-admin']))
                        <a href="{{ route('bhc.applicants.index') }}" class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('bhc.*') ? 'bg-slate-800' : '' }}">BHC Applicants</a>
                    @endif

                    @role('super-admin')
                        <a href="{{ route('super-admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('super-admin.users.*') ? 'bg-slate-800' : '' }}">User Management</a>
                    @endrole

                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-slate-800 {{ request()->routeIs('profile.*') ? 'bg-slate-800' : '' }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full text-left px-3 py-2 rounded hover:bg-slate-800">Logout</button></form>
                </nav>
            </aside>

            <div :class="collapsed ? 'lg:ml-20' : 'lg:ml-64'" class="flex-1 transition-all duration-200">
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden">☰</button>
                    <div class="font-semibold text-slate-700">
                        @isset($header)
                            {{ $header }}
                        @else
                            Dashboard
                        @endisset
                    </div>
                    <div class="text-sm text-slate-500">{{ auth()->user()->name }}</div>
                </header>

                <main class="p-4 lg:p-6">{{ $slot }}</main>
            </div>
        </div>
    </body>
</html>
