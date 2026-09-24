<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6" x-data="{ activeMenu: @js(in_array(request('tab'), ['users', 'clients', 'tasks', 'forms']) ? request('tab') : 'users'), showTaskForm: @js($errors->has('task_name')), showFormEntry: @js($errors->has('form_name')) }">
                                                        </svg>
                    <div>

                    <div x-show="activeMenu === 'users'">
                        <div class="mb-5 flex items-center justify-between gap-4">
                            @can('manage-users')
                                <button type="button" x-on:click="$dispatch('open-modal', 'register-user')" class="inline-flex items-center rounded-md bg-gray-800 px-5 py-3 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    {{ __('Register New User') }}
                                </button>
                            @endcan
                        </div>

                        <x-modal name="register-user" :show="$errors->hasAny(['name', 'email', 'role', 'password', 'password_confirmation'])" maxWidth="md" focusable>
                            <form method="POST" action="{{ route('users.store') }}" class="space-y-6 p-6" data-confirm="Are you sure you want to register this user?">
                                @csrf

                                <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Create User Account') }}</h2>
                                    <button type="button" x-on:click="$dispatch('close-modal', 'register-user')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        &times;
                                    </button>
                                </div>

                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="role" :value="__('Role')" />
                                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" @selected(old('role', 'requester') === $role)>{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4">
                                    <button type="button" x-on:click="$dispatch('close-modal', 'register-user')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        {{ __('Cancel') }}
                                    </button>
                                    <x-primary-button>{{ __('Register') }}</x-primary-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>

                    <div x-show="activeMenu === 'users'">
                        @if (session('status') === 'user-created')
                            <p class="mb-3 text-sm text-green-600">{{ __('New user registered successfully.') }}</p>
                        @endif

                        @if (session('status') === 'user-updated')
                            <p class="mb-3 text-sm text-green-600">{{ __('User details updated successfully.') }}</p>
                        @endif

                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Role') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Registered At') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($user->role) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($user->status) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->created_at?->format('F d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @can('manage-users')
                                                    <button type="button" x-on:click="$dispatch('open-modal', 'edit-user-{{ $user->id }}')" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                        {{ __('Edit') }}
                                                    </button>
                                                @else
                                                    <span class="text-gray-400">{{ __('—') }}</span>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">{{ __('No registered users found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $users->appends(['tab' => 'users', 'clients_page' => request('clients_page'), 'tasks_page' => request('tasks_page'), 'forms_page' => request('forms_page')])->links() }}
                        </div>

                        @foreach ($users as $user)
                            <x-modal name="edit-user-{{ $user->id }}" :show="$errors->hasAny(['name', 'email', 'role', 'status']) && (string) old('editing_user_id') === (string) $user->id" maxWidth="md" focusable>
                                <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6 p-6" data-confirm="{{ __('Are you sure you want to update this user?') }}">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="editing_user_id" value="{{ $user->id }}">

                                    <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Edit User') }}</h2>
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-user-{{ $user->id }}')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            &times;
                                        </button>
                                    </div>

                                    <div>
                                        <x-input-label for="edit-name-{{ $user->id }}" :value="__('Name')" />
                                        <x-text-input id="edit-name-{{ $user->id }}" class="mt-1 block w-full" type="text" name="name" :value="old('editing_user_id') == $user->id ? old('name') : $user->name" required autocomplete="name" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="edit-email-{{ $user->id }}" :value="__('Email')" />
                                        <x-text-input id="edit-email-{{ $user->id }}" class="mt-1 block w-full" type="email" name="email" :value="old('editing_user_id') == $user->id ? old('email') : $user->email" required autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="edit-role-{{ $user->id }}" :value="__('Role')" />
                                        <select id="edit-role-{{ $user->id }}" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}" @selected((old('editing_user_id') == $user->id ? old('role') : $user->role) === $role)>{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="edit-status-{{ $user->id }}" :value="__('Status')" />
                                        <select id="edit-status-{{ $user->id }}" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            @foreach (\App\Models\User::statuses() as $status)
                                                <option value="{{ $status }}" @selected((old('editing_user_id') == $user->id ? old('status') : $user->status) === $status)>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                    </div>

                                    <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4">
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-user-{{ $user->id }}')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            {{ __('Cancel') }}
                                        </button>
                                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach
                    </div>

                    <div id="clients-lists" class="space-y-4" x-show="activeMenu === 'clients'">
                        @if (session('status') === 'client-created')
                            <p class="text-sm text-green-600">{{ __('Client added successfully.') }}</p>
                        @endif

                        @if (session('status') === 'client-updated')
                            <p class="text-sm text-green-600">{{ __('Client updated successfully.') }}</p>
                        @endif
                        <button type="button" x-on:click="$dispatch('open-modal', 'add-client')" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            {{ __('ADD CLIENT') }}
                        </button>

                        <x-modal name="add-client" :show="$errors->hasAny(['client_name', 'business_name', 'address', 'residential_address', 'tin', 'tel_phone_number', 'email_address', 'id_presented', 'fathers_name', 'mothers_maiden_name', 'date_of_birth', 'place_of_birth', 'civil_status', 'religion', 'capitalization', 'notes', 'business_registrations', 'business_registrations.*', 'additional_requirements', 'additional_requirements.*'])" maxWidth="2xl" focusable>
                            <form method="POST" action="{{ route('clients.store') }}" class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2" x-data="{ step: 1, showRequirementForm: false, newRequirement: '', invalidFields: [], additionalRequirements: @js(old('additional_requirements', [])), clientDetails: { tin: @js(old('tin')), name: @js(old('client_name')), businessName: @js(old('business_name')), address: @js(old('address')), residentialAddress: @js(old('residential_address')), contact: @js(old('tel_phone_number')), email: @js(old('email_address')), idPresented: @js(old('id_presented')), fathersName: @js(old('fathers_name')), mothersMaidenName: @js(old('mothers_maiden_name')), dateOfBirth: @js(old('date_of_birth')), placeOfBirth: @js(old('place_of_birth')), civilStatus: @js(old('civil_status')), religion: @js(old('religion')), capitalization: @js(old('capitalization')) }, validateClientDetails() { this.invalidFields = Object.entries(this.clientDetails).filter(([, value]) => !String(value ?? '').trim()).map(([field]) => field); if (this.invalidFields.length) { this.invalidFields.forEach((field) => { const input = this.$refs[field]; if (input) { input.classList.remove('animate-shake'); void input.offsetWidth; input.classList.add('animate-shake'); } }); return; } this.step = 2; } }" data-confirm="Are you sure you want to save this client?">
                                @csrf

                                <div class="md:col-span-2 flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Add Client') }}</h2>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Enter the client details below.') }}</p>
                                    </div>
                                    <button type="button" x-on:click="$dispatch('close-modal', 'add-client')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        &times;
                                    </button>
                                </div>

                                <div class="md:col-span-2 flex items-center gap-2 border-b border-gray-200 pb-5" aria-label="{{ __('Client creation progress') }}">
                                    <template x-for="module in [{ number: 1, label: '{{ __('Client Details') }}' }, { number: 2, label: '{{ __('Business Registration') }}' }, { number: 3, label: '{{ __('Additional Requirements') }}' }]" :key="module.number">
                                        <div class="flex min-w-0 flex-1 items-center gap-2">
                                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border text-xs font-semibold" :class="step >= module.number ? 'border-gray-800 bg-gray-800 text-white' : 'border-gray-300 bg-white text-gray-500'" x-text="module.number"></div>
                                            <span class="hidden truncate text-xs font-medium sm:block" :class="step >= module.number ? 'text-gray-900' : 'text-gray-500'" x-text="module.label"></span>
                                            <div x-show="module.number < 3" class="h-px flex-1 bg-gray-200"></div>
                                        </div>
                                    </template>
                                </div>

                                <div class="md:col-span-2 grid grid-cols-1 gap-6 md:grid-cols-2" x-show="step === 1" x-cloak>
                                <div>
                                    <x-input-label for="tin"><span>{{ __('TIN') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="tin" name="tin" type="text" x-ref="tin" x-model="clientDetails.tin" class="mt-1 block w-full" :value="old('tin')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tin')" />
                                </div>

                                <div>
                                    <x-input-label for="client_name"><span>{{ __('Name') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="client_name" name="client_name" type="text" x-ref="name" x-model="clientDetails.name" :value="old('client_name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('client_name')" />
                                </div>

                                <div>
                                    <x-input-label for="business_name"><span>{{ __('Business Name') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="business_name" name="business_name" type="text" x-ref="businessName" x-model="clientDetails.businessName" class="mt-1 block w-full" :value="old('business_name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('business_name')" />
                                </div>

                                <div>
                                    <x-input-label for="address"><span>{{ __('Business Address') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="address" name="address" type="text" x-ref="address" x-model="clientDetails.address" :value="old('address')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>

                                <div>
                                    <x-input-label for="residential_address"><span>{{ __('Residential Address') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="residential_address" name="residential_address" type="text" x-ref="residentialAddress" x-model="clientDetails.residentialAddress" class="mt-1 block w-full" :value="old('residential_address')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('residential_address')" />
                                </div>

                                <div>
                                    <x-input-label for="tel_phone_number"><span>{{ __('Contact Number') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="tel_phone_number" name="tel_phone_number" type="text" x-ref="contact" x-model="clientDetails.contact" :value="old('tel_phone_number')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tel_phone_number')" />
                                </div>

                                <div>
                                    <x-input-label for="email_address"><span>{{ __('Email Address') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="email_address" name="email_address" type="email" x-ref="email" x-model="clientDetails.email" class="mt-1 block w-full" :value="old('email_address')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email_address')" />
                                </div>

                                <div>
                                    <x-input-label for="id_presented"><span>{{ __('ID Presented') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="id_presented" name="id_presented" type="text" x-ref="idPresented" x-model="clientDetails.idPresented" class="mt-1 block w-full" :value="old('id_presented')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('id_presented')" />
                                </div>

                                <div>
                                    <x-input-label for="fathers_name"><span>{{ __('Father\'s Name') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="fathers_name" name="fathers_name" type="text" x-ref="fathersName" x-model="clientDetails.fathersName" class="mt-1 block w-full" :value="old('fathers_name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('fathers_name')" />
                                </div>

                                <div>
                                    <x-input-label for="mothers_maiden_name"><span>{{ __('Mother\'s Maiden Name') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="mothers_maiden_name" name="mothers_maiden_name" type="text" x-ref="mothersMaidenName" x-model="clientDetails.mothersMaidenName" class="mt-1 block w-full" :value="old('mothers_maiden_name')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('mothers_maiden_name')" />
                                </div>

                                <div>
                                    <x-input-label for="date_of_birth"><span>{{ __('Date of Birth') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" x-ref="dateOfBirth" x-model="clientDetails.dateOfBirth" class="mt-1 block w-full" :value="old('date_of_birth')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
                                </div>

                                <div>
                                    <x-input-label for="place_of_birth"><span>{{ __('Place of Birth') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="place_of_birth" name="place_of_birth" type="text" x-ref="placeOfBirth" x-model="clientDetails.placeOfBirth" class="mt-1 block w-full" :value="old('place_of_birth')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('place_of_birth')" />
                                </div>

                                <div>
                                    <x-input-label for="civil_status"><span>{{ __('Civil Status') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="civil_status" name="civil_status" type="text" x-ref="civilStatus" x-model="clientDetails.civilStatus" class="mt-1 block w-full" :value="old('civil_status')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('civil_status')" />
                                </div>

                                <div>
                                    <x-input-label for="religion"><span>{{ __('Religion') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="religion" name="religion" type="text" x-ref="religion" x-model="clientDetails.religion" class="mt-1 block w-full" :value="old('religion')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('religion')" />
                                </div>

                                <div>
                                    <x-input-label for="capitalization"><span>{{ __('Capitalization') }} <span class="text-red-600" aria-hidden="true">*</span></span></x-input-label>
                                    <x-text-input id="capitalization" name="capitalization" type="text" x-ref="capitalization" x-model="clientDetails.capitalization" class="mt-1 block w-full" :value="old('capitalization')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('capitalization')" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="notes" :value="__('Notes')" />
                                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                                </div>

                                <div class="md:col-span-2 flex items-center justify-between border-t border-gray-200 pt-6">
                                    <span class="text-sm text-gray-500">{{ __('Complete the required fields to continue.') }}</span>
                                    <button type="button" x-on:click="validateClientDetails()" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        {{ __('Next') }}
                                    </button>
                                </div>
                                </div>

                                <div class="md:col-span-2 border-t border-gray-200 pt-6" x-show="step === 2" x-cloak>
                                    <h3 class="text-base font-semibold text-gray-900">{{ __('Business Registration') }}</h3>
                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        @foreach (['BIR FORM 2303 / COR', 'DTI BN REGISTRATION', 'SEC CERTIFICATE OF INCORPORATION', 'ARTICLES OF INCORPORATION & BY LAWS', "MAYOR'S PERMIT"] as $registration)
                                            <label class="flex items-start gap-3 rounded-md border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                <input type="checkbox" name="business_registrations[]" value="{{ $registration }}" @checked(in_array($registration, old('business_registrations', []), true)) class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                <span>{{ $registration }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('business_registrations')" />

                                    <div class="mt-6 flex items-center justify-between">
                                        <button type="button" x-on:click="step = 1" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            {{ __('Back') }}
                                        </button>
                                        <button type="button" x-on:click="step = 3" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                            {{ __('Next') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="md:col-span-2 border-t border-gray-200 pt-6" x-show="step === 3" x-cloak>
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">{{ __('Additional Requirements') }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">{{ __('Add any other documents or requirements.') }}</p>
                                        </div>
                                        <button type="button" x-on:click="showRequirementForm = true" class="inline-flex shrink-0 items-center rounded-md bg-gray-800 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                            {{ __('Add Requirement') }}
                                        </button>
                                    </div>

                                    <div class="mt-4 space-y-2" x-show="additionalRequirements.length > 0">
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
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('additional_requirements')" />

                                    <div x-show="showRequirementForm" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 px-4" role="dialog" aria-modal="true" aria-labelledby="add-requirement-title">
                                        <div x-on:click.outside="showRequirementForm = false" class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                                            <div class="flex items-start justify-between gap-4">
                                                <h4 id="add-requirement-title" class="text-lg font-semibold text-gray-900">{{ __('Add Requirement') }}</h4>
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

                                <div class="md:col-span-2 flex items-center justify-between gap-3" x-show="step === 3" x-cloak>
                                    <button type="button" x-on:click="step = 2" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        {{ __('Back') }}
                                    </button>
                                    <div class="flex items-center gap-3">
                                    <x-primary-button>{{ __('Save Client') }}</x-primary-button>
                                    <button type="button" x-on:click="$dispatch('close-modal', 'add-client')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        {{ __('Cancel') }}
                                    </button>
                                    </div>
                                </div>
                            </form>
                        </x-modal>

                        <div class="hidden overflow-x-auto border border-gray-200 rounded-lg md:block">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Client Name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Address') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Contact Person') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('TIN') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Tel/Phone Number') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($clients as $client)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->client_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->address }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->contact_person }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->tin }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $client->tel_phone_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <button type="button" x-on:click="$dispatch('open-modal', 'client-details-{{ $client->id }}')" aria-label="{{ __('View client details') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 bg-white text-gray-600 shadow-sm transition hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25-4.5a.75.75 0 01-1.08 0l-4.25 4.5a.75.75 0 01.02 1.06z" clip-rule="evenodd" />
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z" />
                                                            <circle cx="12" cy="12" r="2.75" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">{{ __('No clients found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @foreach ($clients as $client)
                            <x-modal name="client-details-{{ $client->id }}" maxWidth="2xl">
                                <div class="p-6">
                                    <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                        <div>
                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Client Details') }}</p>
                                            <h2 class="mt-1 text-lg font-semibold text-gray-900">{{ $client->client_name }}</h2>
                                        </div>
                                        <button type="button" x-on:click="$dispatch('close-modal', 'client-details-{{ $client->id }}')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">&times;</button>
                                    </div>

                                    <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2 lg:grid-cols-3">
                                        @foreach ([
                                            __('TIN') => $client->tin,
                                            __('Business Name') => $client->business_name,
                                            __('Business Address') => $client->address,
                                            __('Residential Address') => $client->residential_address,
                                            __('Contact Number') => $client->tel_phone_number,
                                            __('Email Address') => $client->email_address,
                                            __('ID Presented') => $client->id_presented,
                                            __('Father\'s Name') => $client->fathers_name,
                                            __('Mother\'s Maiden Name') => $client->mothers_maiden_name,
                                            __('Date of Birth') => $client->date_of_birth?->format('F d, Y'),
                                            __('Place of Birth') => $client->place_of_birth,
                                            __('Civil Status') => $client->civil_status,
                                            __('Religion') => $client->religion,
                                            __('Capitalization') => $client->capitalization,
                                            __('Notes') => $client->notes,
                                        ] as $label => $value)
                                            <div>
                                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $label }}</dt>
                                                <dd class="mt-1 break-words text-gray-900">{{ $value ?: '—' }}</dd>
                                            </div>
                                        @endforeach
                                        <div class="sm:col-span-2 lg:col-span-3">
                                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Business Registration') }}</dt>
                                            <dd class="mt-1 break-words text-gray-900">{{ !empty($client->business_registrations) ? implode(', ', $client->business_registrations) : '—' }}</dd>
                                        </div>
                                        <div class="sm:col-span-2 lg:col-span-3">
                                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Additional Requirements') }}</dt>
                                            <dd class="mt-1 break-words text-gray-900">{{ !empty($client->additional_requirements) ? implode(', ', $client->additional_requirements) : '—' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </x-modal>
                        @endforeach

                        <div class="grid gap-3 md:hidden">
                            @forelse ($clients as $client)
                                <article class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Client') }}</p>
                                            <h3 class="mt-1 break-words text-sm font-semibold text-gray-900">{{ $client->client_name }}</h3>
                                        </div>
                                        <span class="shrink-0 text-xs text-gray-500">#{{ $client->id }}</span>
                                    </div>
                                    <dl class="mt-4 grid gap-3 border-t border-gray-100 pt-3 text-sm">
                                        <div>
                                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Address') }}</dt>
                                            <dd class="mt-1 break-words text-gray-900">{{ $client->address ?: '—' }}</dd>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Contact Person') }}</dt>
                                                <dd class="mt-1 break-words text-gray-900">{{ $client->contact_person ?: '—' }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Tel/Phone Number') }}</dt>
                                                <dd class="mt-1 break-words text-gray-900">{{ $client->tel_phone_number ?: '—' }}</dd>
                                            </div>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('TIN') }}</dt>
                                            <dd class="mt-1 break-words text-gray-900">{{ $client->tin ?: '—' }}</dd>
                                        </div>
                                    </dl>
                                    <a href="{{ route('clients.edit', $client) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-md bg-gray-800 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        {{ __('Edit') }}
                                    </a>
                                </article>
                            @empty
                                <p class="rounded-lg border border-gray-200 px-4 py-3 text-sm text-gray-500">{{ __('No clients found.') }}</p>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            {{ $clients->appends(['tab' => 'clients', 'users_page' => request('users_page'), 'tasks_page' => request('tasks_page'), 'forms_page' => request('forms_page')])->links() }}
                        </div>
                    </div>

                    <div id="tasks-lists" class="space-y-4" x-show="activeMenu === 'tasks'">
                        @if (session('status') === 'task-created')
                            <p class="text-sm text-green-600">{{ __('Task added successfully.') }}</p>
                        @endif

                        @if (session('status') === 'task-updated')
                            <p class="text-sm text-green-600">{{ __('Task updated successfully.') }}</p>
                        @endif

                        <button type="button" x-on:click="$dispatch('open-modal', 'add-task')" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            {{ __('ADD TASK') }}
                        </button>

                        <x-modal name="add-task" :show="$errors->has('task_name')" maxWidth="md" focusable>
                            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6 p-6" data-confirm="Are you sure you want to save this task?">
                                @csrf
                                <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Add Task') }}</h2>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Create a task for the workspace.') }}</p>
                                    </div>
                                    <button type="button" x-on:click="$dispatch('close-modal', 'add-task')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600">&times;</button>
                                </div>
                                <div>
                                    <x-input-label for="task_name" :value="__('Task Name')" />
                                    <x-text-input id="task_name" name="task_name" type="text" class="mt-2 block w-full" :value="old('task_name')" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('task_name')" />
                                </div>
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" x-on:click="$dispatch('close-modal', 'add-task')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50">{{ __('Cancel') }}</button>
                                    <x-primary-button>{{ __('Save Task') }}</x-primary-button>
                                </div>
                            </form>
                        </x-modal>

                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Task Name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($tasks as $task)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->task_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <button type="button" x-on:click="$dispatch('open-modal', 'edit-task-{{ $task->id }}')" class="inline-flex items-center rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                    {{ __('Edit') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-sm text-gray-500 text-center">{{ __('No tasks found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @foreach ($tasks as $task)
                            <x-modal name="edit-task-{{ $task->id }}" maxWidth="md" focusable>
                                <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6 p-6" data-confirm="Are you sure you want to update this task?">
                                    @csrf
                                    @method('patch')
                                    <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                        <div>
                                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Edit Task') }}</h2>
                                            <p class="mt-1 text-sm text-gray-500">{{ __('Update the task name below.') }}</p>
                                        </div>
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-task-{{ $task->id }}')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600">&times;</button>
                                    </div>
                                    <div>
                                        <x-input-label for="edit_task_name_{{ $task->id }}" :value="__('Task Name')" />
                                        <x-text-input id="edit_task_name_{{ $task->id }}" name="task_name" type="text" class="mt-2 block w-full" :value="old('task_name', $task->task_name)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('task_name')" />
                                    </div>
                                    <div class="flex items-center justify-end gap-3">
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-task-{{ $task->id }}')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50">{{ __('Cancel') }}</button>
                                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach

                        <div class="mt-4">
                            {{ $tasks->appends(['tab' => 'tasks', 'users_page' => request('users_page'), 'clients_page' => request('clients_page'), 'forms_page' => request('forms_page')])->links() }}
                        </div>
                    </div>

                    <div id="forms-lists" class="space-y-4" x-show="activeMenu === 'forms'">
                        @if (session('status') === 'form-created')
                            <p class="text-sm text-green-600">{{ __('Form added successfully.') }}</p>
                        @endif

                        @if (session('status') === 'form-updated')
                            <p class="text-sm text-green-600">{{ __('Form updated successfully.') }}</p>
                        @endif

                        <button type="button" x-on:click="$dispatch('open-modal', 'add-form')" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            {{ __('ADD FORM') }}
                        </button>

                        <x-modal name="add-form" :show="$errors->has('form_name')" maxWidth="md" focusable>
                            <form method="POST" action="{{ route('forms.store') }}" class="space-y-6 p-6" data-confirm="{{ __('Are you sure you want to save this form?') }}">
                                @csrf
                                <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Add Form') }}</h2>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Add a required form or document.') }}</p>
                                    </div>
                                    <button type="button" x-on:click="$dispatch('close-modal', 'add-form')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600">&times;</button>
                                </div>
                                <div>
                                    <x-input-label for="form_name" :value="__('Form Name')" />
                                    <x-text-input id="form_name" name="form_name" type="text" class="mt-2 block w-full" :value="old('form_name')" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('form_name')" />
                                </div>
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" x-on:click="$dispatch('close-modal', 'add-form')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50">{{ __('Cancel') }}</button>
                                    <x-primary-button>{{ __('Save Form') }}</x-primary-button>
                                </div>
                            </form>
                        </x-modal>

                        <div class="hidden overflow-x-auto border border-gray-200 rounded-lg md:block">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Form Name') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($forms as $form)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $form->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $form->form_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <button type="button" x-on:click="$dispatch('open-modal', 'edit-form-{{ $form->id }}')" class="inline-flex items-center rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                    {{ __('Edit') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-sm text-gray-500 text-center">{{ __('No forms found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @foreach ($forms as $form)
                            <x-modal name="edit-form-{{ $form->id }}" maxWidth="md" focusable>
                                <form method="POST" action="{{ route('forms.update', $form) }}" class="space-y-6 p-6" data-confirm="{{ __('Are you sure you want to update this form?') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="flex items-start justify-between gap-4 border-b border-gray-200 pb-4">
                                        <div>
                                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Edit Form') }}</h2>
                                            <p class="mt-1 text-sm text-gray-500">{{ __('Update the form or document name.') }}</p>
                                        </div>
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-form-{{ $form->id }}')" aria-label="{{ __('Close') }}" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-2xl leading-none text-gray-400 hover:bg-gray-100 hover:text-gray-600">&times;</button>
                                    </div>
                                    <div>
                                        <x-input-label for="edit_form_name_{{ $form->id }}" :value="__('Form Name')" />
                                        <x-text-input id="edit_form_name_{{ $form->id }}" name="form_name" type="text" class="mt-2 block w-full" :value="old('form_name', $form->form_name)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('form_name')" />
                                    </div>
                                    <div class="flex items-center justify-end gap-3">
                                        <button type="button" x-on:click="$dispatch('close-modal', 'edit-form-{{ $form->id }}')" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50">{{ __('Cancel') }}</button>
                                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach

                        <div class="grid gap-3 md:hidden">
                            @forelse ($forms as $form)
                                <article class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                    <div class="min-w-0">
                                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Form') }} #{{ $form->id }}</p>
                                        <h3 class="mt-1 break-words text-sm font-semibold text-gray-900">{{ $form->form_name }}</h3>
                                    </div>
                                    <a href="{{ route('forms.edit', $form) }}" class="inline-flex shrink-0 items-center rounded-md bg-gray-800 px-3 py-1.5 text-xs font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        {{ __('Edit') }}
                                    </a>
                                </article>
                            @empty
                                <p class="rounded-lg border border-gray-200 px-4 py-3 text-sm text-gray-500">{{ __('No forms found.') }}</p>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            {{ $forms->appends(['tab' => 'forms', 'users_page' => request('users_page'), 'clients_page' => request('clients_page'), 'tasks_page' => request('tasks_page')])->links() }}
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
