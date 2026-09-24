<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Update Client Details') }}</h3>
                    </header>

                    <form method="POST" action="{{ route('clients.update', $client) }}" class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2" x-data="{ showRequirementForm: false, newRequirement: '', additionalRequirements: @js(old('additional_requirements', $client->additional_requirements ?? [])) }" data-confirm="Are you sure you want to update this client?">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="tin"><span>{{ __('TIN') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="tin" name="tin" type="text" class="mt-1 block w-full" :value="old('tin', $client->tin)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('tin')" />
                        </div>

                        <div>
                            <x-input-label for="client_name"><span>{{ __('Name') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="client_name" name="client_name" type="text" class="mt-1 block w-full" :value="old('client_name', $client->client_name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('client_name')" />
                        </div>

                        <div>
                            <x-input-label for="business_name"><span>{{ __('Business Name') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="business_name" name="business_name" type="text" class="mt-1 block w-full" :value="old('business_name', $client->business_name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('business_name')" />
                        </div>

                        <div>
                            <x-input-label for="address"><span>{{ __('Business Address') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $client->address)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div>
                            <x-input-label for="residential_address"><span>{{ __('Residential Address') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="residential_address" name="residential_address" type="text" class="mt-1 block w-full" :value="old('residential_address', $client->residential_address)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('residential_address')" />
                        </div>

                        <div>
                            <x-input-label for="tel_phone_number"><span>{{ __('Contact Number') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="tel_phone_number" name="tel_phone_number" type="text" class="mt-1 block w-full" :value="old('tel_phone_number', $client->tel_phone_number)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tel_phone_number')" />
                        </div>

                        <div>
                            <x-input-label for="email_address"><span>{{ __('Email Address') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="email_address" name="email_address" type="email" class="mt-1 block w-full" :value="old('email_address', $client->email_address)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email_address')" />
                        </div>

                        <div>
                            <x-input-label for="id_presented"><span>{{ __('ID Presented') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="id_presented" name="id_presented" type="text" class="mt-1 block w-full" :value="old('id_presented', $client->id_presented)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('id_presented')" />
                        </div>

                        <div>
                            <x-input-label for="fathers_name"><span>{{ __('Father\'s Name') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="fathers_name" name="fathers_name" type="text" class="mt-1 block w-full" :value="old('fathers_name', $client->fathers_name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fathers_name')" />
                        </div>

                        <div>
                            <x-input-label for="mothers_maiden_name"><span>{{ __('Mother\'s Maiden Name') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="mothers_maiden_name" name="mothers_maiden_name" type="text" class="mt-1 block w-full" :value="old('mothers_maiden_name', $client->mothers_maiden_name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('mothers_maiden_name')" />
                        </div>

                        <div>
                            <x-input-label for="date_of_birth"><span>{{ __('Date of Birth') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $client->date_of_birth?->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                        </div>

                        <div>
                            <x-input-label for="place_of_birth"><span>{{ __('Place of Birth') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="place_of_birth" name="place_of_birth" type="text" class="mt-1 block w-full" :value="old('place_of_birth', $client->place_of_birth)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('place_of_birth')" />
                        </div>

                        <div>
                            <x-input-label for="civil_status"><span>{{ __('Civil Status') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="civil_status" name="civil_status" type="text" class="mt-1 block w-full" :value="old('civil_status', $client->civil_status)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('civil_status')" />
                        </div>

                        <div>
                            <x-input-label for="religion"><span>{{ __('Religion') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="religion" name="religion" type="text" class="mt-1 block w-full" :value="old('religion', $client->religion)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('religion')" />
                        </div>

                        <div>
                            <x-input-label for="capitalization"><span>{{ __('Capitalization') }} <span class="text-red-600">*</span></span></x-input-label>
                            <x-text-input id="capitalization" name="capitalization" type="text" class="mt-1 block w-full" :value="old('capitalization', $client->capitalization)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('capitalization')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="notes" :value="__('Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $client->notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="md:col-span-2 border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900">{{ __('Business Registration') }}</h3>
                            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach (['BIR FORM 2303 / COR', 'DTI BN REGISTRATION', 'SEC CERTIFICATE OF INCORPORATION', 'ARTICLES OF INCORPORATION & BY LAWS', "MAYOR'S PERMIT"] as $registration)
                                    <label class="flex items-start gap-3 rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <input type="checkbox" name="business_registrations[]" value="{{ $registration }}" @checked(in_array($registration, old('business_registrations', $client->business_registrations ?? []), true)) class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span>{{ $registration }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between gap-4">
                                <h3 class="text-base font-semibold text-gray-900">{{ __('Additional Requirements') }}</h3>
                                <button type="button" x-on:click="showRequirementForm = true" class="inline-flex shrink-0 items-center rounded-md bg-gray-800 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    {{ __('Add Requirement') }}
                                </button>
                            </div>
                            <div class="mt-4 space-y-2">
                                <template x-for="(requirement, index) in additionalRequirements" :key="index">
                                    <div class="flex items-center justify-between gap-3 rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-700">
                                        <label class="flex min-w-0 items-start gap-3">
                                            <input type="checkbox" checked disabled class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm">
                                            <span x-text="requirement"></span>
                                        </label>
                                        <input type="hidden" name="additional_requirements[]" :value="requirement">
                                        <button type="button" x-on:click="additionalRequirements.splice(index, 1)" class="shrink-0 text-xs font-semibold text-red-600 hover:text-red-800" aria-label="{{ __('Remove requirement') }}">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </template>
                                <p x-show="additionalRequirements.length === 0" class="text-sm text-gray-500">{{ __('No additional requirements.') }}</p>
                            </div>

                            <div x-show="showRequirementForm" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="edit-add-requirement-title">
                                <div x-on:click.outside="showRequirementForm = false" class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                                    <div class="flex items-start justify-between gap-4">
                                        <h4 id="edit-add-requirement-title" class="text-lg font-semibold text-gray-900">{{ __('Add Requirement') }}</h4>
                                        <button type="button" x-on:click="showRequirementForm = false" aria-label="{{ __('Close') }}" class="text-2xl leading-none text-gray-400 hover:text-gray-600">&times;</button>
                                    </div>
                                    <div class="mt-5">
                                        <x-input-label for="new_requirement" :value="__('Requirement')" />
                                        <x-text-input id="new_requirement" name="new_requirement" type="text" x-model="newRequirement" x-on:keydown.enter.prevent="if (newRequirement.trim()) { additionalRequirements.push(newRequirement.trim()); newRequirement = ''; showRequirementForm = false }" class="mt-1 block w-full" placeholder="{{ __('Enter a requirement') }}" />
                                    </div>
                                    <div class="mt-6 flex items-center justify-end gap-3">
                                        <button type="button" x-on:click="showRequirementForm = false" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            {{ __('Cancel') }}
                                        </button>
                                        <button type="button" x-on:click="if (newRequirement.trim()) { additionalRequirements.push(newRequirement.trim()); newRequirement = ''; showRequirementForm = false }" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                            {{ __('Add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('settings.index', ['tab' => 'clients']) }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Back to Settings') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
