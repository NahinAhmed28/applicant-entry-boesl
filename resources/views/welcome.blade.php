<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Entry - BOESL & BHC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="text-slate-900 antialiased" style="background: linear-gradient(135deg, #fef9c3 0% 40%, #dcfce7 40% 80%, #fee2e2 80% 85%, #f8fafc 85% 100%);">
    <header class="sticky top-0 z-40 bg-emerald-50/80 backdrop-blur border-b border-emerald-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">
                <a href="#" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center shadow-sm">
                        <i class="fas fa-user-check text-white"></i>
                    </div>
                    <span class="font-semibold text-emerald-900 hidden sm:inline">Applicant Entry</span>
                </a>

                <div class="flex items-center gap-3">
                    <a href="#features" class="text-sm text-emerald-700 hover:text-emerald-900">Features</a>
                    <a href="{{ route('login') }}" class="ml-2 inline-flex items-center gap-2 text-white px-3 py-1.5 rounded-md text-sm font-semibold shadow-sm transition"
                       style="background-color:#86efac;"
                       onmouseenter="this.style.backgroundColor='#059669';"
                       onmouseleave="this.style.backgroundColor='#86efac';">Sign In</a>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto w-full px-5 py-12 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="text-center lg:text-left">
                <p class="inline-flex items-center gap-2 text-sm font-medium text-emerald-700 mb-3">
                    <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-800 border border-emerald-200">Workforce | BOESL | BHC</span>
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-3 text-emerald-950">Manage applicants with clarity and speed</h1>
                <p class="text-slate-700 max-w-xl">A focused workflow for tracking submissions, registrations, IC cards, and insurance milestones for teams in Brunei.</p>

                <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:gap-3 gap-3 justify-center lg:justify-start">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition"
                       style="background-color:#86efac;"
                       onmouseenter="this.style.backgroundColor='#059669';"
                       onmouseleave="this.style.backgroundColor='#86efac';">Get Started</a>
                    <a href="#features" class="inline-flex items-center gap-2 text-white px-4 py-2 rounded-md text-sm shadow-sm transition"
                       style="background-color:#86efac;"
                       onmouseenter="this.style.backgroundColor='#059669';"
                       onmouseleave="this.style.backgroundColor='#86efac';">Explore</a>
                </div>
            </div>

            <div class="bg-white border border-emerald-100 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-emerald-900">Quick Overview</h3>
                        <p class="text-sm text-slate-500">At-a-glance workflow statuses</p>
                    </div>
                    <div class="text-xs text-emerald-700 bg-emerald-100 px-2 py-1 rounded">v1.0</div>
                </div>

                <!-- <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 rounded border border-yellow-200 bg-yellow-50">
                        <div class="text-sm text-yellow-700">Pending</div>
                        <div class="font-semibold text-lg text-yellow-900">12</div>
                    </div>
                    <div class="p-3 rounded border border-red-200 bg-red-50">
                        <div class="text-sm text-red-700">Registered</div>
                        <div class="font-semibold text-lg text-red-900">8</div>
                    </div>
                    <div class="p-3 rounded border border-emerald-200 bg-emerald-50">
                        <div class="text-sm text-emerald-700">Completed</div>
                        <div class="font-semibold text-lg text-emerald-900">24</div>
                    </div>
                </div> -->

                <div class="mt-5 border-t border-emerald-100 pt-4 text-sm text-slate-700">
                    <ul class="grid grid-cols-1 gap-2">
                        <li class="flex items-center gap-2"><i class="fas fa-lock text-emerald-600 w-5"></i> Role-based access</li>
                        <li class="flex items-center gap-2"><i class="fas fa-file-import text-yellow-600 w-5"></i> Excel import</li>
                        <li class="flex items-center gap-2"><i class="fas fa-bell text-red-600 w-5"></i> Smart reminders</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <section id="features" class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-lg bg-white border border-emerald-100 text-center shadow-sm">
                    <div class="text-2xl text-emerald-600 mb-2"><i class="fas fa-shield-alt"></i></div>
                    <div class="font-semibold text-slate-800">Secure Roles</div>
                </div>
                <div class="p-4 rounded-lg bg-white border border-emerald-100 text-center shadow-sm">
                    <div class="text-2xl text-yellow-600 mb-2"><i class="fas fa-file-import"></i></div>
                    <div class="font-semibold text-slate-800">Bulk Import</div>
                </div>
                <div class="p-4 rounded-lg bg-white border border-emerald-100 text-center shadow-sm">
                    <div class="text-2xl text-red-600 mb-2"><i class="fas fa-bell"></i></div>
                    <div class="font-semibold text-slate-800">Automated Reminders</div>
                </div>
                <div class="p-4 rounded-lg bg-white border border-emerald-100 text-center shadow-sm">
                    <div class="text-2xl text-emerald-700 mb-2"><i class="fas fa-chart-line"></i></div>
                    <div class="font-semibold text-slate-800">Reporting</div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-emerald-900">
            &copy; 2026 Applicant Entry - BOESL & BHC. All rights reserved.
        </div>
    </footer>
</body>
</html>
