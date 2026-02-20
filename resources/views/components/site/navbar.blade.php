<nav x-data="{ open: false }" class="fixed w-full z-50 bg-ellas-card/8 backdrop-blur-md border-b border-ellas-nav transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="font-orbitron font-bold text-3xl tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan hover:scale-100 transition-transform">
                   Conectadas com ELLAS
                </a>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
            <a href="{{ route('home') }}" class="font-orbitron text-sm {{ request()->routeIs('home') ? 'text-ellas-cyan' : 'hover:text-ellas-cyan' }} transition-colors">Início</a>
            <a href="{{ route('site.about') }}" class="font-orbitron text-sm {{ request()->routeIs('site.about') ? 'text-ellas-cyan' : 'hover:text-ellas-cyan' }} transition-colors">Sobre</a>
            <a href="{{ route('site.services') }}" class="font-orbitron text-sm {{ request()->routeIs('site.services') ? 'text-ellas-cyan' : 'hover:text-ellas-cyan' }} transition-colors">O que oferecemos</a>
            <a href="{{ route('site.testimonials') }}" class="font-orbitron text-sm {{ request()->routeIs('site.testimonials') ? 'text-ellas-cyan' : 'hover:text-ellas-cyan' }} transition-colors">Depoimentos</a>
            
            @if (Route::has('login'))
                @if(Auth::guard('admin')->check())
                    <a href="{{ route('admin.dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-cyan hover:bg-blue-500 text-ellas-dark transition-all font-bold shadow-[0_0_15px_rgba(4,203,239,0.5)]">
                        Painel Admin
                    </a>
                @elseif(Auth::guard('mentora')->check())
                    <a href="{{ route('mentora.dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-pink hover:bg-red-500 text-white transition-all shadow-[0_0_15px_rgba(227,20,117,0.5)]">
                        Painel Mentora
                    </a>
                @elseif(Auth::guard('web')->check())
                    <a href="{{ route('dashboard') }}" class="font-orbitron px-6 py-2 rounded-full bg-ellas-purple hover:bg-purple-700 text-white transition-all shadow-[0_0_15px_rgba(165,4,170,0.5)]">
                        Dashboard
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
            <a href="{{ route('home') }}" class="block font-orbitron text-white hover:text-ellas-cyan">Início</a>
            <a href="{{ route('site.about') }}" class="block font-orbitron text-white hover:text-ellas-cyan">Sobre</a>
            <a href="{{ route('site.services') }}" class="block font-orbitron text-white hover:text-ellas-cyan">O que oferecemos</a>
            <a href="{{ route('site.testimonials') }}" class="block font-orbitron text-white hover:text-ellas-cyan">Depoimentos</a>
            <a href="{{ route('login') }}" class="block font-orbitron text-white hover:text-ellas-pink">Login</a>
            <a href="{{ route('register') }}" class="block font-orbitron text-ellas-cyan">Cadastre-se</a>
        </div>
    </div>
</nav>