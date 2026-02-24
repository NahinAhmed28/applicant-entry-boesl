<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BHC Applicants List') }}
        </h2>
    </x-slot>

    <div class="py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
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

                    <form method="GET" action="{{ route('bhc.applicants.index') }}" x-show="filterOpen" x-cloak class="mb-4 rounded-lg border border-slate-200 bg-slate-50 p-3 sm:p-4">
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
                                <a href="{{ route('bhc.applicants.index') }}" class="inline-flex items-center rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-white">Reset</a>
                            </div>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                    <table class="min-w-[980px] w-full divide-y divide-gray-200">
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
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applicants as $applicant)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $applicant->bhc_no }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->applicant_name }}<br><small>{{ $applicant->phone_number }}</small></td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->passport_no }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-medium text-gray-900">{{ $applicant->agency_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $applicant->company_name }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $applicant->flight_date?->format('Y-m-d') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ str_replace('_', ' ', $applicant->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $applicant->registered_at?->format('Y-m-d') ?? 'Pending' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 text-xs rounded {{ $applicant->ic_received_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}" title="IC Card">IC</span>
                                            <span class="px-2 py-1 text-xs rounded {{ $applicant->insurance_received_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}" title="Insurance">Ins</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('bhc.applicants.edit', $applicant) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded">Edit</a>
                                            
                                            @if(!$applicant->registered_at)
                                                <form action="{{ route('bhc.applicants.markRegistered', $applicant) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 px-3 py-1 rounded" onclick="return confirm('Mark as registered now?')">Mark Reg</button>
                                                </form>
                                            @endif
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
