<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Ellas') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    <body class="font-sans antialiased bg-ellas-dark text-white selection:bg-ellas-pink selection:text-white overflow-x-hidden">

        @if(session('success_box'))
            <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-ellas-dark/90 backdrop-blur-sm">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 max-w-md w-full shadow-2xl relative overflow-hidden text-center">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-ellas-pink/20 rounded-full blur-2xl"></div>
                    
                    <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center text-green-500 mx-auto mb-6">
                        <i class="fas fa-check-circle text-4xl"></i>
                    </div>
                    
                    <h3 class="font-orbitron text-2xl font-bold text-white mb-4">Cadastro Enviado!</h3>
                    <p class="font-biorhyme text-gray-400 mb-8">{{ session('success_box') }}</p>
                    
                    <button @click="show = false" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-[1.02] transition-all">
                        ENTENDI
                    </button>
                </div>
            </div>
        @endif

        <nav x-data="{ open: false }" class="fixed w-full z-50 bg-ellas-card/80 backdrop-blur-md border-b border-ellas-nav transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="/" class="font-orbitron font-bold text-3xl tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan hover:scale-105 transition-transform">
                           Conectada com ELLAS
                        </a>
                    </div>

                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#inicio" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">Início</a>
                        <a href="#sobre" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">Sobre</a>
                        <a href="#servicos" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">O que oferecemos</a>
                        <a href="#depoimentos" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">Depoimentos</a>

                    @if (Route::has('login'))
                        @if(Auth::guard('admin')->check())
                            <a href="{{ route('admin.dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-purple hover:bg-purple-700 text-white transition-all shadow-[0_0_15px_rgba(165,4,170,0.5)]">
                                Painel Administrativo
                            </a>
                        @elseif(Auth::guard('mentora')->check())
                            <a href="{{ route('mentora.dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-purple hover:bg-purple-700 text-white transition-all shadow-[0_0_15px_rgba(165,4,170,0.5)]">
                                Painel Mentora
                            </a>
                        @elseif(Auth::guard('web')->check())
                            <a href="{{ route('dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-purple hover:bg-purple-700 text-white transition-all shadow-[0_0_15px_rgba(165,4,170,0.5)]">
                                Área do Aluno
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="font-orbitron text-sm hover:text-ellas-pink transition-colors mr-4">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-orbitron px-6 py-2 rounded-full bg-gradient-to-r from-ellas-purple to-ellas-cyan text-white font-bold transition-all hover:scale-105 shadow-[0_0_15px_rgba(4,203,239,0.4)]">
                                    Cadastre-se
                                </a>
                            @endif
                        @endif
                    @endif
                </div>

                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-ellas-nav focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-ellas-card border-t border-ellas-nav">
                <div class="pt-2 pb-3 space-y-1 p-4 flex flex-col gap-2">
                    <a href="#inicio" class="block font-orbitron text-white hover:text-ellas-cyan">Início</a>
                    <a href="#sobre" class="block font-orbitron text-white hover:text-ellas-cyan">Sobre</a>
                    <a href="{{ route('login') }}" class="block font-orbitron text-white hover:text-ellas-pink">Login</a>
                    <a href="{{ route('register') }}" class="block font-orbitron text-ellas-cyan">Cadastre-se</a>
                </div>
            </div>
        </nav>

        <section id="inicio" class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('img/inicio.jpg') }}" alt="Fundo" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-b from-ellas-dark/80 via-ellas-dark/60 to-ellas-dark"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 text-center lg:text-left grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8 animate__animated animate__fadeInLeft">
                    <img src="{{ asset('img/2.png') }}" alt="Logo Ellas" class="h-24 md:h-32 mx-auto lg:mx-0 drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">
                    
                    <h1 class="font-orbitron text-4xl md:text-6xl font-bold leading-tight">
                        Empoderando mulheres na <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-pink to-ellas-cyan">tecnologia</span>
                    </h1>
                    
                    <p class="font-biorhyme text-lg md:text-xl text-gray-300 leading-relaxed">
                        Descubra um universo onde a força feminina se une à inovação. Junte-se a nós e transforme o futuro através da inclusão e conexão.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="font-orbitron px-8 py-4 rounded-xl bg-gradient-to-r from-ellas-purple to-ellas-pink text-white font-bold text-lg shadow-[0_0_20px_rgba(165,4,170,0.4)] hover:scale-105 transition-transform hover:shadow-[0_0_30px_rgba(227,20,117,0.6)]">
                            Começar Agora
                        </a>
                        <a href="#sobre" class="font-orbitron px-8 py-4 rounded-xl border border-ellas-cyan text-ellas-cyan font-bold text-lg hover:bg-ellas-cyan hover:text-ellas-dark transition-colors">
                            Saiba Mais
                        </a>
                    </div>
                </div>
                
                <div class="hidden lg:block relative animate__animated animate__fadeInRight">
                    <div class="absolute inset-0 bg-gradient-to-r from-ellas-purple to-ellas-cyan blur-[100px] opacity-20 rounded-full"></div>
                    </div>
            </div>
        </section>

        <section class="py-12 bg-ellas-card border-y border-ellas-nav relative z-20">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-ellas-nav">
                <div class="p-4">
                    <h2 class="font-orbitron text-5xl font-bold text-white mb-2">1000+</h2>
                    <p class="font-biorhyme text-ellas-pink font-semibold">Mulheres Conectadas</p>
                </div>
                <div class="p-4">
                    <h2 class="font-orbitron text-5xl font-bold text-white mb-2">50+</h2>
                    <p class="font-biorhyme text-ellas-cyan font-semibold">Conteúdos Exclusivos</p>
                </div>
                <div class="p-4">
                    <h2 class="font-orbitron text-5xl font-bold text-white mb-2">200+</h2>
                    <p class="font-biorhyme text-ellas-purple font-semibold">Eventos Realizados</p>
                </div>
            </div>
        </section>

        <section class="py-20 relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan p-[2px] rounded-[30px] shadow-[0_0_40px_rgba(165,4,170,0.3)] animate-gradient-xy">
                    <div class="bg-ellas-dark rounded-[28px] p-8 md:p-12 flex flex-col md:flex-row gap-8 items-center">
                        <i class="bi bi-quote text-6xl text-ellas-cyan shrink-0"></i>
                        <p class="font-biorhyme text-xl md:text-2xl text-center md:text-left text-white leading-relaxed">
                            Nosso objetivo é inspirar e apoiar mulheres a ingressarem e permanecerem na área tecnológica, reduzindo barreiras e aumentando a representatividade através de mentorias e comunidade.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-ellas-dark">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="group bg-ellas-card p-8 rounded-3xl border border-ellas-nav hover:border-ellas-purple transition-all hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(165,4,170,0.2)] relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-ellas-purple"></div>
                        <h3 class="font-orbitron text-2xl text-white mb-4 flex items-center gap-3">
                            <i class="fas fa-rocket text-ellas-purple"></i> Missão
                        </h3>
                        <p class="font-biorhyme text-gray-400">Promover a inclusão e visibilidade feminina no campo da tecnologia, criando oportunidades reais de crescimento.</p>
                    </div>

                    <div class="group bg-ellas-card p-8 rounded-3xl border border-ellas-nav hover:border-ellas-pink transition-all hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(227,20,117,0.2)] relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-ellas-pink"></div>
                        <h3 class="font-orbitron text-2xl text-white mb-4 flex items-center gap-3">
                            <i class="fas fa-eye text-ellas-pink"></i> Visão
                        </h3>
                        <p class="font-biorhyme text-gray-400">Transformar a área tecnológica em um ambiente igualitário, com mulheres em posições de destaque e liderança.</p>
                    </div>

                    <div class="group bg-ellas-card p-8 rounded-3xl border border-ellas-nav hover:border-ellas-cyan transition-all hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(4,203,239,0.2)] relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-ellas-cyan"></div>
                        <h3 class="font-orbitron text-2xl text-white mb-4 flex items-center gap-3">
                            <i class="fas fa-heart text-ellas-cyan"></i> Valores
                        </h3>
                        <p class="font-biorhyme text-gray-400">Diversidade, inclusão, empoderamento, educação contínua e cooperação mútua.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SEÇÃO SOBRE COM ABAS PARA ADMIN -->
        <section id="sobre" class="py-20 bg-ellas-card/50 relative z-10">
            <div class="max-w-7xl mx-auto px-6">
                @php
                    $isAdmin = Auth::guard('admin')->check();
                @endphp

                <!-- Abas de navegação (apenas para Admin) -->
                @if($isAdmin)
                    <div x-data="{ activeTab: 'visualizar' }" class="mb-8 flex gap-4 border-b border-ellas-nav pb-4">
                        <button @click="activeTab = 'visualizar'" :class="activeTab === 'visualizar' ? 'border-b-2 border-ellas-pink text-ellas-pink' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Visualizar
                        </button>
                        <button @click="activeTab = 'editar'" :class="activeTab === 'editar' ? 'border-b-2 border-ellas-cyan text-ellas-cyan' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                            <i class="fas fa-edit mr-2"></i>Editar Slides
                        </button>
                        <button @click="activeTab = 'historias'" :class="activeTab === 'historias' ? 'border-b-2 border-ellas-purple text-ellas-purple' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                            <i class="fas fa-book mr-2"></i>Histórias
                        </button>
                        <button @click="activeTab = 'depoimentos'" :class="activeTab === 'depoimentos' ? 'border-b-2 border-ellas-pink text-ellas-pink' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                            <i class="fas fa-star mr-2"></i>Depoimentos
                        </button>
                    </div>

                    <!-- Aba Visualizar -->
                    <div x-show="activeTab === 'visualizar'" class="space-y-8">
                        @include('components.site.about-content')
                    </div>

                    <!-- Aba Editar Slides -->
                    <div x-show="activeTab === 'editar'" class="space-y-8">
                        @livewire('editar-sobre')
                    </div>

                    <!-- Aba Histórias -->
                    <div x-show="activeTab === 'historias'" class="space-y-8">
                        @livewire('criar-historia')
                    </div>

                    <!-- Aba Depoimentos -->
                    <div x-show="activeTab === 'depoimentos'" class="space-y-8">
                        @livewire('gerenciar-depoimentos')
                    </div>
                @else
                    <!-- Visualização padrão para usuários não-admin -->
                    @include('components.site.about-content')
                @endif
            </div>
        </section>

        <section id="servicos" class="py-24 bg-ellas-dark">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h5 class="font-orbitron text-ellas-cyan tracking-widest uppercase text-sm mb-2">Ecossistema</h5>
                    <h2 class="font-orbitron text-4xl md:text-5xl font-bold text-white">O que nós oferecemos</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-ellas-card p-8 rounded-2xl border border-ellas-nav hover:border-ellas-purple transition-all duration-300 hover:-translate-y-2 group">
                        <i class="fas fa-code text-4xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink mb-6 group-hover:scale-110 transition-transform block"></i>
                        <h3 class="font-orbitron text-xl text-white mb-3">Oficinas Práticas</h3>
                        <p class="font-biorhyme text-sm text-gray-400">Desenvolva habilidades técnicas e comportamentais essenciais.</p>
                    </div>
                    <div class="bg-ellas-card p-8 rounded-2xl border border-ellas-nav hover:border-ellas-pink transition-all duration-300 hover:-translate-y-2 group">
                        <i class="fas fa-calendar-alt text-4xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-pink to-orange-500 mb-6 group-hover:scale-110 transition-transform block"></i>
                        <h3 class="font-orbitron text-xl text-white mb-3">Eventos</h3>
                        <p class="font-biorhyme text-sm text-gray-400">Palestras e workshops com referências do mercado.</p>
                    </div>
                    <div class="bg-ellas-card p-8 rounded-2xl border border-ellas-nav hover:border-ellas-cyan transition-all duration-300 hover:-translate-y-2 group">
                        <i class="fas fa-lightbulb text-4xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-cyan to-blue-500 mb-6 group-hover:scale-110 transition-transform block"></i>
                        <h3 class="font-orbitron text-xl text-white mb-3">Projetos</h3>
                        <p class="font-biorhyme text-sm text-gray-400">Colabore em iniciativas de impacto e fortaleça seu portfólio.</p>
                    </div>
                    <div class="bg-ellas-card p-8 rounded-2xl border border-ellas-nav hover:border-ellas-purple transition-all duration-300 hover:-translate-y-2 group">
                        <i class="fas fa-heart text-4xl text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-ellas-purple mb-6 group-hover:scale-110 transition-transform block"></i>
                        <h3 class="font-orbitron text-xl text-white mb-3">Rede de Apoio</h3>
                        <p class="font-biorhyme text-sm text-gray-400">Uma comunidade acolhedora para crescer juntas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SEÇÃO DEPOIMENTOS COM GERENCIAMENTO PARA ADMIN -->
        <section id="depoimentos" class="py-20 bg-ellas-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-ellas-purple/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                @php
                    $isAdmin = Auth::guard('admin')->check();
                    $depoimentosAprovados = \App\Models\Testimonial::where('is_active', true)->latest()->get();
                @endphp

                <h5 class="font-orbitron text-center text-white/50 tracking-widest uppercase text-sm mb-2">Comunidade</h5>
                <h2 class="font-orbitron text-center text-4xl font-bold text-white mb-12">Histórias que Inspiram</h2>

                @if($isAdmin)
                    <!-- Abas para Admin -->
                    <div x-data="{ depTab: 'visualizar' }" class="mb-8">
                        <div class="flex gap-4 border-b border-ellas-nav pb-4 mb-8">
                            <button @click="depTab = 'visualizar'" :class="depTab === 'visualizar' ? 'border-b-2 border-ellas-pink text-ellas-pink' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                                <i class="fas fa-eye mr-2"></i>Visualizar
                            </button>
                            <button @click="depTab = 'gerenciar'" :class="depTab === 'gerenciar' ? 'border-b-2 border-ellas-cyan text-ellas-cyan' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                                <i class="fas fa-cogs mr-2"></i>Gerenciar
                            </button>
                            <button @click="depTab = 'enviar'" :class="depTab === 'enviar' ? 'border-b-2 border-ellas-purple text-ellas-purple' : 'text-gray-400 hover:text-white'" class="font-orbitron px-6 py-2 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Enviar Depoimento
                            </button>
                        </div>

                        <!-- Visualizar -->
                        <div x-show="depTab === 'visualizar'">
                            <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide">
                                @forelse($depoimentosAprovados as $depoimento)
                                    <div class="min-w-[300px] md:min-w-[400px] bg-ellas-dark p-8 rounded-2xl border border-ellas-nav snap-center">
                                        <i class="fas fa-quote-left text-3xl text-ellas-purple mb-4"></i>
                                        <p class="font-biorhyme text-gray-300 italic mb-6">"{{ $depoimento->content }}"</p>
                                        <div class="flex items-center gap-4 border-t border-ellas-nav pt-4">
                                            @if($depoimento->photo_url)
                                                <img src="{{ $depoimento->photo_url }}" class="w-12 h-12 rounded-full border-2 border-ellas-purple object-cover" alt="{{ $depoimento->name }}">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-ellas-purple to-ellas-pink flex items-center justify-center text-white font-bold">
                                                    {{ substr($depoimento->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-orbitron text-white font-bold">{{ $depoimento->name }}</p>
                                                <p class="text-xs text-ellas-purple">{{ $depoimento->role }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="w-full text-center py-12 text-gray-500">
                                        <p class="font-biorhyme">Nenhum depoimento aprovado ainda.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Gerenciar -->
                        <div x-show="depTab === 'gerenciar'">
                            @livewire('gerenciar-depoimentos')
                        </div>

                        <!-- Enviar Depoimento -->
                        <div x-show="depTab === 'enviar'">
                            @livewire('submeter-depoimento')
                        </div>
                    </div>
                @else
                    <!-- Visualização para usuários normais -->
                    <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide">
                        @forelse($depoimentosAprovados as $depoimento)
                            <div class="min-w-[300px] md:min-w-[400px] bg-ellas-dark p-8 rounded-2xl border border-ellas-nav snap-center">
                                <i class="fas fa-quote-left text-3xl text-ellas-purple mb-4"></i>
                                <p class="font-biorhyme text-gray-300 italic mb-6">"{{ $depoimento->content }}"</p>
                                <div class="flex items-center gap-4 border-t border-ellas-nav pt-4">
                                    @if($depoimento->photo_url)
                                        <img src="{{ $depoimento->photo_url }}" class="w-12 h-12 rounded-full border-2 border-ellas-purple object-cover" alt="{{ $depoimento->name }}">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-ellas-purple to-ellas-pink flex items-center justify-center text-white font-bold">
                                            {{ substr($depoimento->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-orbitron text-white font-bold">{{ $depoimento->name }}</p>
                                        <p class="text-xs text-ellas-purple">{{ $depoimento->role }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="w-full text-center py-12 text-gray-500">
                                <p class="font-biorhyme">Nenhum depoimento disponível.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Botão para enviar depoimento (usuários normais) -->
                    @auth
                        <div class="mt-12 text-center">
                            <p class="font-biorhyme text-gray-400 mb-6">Quer compartilhar sua história conosco?</p>
                            @livewire('submeter-depoimento')
                        </div>
                    @endauth
                @endif
            </div>
        </section>

        <section class="py-20 bg-ellas-dark">
            <div class="max-w-3xl mx-auto px-6" x-data="{ active: null }">
                <h2 class="font-orbitron text-4xl font-bold text-white text-center mb-12">Perguntas Frequentes</h2>

                <div class="space-y-4">
                    <div class="border border-ellas-nav rounded-2xl overflow-hidden bg-ellas-card">
                        <button @click="active = (active === 1 ? null : 1)" class="w-full p-6 text-left flex justify-between items-center focus:outline-none hover:bg-white/5 transition-colors">
                            <span class="font-orbitron text-white text-lg">O que é o projeto 'Conectada com Ellas'?</span>
                            <i class="bi bi-chevron-down text-ellas-cyan transition-transform duration-300" :class="{'rotate-180': active === 1}"></i>
                        </button>
                        <div x-show="active === 1" x-collapse class="px-6 pb-6 text-gray-400 font-biorhyme border-t border-ellas-nav pt-4">
                            O projeto é uma iniciativa que visa capacitar mulheres em tecnologia, oferecendo oficinas, eventos e redes de apoio.
                        </div>
                    </div>

                    <div class="border border-ellas-nav rounded-2xl overflow-hidden bg-ellas-card">
                        <button @click="active = (active === 2 ? null : 2)" class="w-full p-6 text-left flex justify-between items-center focus:outline-none hover:bg-white/5 transition-colors">
                            <span class="font-orbitron text-white text-lg">Como posso me envolver?</span>
                            <i class="bi bi-chevron-down text-ellas-cyan transition-transform duration-300" :class="{'rotate-180': active === 2}"></i>
                        </button>
                        <div x-show="active === 2" x-collapse class="px-6 pb-6 text-gray-400 font-biorhyme border-t border-ellas-nav pt-4">
                            Você pode participar das oficinas, eventos ou se voluntariar como mentora. Basta acompanhar as atualizações em nosso site.
                        </div>
                    </div>

                    <div class="border border-ellas-nav rounded-2xl overflow-hidden bg-ellas-card">
                        <button @click="active = (active === 3 ? null : 3)" class="w-full p-6 text-left flex justify-between items-center focus:outline-none hover:bg-white/5 transition-colors">
                            <span class="font-orbitron text-white text-lg">As atividades são pagas?</span>
                            <i class="bi bi-chevron-down text-ellas-cyan transition-transform duration-300" :class="{'rotate-180': active === 3}"></i>
                        </button>
                        <div x-show="active === 3" x-collapse class="px-6 pb-6 text-gray-400 font-biorhyme border-t border-ellas-nav pt-4">
                            A grande maioria de nossos eventos e conteúdos são gratuitos. Eventos especiais podem ter um custo simbólico.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 relative">
            <div class="absolute inset-0 bg-ellas-dark">
                <img src="{{ asset('img/página principal.jpg') }}" class="w-full h-full object-cover opacity-20" alt="CTA BG">
                <div class="absolute inset-0 bg-gradient-to-t from-ellas-dark via-transparent to-ellas-dark"></div>
            </div>
            
            <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
                <h2 class="font-orbitron text-4xl md:text-5xl font-bold text-white mb-6">Faça Parte da Mudança</h2>
                <p class="font-biorhyme text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                    Sua paixão por tecnologia pode inspirar a próxima geração. Junte-se à nossa comunidade e ajude a construir um futuro mais inclusivo.
                </p>
                <a href="{{ route('register') }}" class="inline-block font-orbitron px-10 py-5 rounded-xl bg-gradient-to-r from-ellas-pink to-ellas-purple text-white font-bold text-xl shadow-[0_0_30px_rgba(227,20,117,0.5)] hover:scale-105 transition-transform">
                    Quero Fazer Parte!
                </a>
            </div>
        </section>

        <footer class="bg-ellas-card border-t border-ellas-nav pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="text-center md:text-left">
                    <img src="{{ asset('img/2.png') }}" alt="Logo" class="h-16 mx-auto md:mx-0 mb-4">
                    <p class="font-biorhyme text-gray-400 text-sm max-w-xs">Juntas, transformamos o futuro da tecnologia!</p>
                </div>
                
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-ellas-purple text-2xl transition-colors"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="text-gray-400 hover:text-ellas-pink text-2xl transition-colors"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-red-500 text-2xl transition-colors"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-500 text-2xl transition-colors"><i class="bi bi-linkedin"></i></a>
                </div>

                <div class="text-center md:text-right font-orbitron text-sm">
                    <ul class="space-y-2">
                        <li><a href="#inicio" class="text-gray-400 hover:text-white transition-colors">Início</a></li>
                        <li><a href="#sobre" class="text-gray-400 hover:text-white transition-colors">Sobre</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-12 pt-8 border-t border-ellas-nav/30">
                <p class="font-biorhyme text-gray-500 text-sm">© {{ date('Y') }} | Conectada com Ellas</p>
            </div>
        </footer>

    </body>
</html>
