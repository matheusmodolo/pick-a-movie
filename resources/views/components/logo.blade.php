@php
    $class = $attributes->get('class', '');
    if (!str_contains($class, 'w-')) {
        $class = 'w-6 ' . $class;
    }
    if (!str_contains($class, 'h-')) {
        $class = 'h-6 ' . $class;
    }
@endphp
<svg class="{{ $class }}" {{ $attributes->except('class') }} fill="none" stroke="currentColor" stroke-width="2"
    viewBox="0 0 24 24">
    <rect x="2" y="2" width="20" height="20" rx="2" />
    <path d="M7 2v20M17 2v20M2 12h20" />
</svg>
