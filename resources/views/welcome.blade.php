<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Entry — BOESL & BHC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-900 via-slate-900 to-purple-900 text-slate-100 antialiased">
    <header class="sticky top-0 z-40 bg-transparent backdrop-blur-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-r from-pink-500 via-cyan-400 to-indigo-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-user-check text-white"></i>
                    </div>
                    <span class="font-semibold text-slate-100 hidden sm:inline">Applicant Entry</span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="#features" class="text-sm text-slate-200 hover:text-white">Features</a>
                    <a href="{{ route('login') }}" class="ml-2 inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-cyan-400 text-slate-900 px-3 py-1.5 rounded-md text-sm font-semibold shadow">Sign In</a>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto w-full px-5 py-12 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left: Message -->
            <div class="text-center lg:text-left">
                <p class="inline-flex items-center gap-2 text-sm font-medium text-pink-300 mb-3">
                    <span class="px-2 py-1 rounded bg-pink-600/20 text-pink-200">Workforce • BOESL • BHC</span>
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-3">Manage applicants with clarity and speed</h1>
                <p class="text-slate-300 max-w-xl">Minimal, powerful tools to track submissions, registrations, IC cards, and insurance milestones. Built for administrators and teams in Brunei.</p>

                <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:gap-3 gap-3 justify-center lg:justify-start">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-slate-900 px-4 py-2 rounded-md font-semibold shadow-sm">Get Started</a>
                    <a href="#features" class="inline-flex items-center gap-2 border border-white/10 text-white/90 px-4 py-2 rounded-md text-sm">Explore</a>
                </div>
            </div>

            <!-- Right: Compact feature card -->
            <div class="bg-gradient-to-br from-white/5 to-white/3 border border-white/6 rounded-xl p-5 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">Quick Overview</h3>
                        <p class="text-sm text-slate-400">At-a-glance workflow statuses</p>
                    </div>
                    <div class="text-xs text-slate-400">v1.0</div>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 rounded bg-white/3">
                        <div class="text-sm text-pink-300">Pending</div>
                        <div class="font-semibold text-lg">12</div>
                    </div>
                    <div class="p-3 rounded bg-white/3">
                        <div class="text-sm text-cyan-300">Registered</div>
                        <div class="font-semibold text-lg">8</div>
                    </div>
                    <div class="p-3 rounded bg-white/3">
                        <div class="text-sm text-emerald-300">Completed</div>
                        <div class="font-semibold text-lg">24</div>
                    </div>
                </div>

                <div class="mt-5 border-t border-white/6 pt-4 text-sm text-slate-300">
                    <ul class="grid grid-cols-1 gap-2">
                        <li class="flex items-center gap-2"><i class="fas fa-lock text-pink-300 w-5"></i> Role-based access</li>
                        <li class="flex items-center gap-2"><i class="fas fa-file-import text-cyan-300 w-5"></i> Excel import</li>
                        <li class="flex items-center gap-2"><i class="fas fa-bell text-emerald-300 w-5"></i> Smart reminders</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <section id="features" class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-lg bg-white/5 text-center">
                    <div class="text-2xl text-pink-400 mb-2">🔒</div>
                    <div class="font-semibold">Secure Roles</div>
                </div>
                <div class="p-4 rounded-lg bg-white/5 text-center">
                    <div class="text-2xl text-cyan-400 mb-2">📥</div>
                    <div class="font-semibold">Bulk Import</div>
                </div>
                <div class="p-4 rounded-lg bg-white/5 text-center">
                    <div class="text-2xl text-emerald-400 mb-2">⏰</div>
                    <div class="font-semibold">Automated Reminders</div>
                </div>
                <div class="p-4 rounded-lg bg-white/5 text-center">
                    <div class="text-2xl text-violet-400 mb-2">📊</div>
                    <div class="font-semibold">Reporting</div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-400">
            &copy; 2026 Applicant Entry — BOESL & BHC. All rights reserved.
        </div>
    </footer>
</body>
</html>
