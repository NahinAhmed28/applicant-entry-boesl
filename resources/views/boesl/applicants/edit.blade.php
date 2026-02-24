<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-200">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('boesl.applicants.update', $applicant) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <x-input-label for="bhc_no" :value="__('BHC-No')" class="font-bold text-slate-700" />
                                <x-text-input id="bhc_no" class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" type="text" name="bhc_no" :value="old('bhc_no', $applicant->bhc_no)" required autofocus />
                                <x-input-error :messages="$errors->get('bhc_no')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="applicant_name" :value="__('Applicant Name')" class="font-bold text-slate-700" />
                                <x-text-input id="applicant_name" class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" type="text" name="applicant_name" :value="old('applicant_name', $applicant->applicant_name)" required />
                                <x-input-error :messages="$errors->get('applicant_name')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="passport_no" :value="__('Passport No')" class="font-bold text-slate-700" />
                                <x-text-input id="passport_no" class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" type="text" name="passport_no" :value="old('passport_no', $applicant->passport_no)" required />
                                <x-input-error :messages="$errors->get('passport_no')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="agency_name" :value="__('Agency Name')" class="font-bold text-slate-700" />
                                <x-text-input id="agency_name" class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" type="text" name="agency_name" :value="old('agency_name', $applicant->agency_name)" required />
                                <x-input-error :messages="$errors->get('agency_name')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="company_name" :value="__('Company Name')" class="font-bold text-slate-700" />
                                <x-text-input id="company_name" class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" type="text" name="company_name" :value="old('company_name', $applicant->company_name)" required />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-input-label for="flight_date" :value="__('Flight Date')" class="font-bold text-slate-700" />
                                <x-text-input id="flight_date" class="block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-200" type="date" name="flight_date" :value="old('flight_date', $applicant->flight_date?->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('flight_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-slate-100">
                            <a class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors mr-4" href="{{ route('boesl.applicants.index') }}">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-100 px-8 py-2.5 rounded-xl">
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
