@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-20">
        <div class="w-full max-w-lg">
            <div class="p-8 rounded-3xl glass relative overflow-hidden">
                {{-- Decoration --}}
                <div class="absolute top-0 right-0 w-40 h-40 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Header --}}
                <div class="flex items-center gap-3 mb-6">
                    {{-- Mail icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor"
                        class="w-10 h-10 text-primary" stroke="none" stroke-width="1.5" aria-hidden="true">
                        <path
                            d="M125.4 128C91.5 128 64 155.5 64 189.4C64 190.3 64 191.1 64.1 192L64 192L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 192L575.9 192C575.9 191.1 576 190.3 576 189.4C576 155.5 548.5 128 514.6 128L125.4 128zM528 256.3L528 448C528 456.8 520.8 464 512 464L128 464C119.2 464 112 456.8 112 448L112 256.3L266.8 373.7C298.2 397.6 341.7 397.6 373.2 373.7L528 256.3zM112 189.4C112 182 118 176 125.4 176L514.6 176C522 176 528 182 528 189.4C528 193.6 526 197.6 522.7 200.1L344.2 335.5C329.9 346.3 310.1 346.3 295.8 335.5L117.3 200.1C114 197.6 112 193.6 112 189.4z" />
                    </svg>

                    <div>
                        <h1 class="font-display text-2xl text-foreground">Redefinir senha</h1>
                        <p class="text-sm text-gray-500">Informe seu e-mail e enviaremos o link para redefinir sua
                            senha.</p>
                    </div>
                </div>

                {{-- Success status --}}
                @if (session('status'))
                    <div class="mb-4 flex items-start gap-3 p-4 rounded-lg bg-green-50 border border-green-100">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                        <div class="text-sm text-green-700">{{ session('status') }}</div>
                    </div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        Há problemas com os dados enviados. Verifique novamente.
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5" novalidate>
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

                    {{-- Submit --}}
                    <div>
                        <x-btn-primary type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-3 rounded-lg text-xl font-medium bg-gradient-to-r from-primary to-primary-600 text-white shadow-sm hover:opacity-95 transition">
                            Enviar link para redefinir senha
                        </x-btn-primary>
                    </div>
                </form>

                {{-- Actions --}}
                <div class="flex items-center justify-between items-center gap-4 mt-6">
                    <x-btn-secondary>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 hover:bg-secondary transition">
                            {{-- Login icon --}}
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                aria-hidden="true">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <path d="M10 17l5-5-5-5"></path>
                                <path d="M15 12H3"></path>
                            </svg>
                            Voltar para login
                        </a>
                    </x-btn-secondary>

                    <div class="flex items-center justify-between gap-4">
                        <a href="{{ route('home') }}" class="text-sm text-primary hover:underline">
                            Voltar para início
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
