<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brunei Worker Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white min-h-screen">
    <header class="px-6 py-4 flex items-center justify-between max-w-7xl mx-auto">
        <h1 class="text-lg font-semibold">Brunei Worker Management</h1>
        <a href="{{ route('login') }}" class="bg-cyan-500 hover:bg-cyan-400 text-slate-900 font-semibold px-4 py-2 rounded-md">Login</a>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-cyan-300 uppercase text-sm tracking-wider">Workforce Tracking Platform</p>
            <h2 class="text-4xl md:text-5xl font-bold leading-tight mt-3">Manage BOESL and BHC applicant workflows end-to-end.</h2>
            <p class="text-slate-300 mt-5">Track submissions, registration progress, IC card follow-up, and insurance milestones from a unified reporting dashboard.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('login') }}" class="bg-white text-slate-900 px-5 py-3 rounded-md font-semibold">Get Started</a>
                <a href="#features" class="border border-slate-600 px-5 py-3 rounded-md font-semibold">Explore Features</a>
            </div>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-2xl">
            <h3 class="font-semibold text-cyan-200">Core Workflows</h3>
            <ul class="mt-4 space-y-3 text-slate-300 text-sm">
                <li>• BOESL admin manual + Excel-based applicant entry</li>
                <li>• BHC admin registration updates with auto registration date</li>
                <li>• IC card reminder at 3 months after flight date</li>
                <li>• Insurance reminder at 6 months after registration</li>
                <li>• Role-based access for boesl-admin, bhc-admin, and super-admin</li>
            </ul>
        </div>
    </main>

    <section id="features" class="max-w-7xl mx-auto px-6 pb-16 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach (['Role-based control', 'Submission lock after BOESL submit', 'Unified applicant lists', 'Responsive dashboards', 'Chart-based reporting', 'Centralized user management'] as $feature)
            <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4">{{ $feature }}</div>
        @endforeach
    </section>
</body>
</html>
