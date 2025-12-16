<button
    {{ $attributes->merge(['class' => 'px-4 py-2 text-sm rounded-lg text-light font-medium hover:text-white hover:bg-gray-400/20 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
