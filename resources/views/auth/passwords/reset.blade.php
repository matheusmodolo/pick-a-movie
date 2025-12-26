@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-20">
        <div class="w-full max-w-lg">
            <div class="p-8 rounded-3xl glass relative overflow-hidden">
                {{-- Decoration --}}
                <div class="absolute top-0 right-0 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Header --}}
                <div class="flex items-center gap-3 mb-6">
                    {{-- Lock / reset icon --}}
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" aria-hidden="true">
                        <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>

                    <div>
                        <h1 class="font-display text-2xl text-foreground">Redefinir senha</h1>
                        <p class="text-sm text-muted-foreground">Escolha uma nova senha para sua conta</p>
                    </div>
                </div>

                {{-- Status / Errors --}}
                @if (session('status'))
                    <div class="mb-4 flex items-start gap-3 p-4 rounded-lg bg-green-50 border border-green-100">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                        <div class="text-sm text-green-700">{{ session('status') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        Há problemas com os dados enviados. Verifique novamente.
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5" novalidate>
                    @csrf

                    {{-- Token (hidden) --}}
                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-foreground">Email</label>
                        <div class="relative">
                            {{-- Mail icon --}}
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                aria-hidden="true">
                                <path d="M3 8.5v7a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M21 8.5L12 13 3 8.5"></path>
                            </svg>

                            <input id="email" name="email" type="email" value="{{ $email ?? old('email') }}"
                                required autofocus placeholder="seu@email.com"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-border bg-input text-sm focus:outline-none focus:ring-2 focus:ring-primary" />

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
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                aria-hidden="true">
                                <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>

                            <input id="password" name="password" type="password" required placeholder="••••••••"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-border bg-input text-sm focus:outline-none focus:ring-2 focus:ring-primary" />

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
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                aria-hidden="true">
                                <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>

                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                placeholder="••••••••"
                                class="w-full pl-12 pr-4 py-3 rounded-lg border border-border bg-input text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-4">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-3 rounded-lg text-lg font-medium bg-gradient-to-r from-primary to-primary-600 text-white shadow-sm hover:opacity-95 transition">
                            Redefinir senha
                        </button>
                    </div>
                </form>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-4 mt-6">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-border hover:bg-secondary transition">
                        {{-- Login icon --}}
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            aria-hidden="true">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <path d="M10 17l5-5-5-5"></path>
                            <path d="M15 12H3"></path>
                        </svg>
                        Voltar para login
                    </a>

                    <a href="{{ route('home') }}" class="text-sm text-muted-foreground hover:underline">Voltar para
                        início</a>
                </div>
            </div>
        </div>
    </div>
@endsection
