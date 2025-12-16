 <button
     {{ $attributes->merge(['class' => 'px-4 py-2 text-sm rounded-lg bg-primary-600 text-dark font-medium hover:bg-primary-600/90 hover:scale-105 shadow hover:shadow-lg hover:shadow-primary-600/50 shadow-primary-600/50 transition ease-in-out duration-200']) }}>
     {{ $slot }}
 </button>
