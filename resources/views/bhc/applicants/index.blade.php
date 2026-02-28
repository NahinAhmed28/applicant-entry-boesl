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
                                <option value="sent_to_bhc" @selected(request('status') === 'sent_to_bhc')>Pending</option>
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

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 text-gray-900 border-b border-gray-100 flex items-center justify-between flex-wrap gap-4">
                        <h3 class="text-lg font-bold text-gray-800">Applicants Management</h3>
                        
                        <!-- Entries per page -->
                        <div class="flex items-center gap-2">
                            <label for="per_page" class="text-sm font-medium text-gray-700">Show</label>
                            <form action="{{ route('bhc.applicants.index') }}" method="GET" x-data x-ref="perPageForm">
                                @foreach(request()->except('per_page', 'page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <select 
                                    name="per_page" 
                                    id="per_page" 
                                    @change="$refs.perPageForm.submit()"
                                    class="text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-1"
                                >
                                    @foreach([10, 25, 50, 100] as $val)
                                        <option value="{{ $val }}" @selected(request('per_page', 10) == $val)>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <span class="text-sm font-medium text-gray-700">entries</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto" x-data="{ regModalOpen: false, regUrl: '', regName: '' }">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">BHC No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Applicant Info</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Agency / Company</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Flight Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Reg. Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">IC / Ins</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applicants as $applicant)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $applicant->bhc_no }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $applicant->applicant_name }}</div>
                                        <div class="text-xs text-gray-500 font-medium">{{ $applicant->passport_no }}</div>
                                        @if($applicant->phone_number)
                                            <div class="text-[10px] text-indigo-600 mt-1">{{ $applicant->phone_number }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $applicant->agency_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $applicant->company_name }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $applicant->flight_date?->format('Y-M-d') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @php
                                            $statusConfig = [
                                                'sent_to_bhc' => ['label' => 'Pending', 'class' => 'bg-red-100 text-red-700 border-red-200'],
                                                'registered' => ['label' => 'Registered', 'class' => 'bg-green-100 text-green-700 border-green-200'],
                                                'ic_received' => ['label' => 'IC Received', 'class' => 'bg-blue-100 text-blue-800 border-blue-200'],
                                                'insurance_received' => ['label' => 'Insurance Received', 'class' => 'bg-orange-100 text-orange-700 border-orange-200'],
                                            ];
                                            $config = $statusConfig[$applicant->status] ?? ['label' => str_replace('_', ' ', $applicant->status), 'class' => 'bg-gray-100 text-gray-800 border-gray-200'];
                                        @endphp
                                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $config['class'] }} border uppercase tracking-tight">
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $applicant->registered_at?->format('Y-M-d') ?? 'Pending' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center gap-2">
                                            <span class="w-8 text-center py-1 text-[10px] font-bold rounded border {{ $applicant->ic_received_at ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-50 text-red-700 border-red-100' }}" title="IC Card">IC</span>
                                            <span class="w-8 text-center py-1 text-[10px] font-bold rounded border {{ $applicant->insurance_received_at ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-50 text-red-700 border-red-100' }}" title="Insurance">INS</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('bhc.applicants.edit', $applicant) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 px-3 py-1.5 rounded-md transition-colors shadow-sm">Edit</a>
                                            
                                            @if(!$applicant->registered_at)
                                                <button 
                                                    type="button"
                                                    @click="regModalOpen = true; regUrl = '{{ route('bhc.applicants.markRegistered', $applicant) }}'; regName = '{{ addslashes($applicant->applicant_name) }}'"
                                                    class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 border border-green-200 px-3 py-1.5 rounded-md transition-colors shadow-sm"
                                                >Mark Reg</button>
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

                    @if($applicants->hasPages())
                        <div class="p-4 border-t border-gray-100">
                            {{ $applicants->links() }}
                        </div>
                    @endif

                    <!-- Registration Modal -->
                    <div x-show="regModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="regModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="regModalOpen = false"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="regModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                <div>
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-5">
                                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Confirm Registration</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to mark <span class="font-bold text-gray-900" x-text="regName"></span> as registered? This action will update their status and registration date.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                    <form :action="regUrl" method="POST" class="sm:col-start-2">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:text-sm transition-colors">
                                            Yes, Mark Registered
                                        </button>
                                    </form>
                                    <button type="button" @click="regModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:col-start-1 sm:text-sm transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
