<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Applicant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('boesl.applicants.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="bhc_no" :value="__('BHC-No')" />
                                <x-text-input id="bhc_no" class="block mt-1 w-full" type="text" name="bhc_no" :value="old('bhc_no')" required autofocus />
                                <x-input-error :messages="$errors->get('bhc_no')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="applicant_name" :value="__('Applicant Name')" />
                                <x-text-input id="applicant_name" class="block mt-1 w-full" type="text" name="applicant_name" :value="old('applicant_name')" required />
                                <x-input-error :messages="$errors->get('applicant_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="passport_no" :value="__('Passport No')" />
                                <x-text-input id="passport_no" class="block mt-1 w-full" type="text" name="passport_no" :value="old('passport_no')" required />
                                <x-input-error :messages="$errors->get('passport_no')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="agency_name" :value="__('Agency Name')" />
                                <x-text-input id="agency_name" class="block mt-1 w-full" type="text" name="agency_name" :value="old('agency_name')" required />
                                <x-input-error :messages="$errors->get('agency_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="flight_date" :value="__('Flight Date')" />
                                <x-text-input id="flight_date" class="block mt-1 w-full" type="date" name="flight_date" :value="old('flight_date')" required />
                                <x-input-error :messages="$errors->get('flight_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4" href="{{ route('boesl.applicants.index') }}">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
