<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Boesl Applicants') }}
        </h2>
    </x-slot>

    <div class="py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" x-data="{ inputMode: 'none', fileName: '' }">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        <button @click="inputMode = 'single'" :class="inputMode === 'single' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'" class="flex-1 py-3 px-4 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Single Input
                        </button>
                        <button @click="inputMode = 'batch'" :class="inputMode === 'batch' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'" class="flex-1 py-3 px-4 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Batch Input
                        </button>
                    </div>

                    <div x-show="inputMode === 'single'" x-cloak x-transition class="p-4 border border-blue-100 bg-blue-50 rounded-lg">
                        <p class="mb-3 text-sm text-blue-800">Fill in the applicant details manually.</p>
                        <a href="{{ route('boesl.applicants.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Go to Creation Form
                        </a>
                    </div>

                    <div x-show="inputMode === 'batch'" x-cloak x-transition class="p-4 border border-green-100 bg-green-50 rounded-lg">
                        <form action="{{ route('boesl.applicants.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col gap-3">
                                <div class="flex flex-col sm:flex-row items-center gap-3">
                                    <div class="relative w-full">
                                        <input type="file" name="excel_file" id="excel_file" class="hidden" @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" accept=".xlsx,.csv" />
                                        <label for="excel_file" class="cursor-pointer flex items-center justify-between w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-sm hover:border-green-500 transition-colors">
                                            <span x-text="fileName || 'Select Excel/CSV file...'" class="text-gray-600 truncate mr-2"></span>
                                            <span class="bg-gray-100 px-2 py-1 rounded text-xs text-gray-500">Browse</span>
                                        </label>
                                    </div>
                                    <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition-colors whitespace-nowrap">
                                        Upload Excel
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('boesl.applicants.template') }}" class="text-sm text-green-700 hover:text-green-900 underline flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                        Download Template
                                    </a>
                                </div>
                                @error('excel_file')
                                    <p class="mt-1 text-sm text-red-600">
                                        @if(is_array($message))
                                            @foreach($message as $err)
                                                {{ $err }}<br>
                                            @endforeach
                                        @else
                                            {{ $message }}
                                        @endif
                                    </p>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ filterOpen: {{ request()->hasAny(['bhc_no', 'applicant_name', 'passport_no', 'flight_date', 'status', 'registered_at', 'ic_ins']) ? 'true' : 'false' }} }">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-slate-700">Applicants</h3>
                        <button type="button" @click="filterOpen = !filterOpen" class="inline-flex items-center rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            <span x-text="filterOpen ? 'Hide Filters' : 'Show Filters'"></span>
                        </button>
                    </div>

                    <form method="GET" action="{{ route('boesl.applicants.index') }}" x-show="filterOpen" x-cloak class="mb-4 rounded-lg border border-slate-200 bg-slate-50 p-3 sm:p-4">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                            <input type="text" name="bhc_no" value="{{ request('bhc_no') }}" placeholder="BHC No" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <input type="text" name="applicant_name" value="{{ request('applicant_name') }}" placeholder="Name" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <input type="text" name="passport_no" value="{{ request('passport_no') }}" placeholder="Passport" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <input type="date" name="flight_date" value="{{ request('flight_date') }}" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <select name="status" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Status (Any)</option>
                                <option value="sent_to_bhc" @selected(request('status') === 'sent_to_bhc')>Sent to BHC</option>
                                <option value="registered" @selected(request('status') === 'registered')>Registered</option>
                                <option value="ic_received" @selected(request('status') === 'ic_received')>IC Received</option>
                                <option value="insurance_received" @selected(request('status') === 'insurance_received')>Insurance Received</option>
                            </select>
                            <input type="date" name="registered_at" value="{{ request('registered_at') }}" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <select name="ic_ins" class="w-full rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">IC / Ins. (Any)</option>
                                <option value="ic_received" @selected(request('ic_ins') === 'ic_received')>IC Received</option>
                                <option value="ic_pending" @selected(request('ic_ins') === 'ic_pending')>IC Pending</option>
                                <option value="ins_received" @selected(request('ic_ins') === 'ins_received')>Ins. Received</option>
                                <option value="ins_pending" @selected(request('ic_ins') === 'ins_pending')>Ins. Pending</option>
                                <option value="both_received" @selected(request('ic_ins') === 'both_received')>Both Received</option>
                                <option value="both_pending" @selected(request('ic_ins') === 'both_pending')>Both Pending</option>
                            </select>
                            <div class="flex items-center gap-2">
                                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">Search</button>
                                <a href="{{ route('boesl.applicants.index') }}" class="inline-flex items-center rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-white">Reset</a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                    <table class="min-w-[1080px] w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BHC No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passport</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency / Company</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flight Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reg. Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC / Ins</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applicants as $applicant)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $applicant->bhc_no }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->applicant_name }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->passport_no }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-medium text-gray-900">{{ $applicant->agency_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $applicant->company_name }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->flight_date?->format('Y-m-d') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ str_replace('_', ' ', $applicant->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->registered_at?->format('Y-m-d') ?? 'Pending' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 text-xs rounded {{ $applicant->ic_received_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}" title="IC Card">IC</span>
                                            <span class="px-2 py-1 text-xs rounded {{ $applicant->insurance_received_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}" title="Insurance">Ins</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if($applicants->isEmpty())
                                <tr>
                                    <td colspan="8" class="px-4 py-4 text-center text-sm text-gray-500">No applicants found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
