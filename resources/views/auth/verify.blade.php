@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-20">
        <div class="w-full max-w-lg">
            <div class="p-8 rounded-3xl glass relative overflow-hidden">
                {{-- Decoration --}}
                <div class="absolute top-0 right-0 w-48 h-48 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Header --}}
                <div class="flex items-center gap-3 mb-6">
                    {{-- Mail / verify icon --}}
                    <svg class="w-10 h-10 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 20 6"></polyline>
                        <path d="M21 8v.01"></path>
                        <path d="M3 8v.01"></path>
                    </svg>

                    <div>
                        <h1 class="font-display text-2xl text-foreground">Verifique seu e-mail</h1>
                        <p class="text-sm text-muted-foreground">Antes de continuar, confirme o link que enviamos para seu
                            e-mail.</p>
                    </div>
                </div>

                {{-- Success alert when link resent --}}
                @if (session('resent'))
                    <div class="mb-4 flex items-start gap-3 p-4 rounded-lg bg-green-50 border border-green-100">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                        <div class="text-sm text-green-700">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    </div>
                @endif

                {{-- Body --}}
                <div class="text-sm text-muted-foreground mb-6">
                    <p class="mb-3">{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                    <p>
                        {{ __('If you did not receive the email') }},
                        {{-- <form class="inline" method="POST" action="{{ route('verification.resend') }}"> --}}
                    <form class="inline" method="POST" action="">
                        @csrf
                        <button type="submit" class="inline text-primary font-medium hover:underline">
                            {{ __('click here to request another') }}
                        </button>
                    </form>
                    .
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-4 mt-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-md border border-border hover:bg-secondary transition">
                        {{-- Home icon --}}
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                            aria-hidden="true">
                            <path d="M3 11l9-7 9 7"></path>
                            <path d="M9 22V12h6v10"></path>
                        </svg>
                        Voltar para início
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-gradient-to-r from-primary to-primary-600 text-white shadow-sm hover:opacity-95 transition">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
