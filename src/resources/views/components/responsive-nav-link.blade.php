@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg border border-yellow-400/40 bg-yellow-400/10 ps-3 pe-4 py-2 text-start text-base font-medium text-yellow-700 shadow-sm shadow-yellow-500/10 focus:outline-none focus:ring-2 focus:ring-yellow-400/60 transition duration-150 ease-in-out dark:text-yellow-300'
            : 'block w-full rounded-lg border border-transparent ps-3 pe-4 py-2 text-start text-base font-medium text-slate-700 transition duration-150 ease-in-out hover:border-slate-300 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:border-slate-400 focus:text-slate-900 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/60 dark:hover:text-slate-100 dark:focus:border-slate-500 dark:focus:text-slate-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
