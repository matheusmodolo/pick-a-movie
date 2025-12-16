@php
    $navLinks = [
        [
            'route' => 'dashboard',
            'label' => 'Minha Lista',
            'icon' => 'list',
        ],
        [
            'route' => 'merge',
            'label' => 'Merge',
            'icon' => 'users',
        ],
    ];
@endphp

<nav
    class="fixed top-0 left-0 right-0 z-50 w-full transition ease-in-out duration-200 blur-none backdrop-filter backdrop-blur border-b border-gray-400/20">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group no-underline">
                <div
                    class="p-2 rounded-lg bg-primary/10 group-hover:bg-primary/20 transition ease-in-out duration-200 text-primary">
                    {{-- Ícone Film --}}
                    <x-logo />
                </div>
                <span
                    class="hidden sm:inline-block font-display text-2xl tracking-wide text-primary hover:text-amber-600/20 ">
                    Pick a Movie
                </span>
            </a>

            {{-- Navigation Links --}}
            @auth
                <div class="hidden md:flex items-center gap-1">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all
                            {{ request()->routeIs($link['route'])
                                ? 'bg-primary/10 text-primary'
                                : 'text-muted-foreground hover:text-foreground hover:bg-secondary' }}">
                            {{-- Ícones --}}
                            @if ($link['icon'] === 'list')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                                </svg>
                            @elseif ($link['icon'] === 'users')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            @endif

                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </div>
            @endauth

            {{-- Auth Buttons --}}
            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-secondary">
                        <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>

                        <span class="text-sm font-medium">
                            {{ Auth::user()->name }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-3 py-2 text-sm text-muted-foreground
                                   hover:text-foreground transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>

                            <span class="hidden sm:inline">Sair</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">
                        <x-btn-secondary class="text-xs md:text-sm">
                            Entrar
                        </x-btn-secondary>
                    </a>

                    <a href="{{ route('register') }}">
                        <x-btn-primary class="text-xs md:text-sm">Registrar</x-btn-primary>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
