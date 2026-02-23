<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant: ') }} {{ $applicant->applicant_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Edit Basic Info (Phone, Reg No) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Update Details</h3>
                    <form method="POST" action="{{ route('bhc.applicants.update', $applicant) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="phone_number" :value="__('Phone Number')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $applicant->phone_number)" autofocus />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="registration_no" :value="__('Registration No')" />
                            <x-text-input id="registration_no" class="block mt-1 w-full" type="text" name="registration_no" :value="old('registration_no', $applicant->registration_no)" />
                            <x-input-error :messages="$errors->get('registration_no')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Update Info') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tracking (IC / Insurance) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Update Tracking Status</h3>
                    <form method="POST" action="{{ route('bhc.applicants.updateTracking', $applicant) }}">
                        @csrf
                        
                        <div class="mb-4 flex items-center">
                            <input id="ic_card_received" type="checkbox" name="ic_card_received" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $applicant->ic_card_received ? 'checked' : '' }}>
                            <label for="ic_card_received" class="ml-2 text-sm text-gray-600">{{ __('IC Card Received') }}</label>
                        </div>

                        <div class="mb-4 flex items-center">
                            <input id="insurance_received" type="checkbox" name="insurance_received" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ $applicant->insurance_received ? 'checked' : '' }}>
                            <label for="insurance_received" class="ml-2 text-sm text-gray-600">{{ __('Insurance Received') }}</label>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button class="bg-purple-600 hover:bg-purple-700">
                                {{ __('Update Tracking') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                
                <div class="p-6 border-t border-gray-200">
                    <h3 class="font-bold text-lg text-gray-700 mb-2">Read-Only Info</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><strong>BHC No:</strong> {{ $applicant->bhc_no }}</li>
                        <li><strong>Passport:</strong> {{ $applicant->passport_no }}</li>
                        <li><strong>Agency:</strong> {{ $applicant->agency_name }}</li>
                        <li><strong>Company:</strong> {{ $applicant->company_name }}</li>
                        <li><strong>Flight Date:</strong> {{ $applicant->flight_date?->format('Y-m-d') }}</li>
                        <li><strong>Reg Date:</strong> {{ $applicant->registration_date?->format('Y-m-d') ?? 'Pending' }}</li>
                    </ul>
                    <a href="{{ route('bhc.applicants.index') }}" class="mt-4 inline-block text-sm text-blue-600 hover:underline">&larr; Back to List</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
