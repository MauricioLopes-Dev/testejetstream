<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/90 dark:bg-ellas-card/90 backdrop-blur-md border-b border-gray-200 dark:border-ellas-nav shadow-sm dark:shadow-lg dark:shadow-black/50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <!-- LADO ESQUERDO: Logo + Links -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 font-orbitron font-bold text-xl tracking-wider hover:scale-105 transition-transform">
                        <img src="{{ asset('img/3.png') }}" alt="Logo" class="h-10 w-auto" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink hidden lg:block">ELLAS</span>
                    </a>
                </div>

                <!-- Navigation Links (Ajuste de espaço: space-x-4 em telas menores) -->
                <div class="hidden space-x-4 lg:space-x-6 xl:space-x-8 sm:-my-px sm:ml-6 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="font-orbitron text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('eventos.index') }}" :active="request()->routeIs('eventos.*')" class="font-orbitron text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        {{ __('Eventos') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('agenda.index') }}" :active="request()->routeIs('agenda.index')" class="font-orbitron text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        {{ __('Agenda') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('meus.cursos') }}" :active="request()->routeIs('meus.cursos')" class="font-orbitron text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        {{ __('Cursos') }}
                    </x-nav-link>


                    @if(Auth::user()->role === 'mentora' || Auth::user()->role === 'admin')
                        <x-nav-link href="{{ route('solicitacoes.index') }}" :active="request()->routeIs('solicitacoes.index')" class="font-orbitron text-ellas-pink font-bold hover:text-ellas-purple">
                            {{ __('Gestão') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- LADO DIREITO: Configurações -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-2">
                
                <!-- 1. Teams Dropdown (SÓ PARA ADMIN) -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->role === 'admin')
                    <div class="relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-slate-600 dark:text-white bg-gray-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 transition">
                                        <span class="hidden lg:inline">{{ Auth::user()->currentTeam ? Auth::user()->currentTeam->name : 'Time' }}</span>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4 text-ellas-purple dark:text-ellas-cyan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-60 bg-white dark:bg-ellas-card border border-gray-100 dark:border-ellas-nav rounded-md">
                                    <div class="block px-4 py-2 text-xs text-gray-400 font-orbitron">
                                        {{ __('Gerenciar Time') }}
                                    </div>
                                    @if(Auth::user()->currentTeam)
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav">
                                            {{ __('Configurações') }}
                                        </x-dropdown-link>
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}" class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav">
                                                {{ __('Criar Novo Time') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200 dark:border-ellas-nav"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Trocar Time') }}
                                            </div>
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- 2. Dark Mode Toggle (NO MEIO) -->
                <button 
                    type="button" 
                    x-data="{ 
                        isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
                    }"
                    x-on:click="
                        isDark = !isDark;
                        if (isDark) {
                            document.documentElement.classList.add('dark');
                            localStorage.theme = 'dark';
                        } else {
                            document.documentElement.classList.remove('dark');
                            localStorage.theme = 'light';
                        }
                    "
                    class="p-2 rounded-full text-slate-500 hover:bg-slate-100 dark:text-gray-400 dark:hover:bg-ellas-nav dark:hover:text-ellas-cyan transition-all duration-300 focus:outline-none mx-1"
                    title="Alternar Tema"
                >
                    <svg x-show="!isDark" class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="isDark" style="display: none;" class="w-5 h-5 text-ellas-purple" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- 3. User Dropdown (NA DIREITA EXTREMA) -->
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-ellas-purple rounded-full focus:outline-none focus:border-ellas-cyan transition shadow-sm hover:shadow-md">
                                    <img class="h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-slate-600 dark:text-white hover:bg-slate-100 dark:hover:bg-white/10 transition">
                                        <!-- Esconde o nome em telas médias para economizar espaço -->
                                        <span class="hidden lg:inline mr-1">{{ Auth::user()->name }}</span>
                                        <svg class="h-4 w-4 text-ellas-purple dark:text-ellas-cyan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-white dark:bg-ellas-card border-none">
                                <div class="block px-4 py-2 text-xs text-gray-400 font-orbitron">
                                    {{ __('Minha Conta') }}
                                </div>
                                <x-dropdown-link href="{{ route('profile.show') }}" class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav dark:hover:text-ellas-pink">
                                    {{ __('Perfil') }}
                                </x-dropdown-link>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}" class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-200 dark:border-ellas-nav"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-ellas-nav">
                                        {{ __('Sair') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-slate-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-ellas-card border-t border-gray-200 dark:border-ellas-nav">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('completar-perfil') }}" :active="request()->routeIs('completar-perfil')" class="text-slate-600 dark:text-white">
                {{ __('Meu Perfil') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('blog.index') }}" :active="request()->routeIs('blog.*')" class="text-slate-600 dark:text-white">
                {{ __('Histórias') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('eventos.index') }}" :active="request()->routeIs('eventos.*')" class="text-slate-600 dark:text-white">
                {{ __('Eventos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('agenda.index') }}" :active="request()->routeIs('agenda.index')" class="text-slate-600 dark:text-white">
                {{ __('Agenda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('meus.cursos') }}" :active="request()->routeIs('meus.cursos')" class="text-slate-600 dark:text-white">
                {{ __('Meus Cursos') }}
            </x-responsive-nav-link>
    
            @if(Auth::user()->role === 'mentora' || Auth::user()->role === 'admin')
                <x-responsive-nav-link href="{{ route('solicitacoes.index') }}" :active="request()->routeIs('solicitacoes.index')" class="text-ellas-pink font-bold">
                    {{ __('Gestão') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-ellas-nav bg-gray-50 dark:bg-ellas-dark">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover border border-ellas-purple" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif
                <div>
                    <div class="font-medium text-base text-slate-800 dark:text-white font-orbitron">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400 font-biorhyme">{{ Auth::user()->email }}</div>
                </div>
                
                <button 
                    type="button" 
                    x-data="{ isDark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
                    x-on:click="isDark = !isDark; if (isDark) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; }"
                    class="ml-auto p-2 text-slate-500 dark:text-gray-400"
                >
                    <svg x-show="!isDark" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="isDark" style="display: none;" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" class="text-slate-600 dark:text-gray-300">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-red-600 dark:text-red-400">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>