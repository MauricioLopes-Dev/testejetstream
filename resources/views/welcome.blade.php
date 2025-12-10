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

        <nav x-data="{ open: false }" class="fixed w-full z-50 bg-ellas-card/80 backdrop-blur-md border-b border-ellas-nav transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="shrink-0 flex items-center">
                        <a href="/" class="font-orbitron font-bold text-3xl tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan hover:scale-105 transition-transform">
                           Projeto ELLAS
                        </a>
                    </div>

                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#inicio" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">Início</a>
                        <a href="#sobre" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">Sobre</a>
                        <a href="#servicos" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">O que oferecemos</a>
                        <a href="#depoimentos" class="font-orbitron text-sm hover:text-ellas-cyan transition-colors">Depoimentos</a>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-purple hover:bg-ellas-pink text-white transition-all shadow-[0_0_15px_rgba(165,4,170,0.5)] hover:shadow-[0_0_20px_rgba(227,20,117,0.6)]">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="font-orbitron text-sm hover:text-ellas-pink transition-colors mr-4">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-orbitron px-6 py-2 rounded-full bg-gradient-to-r from-ellas-purple to-ellas-cyan text-white font-bold transition-all hover:scale-105 shadow-[0_0_15px_rgba(4,203,239,0.4)]">
                                        Cadastre-se
                                    </a>
                                @endif
                            @endauth
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

        <section id="sobre" class="py-20 bg-ellas-card/50">
            <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-ellas-gradient rounded-3xl blur opacity-30 transform rotate-3"></div>
                    <img src="{{ asset('img/Desenvolver.jpg') }}" alt="Nossa História" class="relative rounded-3xl shadow-2xl border border-white/10 w-full object-cover h-[400px]">
                </div>
                <div class="lg:w-1/2 space-y-6">
                    <h5 class="font-orbitron text-ellas-pink tracking-widest uppercase text-sm">Sobre Nós</h5>
                    <h2 class="font-orbitron text-4xl font-bold text-white">A Nossa História</h2>
                    <p class="font-biorhyme text-gray-300 leading-relaxed text-justify">
                        Idealizada por Rosana Mendes e fundada em 2025, o projeto <strong>'Conectada com Ellas'</strong> nasceu da paixão por promover a inclusão. Oferecemos oficinas interativas, eventos inspiradores e uma rede de apoio colaborativa. Acreditamos que, juntas, podemos superar barreiras e conectar mulheres de diferentes perfis para transformar o futuro da tecnologia.
                    </p>
                </div>
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

        <section id="depoimentos" class="py-20 bg-ellas-card relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-ellas-purple/10 rounded-full blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <h5 class="font-orbitron text-center text-white/50 tracking-widest uppercase text-sm mb-2">Comunidade</h5>
                <h2 class="font-orbitron text-center text-4xl font-bold text-white mb-12">Histórias que Inspiram</h2>

                <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide">
                    <div class="min-w-[300px] md:min-w-[400px] bg-ellas-dark p-8 rounded-2xl border border-ellas-nav snap-center">
                        <i class="fas fa-quote-left text-3xl text-ellas-purple mb-4"></i>
                        <p class="font-biorhyme text-gray-300 italic mb-6">"Este site foi um divisor de águas. Graças às oportunidades indicadas aqui, consegui meu primeiro emprego na área!"</p>
                        <div class="flex items-center gap-4 border-t border-ellas-nav pt-4">
                            <img src="https://i.pravatar.cc/80?img=25" class="w-12 h-12 rounded-full border-2 border-ellas-purple" alt="Carla">
                            <div>
                                <p class="font-orbitron text-white font-bold">Carla M.</p>
                                <p class="text-xs text-ellas-purple">Programadora Júnior</p>
                            </div>
                        </div>
                    </div>

                    <div class="min-w-[300px] md:min-w-[400px] bg-ellas-dark p-8 rounded-2xl border border-ellas-nav snap-center">
                        <i class="fas fa-quote-left text-3xl text-ellas-pink mb-4"></i>
                        <p class="font-biorhyme text-gray-300 italic mb-6">"Aqui encontrei um espaço para trocar experiências e crescer junto. Isso realmente me deu mais confiança!"</p>
                        <div class="flex items-center gap-4 border-t border-ellas-nav pt-4">
                            <img src="https://i.pravatar.cc/80?img=32" class="w-12 h-12 rounded-full border-2 border-ellas-pink" alt="Fernanda">
                            <div>
                                <p class="font-orbitron text-white font-bold">Fernanda S.</p>
                                <p class="text-xs text-ellas-pink">Engenheira de Software</p>
                            </div>
                        </div>
                    </div>

                    <div class="min-w-[300px] md:min-w-[400px] bg-ellas-dark p-8 rounded-2xl border border-ellas-nav snap-center">
                        <i class="fas fa-quote-left text-3xl text-ellas-cyan mb-4"></i>
                        <p class="font-biorhyme text-gray-300 italic mb-6">"As histórias de sucesso no site me inspiraram a não desistir. Hoje sou coordenadora de inovação."</p>
                        <div class="flex items-center gap-4 border-t border-ellas-nav pt-4">
                            <img src="https://i.pravatar.cc/80?img=9" class="w-12 h-12 rounded-full border-2 border-ellas-cyan" alt="Ana">
                            <div>
                                <p class="font-orbitron text-white font-bold">Ana P.</p>
                                <p class="text-xs text-ellas-cyan">Cientista de Dados</p>
                            </div>
                        </div>
                    </div>
                </div>
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