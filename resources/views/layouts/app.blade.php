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
                    <span x-show="!collapsed" x-cloak class="font-semibold px-2">Brunei Worker Management</span>
                    <span x-show="collapsed" x-cloak class="hidden lg:inline text-lg font-semibold px-2">B</span>
                    <button @click="sidebarOpen = false" class="lg:hidden text-lg" title="Close sidebar">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
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
                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-6 sticky top-0 z-20">
                    <div class="flex items-center gap-4">
                        <!-- Sidebar Toggle - Visible for all screen sizes -->
                        <button @click="if (window.innerWidth < 1024) { sidebarOpen = true } else { collapsed = !collapsed }" class="p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none" title="Toggle Sidebar">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <div class="font-semibold text-slate-700">
                            @isset($header)
                                {{ $header }}
                            @else
                                Dashboard
                            @endisset
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        @if(auth()->user()->hasAnyRole(['bhc-admin', 'super-admin']))
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-full transition-colors group focus:outline-none" title="Notifications">
                                    <svg class="h-6 w-6 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                                    @if($unreadCount > 0)
                                        <span class="absolute top-1 right-1 h-4 w-4 bg-red-600 text-white text-[9px] flex items-center justify-center rounded-full font-bold shadow-sm ring-2 ring-white">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </button>

                                <div 
                                    x-show="open" 
                                    @click.away="open = false" 
                                    x-cloak 
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden z-50 ring-1 ring-black ring-opacity-5"
                                >
                                    <div class="px-4 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Notifications</span>
                                        @if($unreadCount > 0)
                                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] rounded-full font-bold">{{ $unreadCount }} New</span>
                                        @endif
                                    </div>
                                    <div class="max-h-[28rem] overflow-y-auto">
                                        @forelse(auth()->user()->unreadNotifications as $notification)
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-4 py-3.5 hover:bg-slate-50 border-b border-slate-50 flex gap-4 transition-colors">
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-indigo-600 shadow-sm">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="text-xs font-bold text-slate-900 truncate">{{ $notification->data['applicant_name'] ?? 'Applicant Update' }}</div>
                                                        <div class="text-[11px] text-slate-600 leading-relaxed mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</div>
                                                        <div class="flex items-center gap-1.5 mt-2">
                                                            <div class="h-1.5 w-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $notification->created_at->diffForHumans() }}</div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        @empty
                                            <div class="px-6 py-12 text-center">
                                                <div class="mx-auto h-12 w-12 text-slate-200 mb-3">
                                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                                                </div>
                                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">No unread notifications</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    @if(auth()->user()->notifications->count() > 0)
                                        <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-100 text-center">
                                            <a href="#" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">View All Past Notifications</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="hidden sm:block text-sm text-slate-500 font-medium">{{ auth()->user()->name }}</div>
                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </header>

                <main class="p-3 sm:p-4 lg:p-6">{{ $slot }}</main>
            </div>
        </div>
    </body>
</html>

