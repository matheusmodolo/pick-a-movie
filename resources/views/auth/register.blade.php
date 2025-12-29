@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        {{-- Left side - Decoration --}}
        <div class="hidden lg:flex flex-1 items-center justify-center bg-card relative overflow-hidden">
            <div class="absolute inset-0 pointer-events-none bg-gray-700/10">
                <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-1/4 left-1/4 w-80 h-80 bg-accent/10 rounded-full blur-3xl animate-float"
                    style="animation-delay: -3s"></div>
            </div>

            <div class="relative text-center p-12">
                <x-logo class="w-28 h-28 text-primary mx-auto mb-8 animate-pulse-glow" />

                {{-- Text --}}
                <h2 class="font-display text-5xl text-foreground mb-4">JUNTE-SE A NÓS</h2>
                <p class="text-gray-400 max-w-md">
                    Crie sua conta e comece a montar sua lista de filmes favoritos
                </p>
            </div>
        </div>

        {{-- Right side - Form --}}
        <div class="flex-1 flex items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-12">
                    <div class="p-2 rounded-lg bg-primary/10">
                        <x-logo class="size-6 text-primary" />
                    </div>
                    <span class="font-display text-2xl text-primary">Pick a Movie</span>
                </a>

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="font-display text-4xl text-foreground mb-2">CRIAR CONTA</h1>
                    <p class="text-gray-400">Preencha os dados para começar</p>
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
                {{-- <form method="POST" action="{{ route('register') }}" class="space-y-5" novalidate> --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-medium text-foreground">Nome</label>
                        <div class="relative">
                            {{-- User icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor"
                                stroke="none" stroke-width="1.5" aria-hidden="true" viewBox="0 0 640 640">
                                <path
                                    d="M240 192C240 147.8 275.8 112 320 112C364.2 112 400 147.8 400 192C400 236.2 364.2 272 320 272C275.8 272 240 236.2 240 192zM448 192C448 121.3 390.7 64 320 64C249.3 64 192 121.3 192 192C192 262.7 249.3 320 320 320C390.7 320 448 262.7 448 192zM144 544C144 473.3 201.3 416 272 416L368 416C438.7 416 496 473.3 496 544L496 552C496 565.3 506.7 576 520 576C533.3 576 544 565.3 544 552L544 544C544 446.8 465.2 368 368 368L272 368C174.8 368 96 446.8 96 544L96 552C96 565.3 106.7 576 120 576C133.3 576 144 565.3 144 552L144 544z" />
                            </svg>

                            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                autofocus placeholder="Seu nome"
                                class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />

                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

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
                                placeholder="seu@email.com"
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

                            <input id="password" name="password" type="password" value="{{ old('password') }}" required
                                placeholder="••••••••"
                                class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-medium text-foreground">Confirmar
                            Senha</label>
                        <div class="relative">
                            {{-- Lock icon --}}
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>

                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                placeholder="••••••••"
                                class="w-full pl-12 pr-4 py-3 rounded-lg bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                        </div>
                    </div>

                    {{-- Terms and Privacy --}}
                    <div class="flex items-start gap-2">
                        <input type="checkbox" name="terms" required
                            class="w-4 h-4 mt-0.5 rounded border-border bg-input accent-primary" />
                        <span class="text-sm text-gray-400">
                            Eu concordo com os
                            {{-- <a href="{{ route('terms') }}" class="text-primary hover:underline">Termos de Uso</a> --}}
                            Termos de Uso e
                            {{-- < href="{{ route('privacy') }}" class="text-primary hover:underline"> --}}
                            Política de Privacidade
                        </span>
                    </div>

                    {{-- Submit Button --}}
                    <x-btn-primary type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-3 rounded-lg text-xl font-medium bg-gradient-to-r from-primary to-primary-600 text-white shadow-sm hover:opacity-95 transition">
                        Criar Conta
                    </x-btn-primary>
                </form>

                {{-- Sign in link --}}
                <p class="mt-8 text-center text-gray-400">
                    Já tem uma conta? <a href="{{ route('login') }}" class="text-primary hover:underline">Entrar</a>
                </p>
            </div>
        </div>
    </div>
@endsection
