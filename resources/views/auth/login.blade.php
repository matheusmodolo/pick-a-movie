@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        {{-- Left side - Form --}}
        <div class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-12">
                    <div class="p-2 rounded-lg bg-primary/10">
                        <x-logo class="w-6 h-6 text-primary" />
                    </div>
                    <span class="font-display text-2xl text-primary">Pick a Movie</span>
                </a>

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="font-display text-4xl text-foreground mb-2">BEM-VINDO DE VOLTA</h1>
                    <p class="text-gray-500">Entre na sua conta para continuar</p>
                </div>

                {{-- Session status / errors --}}
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        Há problemas com os dados enviados. Verifique novamente.
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-foreground">Email</label>
                        <div class="relative">
                            {{-- Mail icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" stroke="none"
                                stroke-width="1.5" aria-hidden="true">
                                <path
                                    d="M125.4 128C91.5 128 64 155.5 64 189.4C64 190.3 64 191.1 64.1 192L64 192L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 192L575.9 192C575.9 191.1 576 190.3 576 189.4C576 155.5 548.5 128 514.6 128L125.4 128zM528 256.3L528 448C528 456.8 520.8 464 512 464L128 464C119.2 464 112 456.8 112 448L112 256.3L266.8 373.7C298.2 397.6 341.7 397.6 373.2 373.7L528 256.3zM112 189.4C112 182 118 176 125.4 176L514.6 176C522 176 528 182 528 189.4C528 193.6 526 197.6 522.7 200.1L344.2 335.5C329.9 346.3 310.1 346.3 295.8 335.5L117.3 200.1C114 197.6 112 193.6 112 189.4z" />
                            </svg>

                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autofocus placeholder="seu@email.com"
                                class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />

                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium text-foreground">Senha</label>
                        <div class="relative">
                            {{-- Lock icon --}}
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>

                            <input id="password" name="password" :value="''" type="password"
                                placeholder="••••••••" required
                                class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />

                            {{-- Toggle password button --}}
                            {{-- <button type="button" id="togglePassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-foreground transition-colors"
                                aria-label="Mostrar/ocultar senha">
                                <!-- Eye icon (default) -->
                                <svg id="eyeIcon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button> --}}

                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-border bg-input accent-primary" />
                            <span class="text-sm text-gray-400">Lembrar de mim</span>
                        </label>

                        <a href="{{ route('password.request') ?? '#' }}"
                            class="text-sm text-primary hover:underline">Esqueceu a senha?</a>
                    </div>

                    {{-- Submit --}}
                    {{-- <x-btn-primary class="w-full py-3 text-lg">
                        Entrar
                    </x-btn-primary> --}}
                    <x-btn-primary type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-3 rounded-lg text-xl font-medium bg-gradient-to-r from-primary to-primary-600 text-white shadow-sm hover:opacity-95 transition">
                        Entrar
                    </x-btn-primary>
                </form>

                {{-- Sign up link --}}
                <p class="mt-8 text-center text-gray-400">
                    Não tem uma conta?
                    <a href="{{ route('register') }}" class="text-primary hover:underline">Criar conta</a>
                </p>
            </div>
        </div>

        {{-- Right side - Decoration --}}
        <div class="hidden lg:flex flex-1 items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none bg-gray-700/10 ">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl animate-float "></div>
                <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-accent/10 rounded-full blur-3xl animate-float"
                    style="animation-delay: -3s"></div>
            </div>

            <div class="relative text-center p-12">
                {{-- Film big icon --}}
                <x-logo class="w-28 h-28 text-primary mx-auto mb-8 animate-pulse-glow" />

                <h2 class="font-display text-5xl text-foreground mb-4">PICK A MOVIE</h2>
                <p class="text-gray-400 max-w-md mx-auto">
                    A forma mais fácil de escolher o filme perfeito para assistir com seus amigos
                </p>
            </div>
        </div>
    </div>

    {{-- Small script to toggle password visibility --}}
    @push('scripts')
        <script>
            (function() {
                const toggleBtn = document.getElementById('togglePassword')
                const pwdInput = document.getElementById('password')
                const eyeIcon = document.getElementById('eyeIcon')

                if (!toggleBtn || !pwdInput || !eyeIcon) return

                toggleBtn.addEventListener('click', () => {
                    const isText = pwdInput.type === 'text'
                    pwdInput.type = isText ? 'password' : 'text'

                    // swap icon: eye / eye off
                    eyeIcon.innerHTML = isText ?
                        '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7z"></path><circle cx="12" cy="12" r="3"></circle>' :
                        '<path d="M3 3l18 18"></path><path d="M10.58 10.58A3 3 0 0 0 13.42 13.42"></path><path d="M14.12 9.88A3 3 0 0 0 9.88 14.12"></path><path d="M2 12s4-7 10-7c2.07 0 3.99.5 5.62 1.39"></path>'
                })
            })()
        </script>
    @endpush
@endsection
