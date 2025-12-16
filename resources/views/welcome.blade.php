@extends('layouts.app')

@section('content')
    <div class="min-h-screen">

        @php
            $features = [
                [
                    'icon' => 'film',
                    'title' => 'Sua Lista de Filmes',
                    'description' =>
                        'Adicione os filmes que você quer assistir usando a OMDb API com milhares de títulos.',
                ],
                [
                    'icon' => 'users',
                    'title' => 'Convide Amigos',
                    'description' => 'Conecte-se com seus amigos e veja as listas de filmes de cada um.',
                ],
                [
                    'icon' => 'shuffle',
                    'title' => 'Merge & Escolha',
                    'description' => 'Combine as listas e deixe o app escolher o filme perfeito para a sessão.',
                ],
            ];
        @endphp

        {{-- Hero Section --}}
        <section class="relative pt-32 pb-20 px-4 overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-accent/5 rounded-full blur-3xl animate-float"
                    style="animation-delay: -3s"></div>
            </div>

            <div class="container mx-auto relative">
                <div class="max-w-4xl mx-auto text-center">
                    {{-- Badge --}}
                    {{-- <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass mb-8 animate-fade-in">
                        
                        <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5">
                            <path d="M7 8c0-1.657 1.343-3 3-3 0-1.105.895-2 2-2s2 .895 2 2c1.657 0 3 1.343 3 3" />
                            <path d="M3 10h18l-1.5 9a2 2 0 0 1-2 1.7H6.5A2 2 0 0 1 4.5 19L3 10z" />
                        </svg>
                        <span class="text-sm font-medium text-muted-foreground">
                            A escolha perfeita para sua sessão de filmes
                        </span>
                    </div> --}}

                    {{-- Title --}}
                    <h1 class="text-6xl sm:text-7xl md:text-8xl tracking-tight mb-6 animate-fade-in animate-delay-100">
                        <p class="text-foreground">PICK A</p>
                        <span class="text-primary">MOVIE</span>
                    </h1>

                    {{-- Subtitle --}}
                    <p
                        class="text-lg sm:text-xl text-muted-foreground max-w-2xl mx-auto mb-10 animate-fade-in animate-delay-200">
                        Acabou a indecisão! Crie sua lista de filmes, convide seus amigos e deixe nosso app encontrar o
                        filme perfeito para todos.
                    </p>

                    {{-- CTA Buttons --}}
                    <div
                        class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in animate-delay-300">
                        <a href="{{ route('register') }}">
                            <x-btn-primary
                                class="inline-flex items-center px-6 py-3 text-xl rounded-lg bg-gradient-to-r from-primary to-primary-600/80 hover:from-primary/90 hover:to-primary-600/90">
                                Começar Agora
                                {{-- ArrowRight --}}
                                <svg class="w-5 h-5 ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M5 12h14M13 6l6 6-6 6" />
                                </svg>
                            </x-btn-primary>
                        </a>
                        <a href="{{ route('login') }}">
                            <x-btn-secondary class="px-6 py-3 text-lg rounded-lg border border-gray-400/20 bg-transparent">
                                Já tenho conta
                            </x-btn-secondary>
                        </a>
                    </div>

                    {{-- Stats --}}
                    {{-- <div class="flex items-center justify-center gap-8 mt-16 animate-fade-in animate-delay-400">
                        <div class="text-center">
                            <p class="font-display text-4xl text-primary">1M+</p>
                            <p class="text-sm text-muted-foreground">Filmes</p>
                        </div>
                        <div class="w-px h-12 bg-border"></div>
                        <div class="text-center">
                            <p class="font-display text-4xl text-primary">10K+</p>
                            <p class="text-sm text-muted-foreground">Usuários</p>
                        </div>
                        <div class="w-px h-12 bg-border"></div>
                        <div class="text-center">
                            <p class="font-display text-4xl text-primary">50K+</p>
                            <p class="text-sm text-muted-foreground">Sessões</p>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="py-20 px-4">
            <div class="container mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-display text-4xl sm:text-5xl text-foreground mb-4">COMO FUNCIONA</h2>
                    <p class="text-muted-foreground max-w-xl mx-auto">
                        Três passos simples para nunca mais perder tempo decidindo qual filme assistir
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    @foreach ($features as $index => $feature)
                        <div class="group p-8 rounded-2xl bg-card border border-border hover:border-primary/50 transition-all duration-300 hover:shadow-lg hover:shadow-primary/5 animate-fade-in"
                            style="animation-delay: {{ $index * 100 }}ms">
                            <div
                                class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center mb-6 group-hover:bg-primary/20 transition-colors">
                                @if ($feature['icon'] === 'film')
                                    {{-- Film icon --}}
                                    <svg class="w-7 h-7 text-primary" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <path d="M7 7v10M17 7v10" />
                                    </svg>
                                @elseif ($feature['icon'] === 'users')
                                    {{-- Users icon --}}
                                    <svg class="w-7 h-7 text-primary" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path
                                            d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM8 11c1.657 0 3-1.343 3-3S9.657 5 8 5 5 6.343 5 8s1.343 3 3 3z" />
                                        <path d="M2 20a6 6 0 0 1 12 0M14 14s1.5-1 4-1 4 1 4 1" />
                                    </svg>
                                @elseif ($feature['icon'] === 'shuffle')
                                    {{-- Shuffle icon --}}
                                    <svg class="w-7 h-7 text-primary" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path d="M16 3h5v5M21 3l-7.5 7.5M2 21h5l7.5-7.5M2 3l7.5 7.5" />
                                    </svg>
                                @endif
                            </div>

                            <h3 class="font-display text-2xl text-foreground mb-3">{{ $feature['title'] }}</h3>
                            <p class="text-muted-foreground leading-relaxed">{{ $feature['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <section class="py-20 px-4">
            <div class="container mx-auto">
                <div class="max-w-4xl mx-auto text-center p-12 rounded-3xl glass relative overflow-hidden">
                    {{-- Decoration --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-red-500/10 rounded-full blur-3xl"></div>

                    <div class="relative">
                        {{-- Star icon --}}
                        <svg class="w-12 h-12 text-primary mx-auto mb-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2l2.6 6.9L21 10l-5 3.6L17.2 21 12 17.8 6.8 21 8 13.6 3 10l6.4-1.1L12 2z" />
                        </svg>

                        <h2 class="font-display text-4xl sm:text-5xl text-foreground mb-4">PRONTO PARA COMEÇAR?</h2>
                        <p class="text-muted-foreground max-w-lg mx-auto mb-8">
                            Junte-se a milhares de pessoas que já encontraram a forma perfeita de escolher filmes com
                            amigos.
                        </p>
                        <a href="{{ route('register') }}">
                            <x-btn-primary
                                class="inline-flex items-center px-6 py-3 text-xl rounded-lg shadow-sm bg-gradient-to-r from-primary to-primary-600/80 hover:from-primary/90 hover:to-primary-600/90">
                                Criar Minha Conta
                                <svg class="w-5 h-5 ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path d="M5 12h14M13 6l6 6-6 6" />
                                </svg>
                            </x-btn-primary>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
