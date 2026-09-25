@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg border border-yellow-400/40 bg-yellow-400/10 ps-3 pe-4 py-2 text-start text-base font-medium text-yellow-300 shadow-sm shadow-yellow-500/10 focus:outline-none focus:ring-2 focus:ring-yellow-400/60 transition duration-150 ease-in-out'
            : 'block w-full rounded-lg border border-transparent ps-3 pe-4 py-2 text-start text-base font-medium text-slate-300 transition duration-150 ease-in-out hover:border-slate-600 hover:bg-slate-800/60 hover:text-slate-100 focus:outline-none focus:border-slate-500 focus:text-slate-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
