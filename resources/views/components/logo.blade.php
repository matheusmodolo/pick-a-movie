@php
    $class = $attributes->get('class', '');
    if (!str_contains($class, 'w-')) {
        $class = 'w-6 ' . $class;
    }
    if (!str_contains($class, 'h-')) {
        $class = 'h-6 ' . $class;
    }
@endphp
{{-- <svg class="{{ $class }}" {{ $attributes->except('class') }} fill="none" stroke="currentColor" stroke-width="2"
    viewBox="0 0 24 24">
    <rect x="2" y="2" width="20" height="20" rx="2" />
    <path d="M7 2v20M17 2v20M2 12h20" />
</svg> --}}

<svg class="{{ $class }}" {{ $attributes->except('class') }} viewBox="0 0 24 24" fill="none"
    xmlns="http://www.w3.org/2000/svg" stroke="currentColor">

    <g id="SVGRepo_bgCarrier" stroke-width="0" />

    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />

    <g id="SVGRepo_iconCarrier">
        <rect width="18" height="18" rx="3" transform="matrix(1.39071e-07 1 1 -1.39071e-07 3 3)"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <line x1="7" y1="4" x2="7" y2="20" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <line x1="6" y1="8" x2="3" y2="8" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <line x1="21" y1="8" x2="18" y2="8" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <line x1="6" y1="16" x2="3" y2="16" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <line x1="21" y1="16" x2="18" y2="16" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <line x1="17" y1="4" x2="17" y2="20" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
        <path d="M21 12L3 12" stroke-width="2" stroke-linecap="round" />
    </g>

</svg>
