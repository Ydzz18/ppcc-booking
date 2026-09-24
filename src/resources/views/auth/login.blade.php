<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('Welcome back') }}</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ __('Sign in to PPCC Booking') }}</h1>
        <p class="mt-3 text-sm leading-6 text-slate-500">{{ __('Use your account to continue.') }}</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" class="text-slate-700" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-slate-900" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" class="text-slate-700" :value="__('Password')" />

            <x-text-input id="password" class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 shadow-sm transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-slate-900"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4 pt-1">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-900" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <x-primary-button class="flex w-full justify-center rounded-lg bg-slate-900 px-4 py-3 text-sm font-semibold uppercase tracking-widest text-white shadow-sm transition hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-800">
                {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>
