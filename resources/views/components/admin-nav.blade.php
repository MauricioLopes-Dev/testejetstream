<nav x-data="{ open: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
     class="bg-white dark:bg-ellas-card border-b border-gray-100 dark:border-ellas-nav shadow-lg transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-orbitron font-bold text-xl tracking-wider hover:scale-105 transition-transform">
                        <img src="{{ asset('img/3.png') }}" alt="Logo" class="h-10 w-auto" />
                        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Painel</span> Administrativo
                        </h2>
                    </a>
            </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 lg:space-x-4 sm:-my-px sm:ml-6 sm:flex">
                    <x-nav-link href="{{ route('home') }}" class="font-orbitron text-xs lg:text-sm text-slate-600 dark:text-gray-300 hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        Início
                    </x-nav-link>
                    <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" class="font-orbitron text-xs lg:text-sm text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link href="{{ route('admin.eventos.criar') }}" :active="request()->routeIs('admin.eventos.criar')" class="font-orbitron text-xs lg:text-sm text-slate-600 dark:text-gray-300 hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        Eventos
                    </x-nav-link>

                    <x-nav-link href="{{ route('admin.mentoras.pendentes') }}" :active="request()->routeIs('admin.mentoras.pendentes')" class="font-orbitron text-xs lg:text-sm text-ellas-pink font-bold hover:text-ellas-purple">
                        Aprovar Mentoras
                    </x-nav-link>

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                
                <button 
                    @click="
                        darkMode = !darkMode; 
                        if (darkMode) { 
                            document.documentElement.classList.add('dark'); 
                            localStorage.theme = 'dark'; 
                        } else { 
                            document.documentElement.classList.remove('dark'); 
                            localStorage.theme = 'light'; 
                        }
                    "
                    class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors"
                    title="Alternar Tema"
                >
                    <svg x-show="!darkMode" class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="darkMode" class="w-6 h-6 text-ellas-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white transition duration-150 ease-in-out focus:outline-none">
                            <div class="font-orbitron">{{ Auth::guard('admin')->user()->nome }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-white dark:bg-ellas-card border border-gray-100 dark:border-ellas-nav rounded-md">
                            <x-dropdown-link href="{{ route('admin.perfil') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-ellas-nav dark:hover:text-white">
                                Perfil / Configurações
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.sobre.editar') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-ellas-nav dark:hover:text-white">
                                Editar Sobre
                            </x-dropdown-link>

                            <div class="border-t border-gray-100 dark:border-ellas-nav"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-ellas-nav">
                                    Sair
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden gap-2">
                <button 
                    @click="
                        darkMode = !darkMode; 
                        if (darkMode) { 
                            document.documentElement.classList.add('dark'); 
                            localStorage.theme = 'dark'; 
                        } else { 
                            document.documentElement.classList.remove('dark'); 
                            localStorage.theme = 'light'; 
                        }
                    "
                    class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none"
                >
                    <svg x-show="!darkMode" class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="darkMode" class="w-5 h-5 text-ellas-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-ellas-card">
            <x-nav-link href="{{ route('home') }}" class="font-orbitron text-xs lg:text-sm text-slate-600 dark:text-gray-300 hover:text-ellas-purple dark:hover:text-ellas-cyan">
                Início
            </x-nav-link>
            <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                Dashboard
            </x-responsive-nav-link>
            
            <x-responsive-nav-link href="{{ route('admin.eventos.criar') }}" :active="request()->routeIs('admin.eventos.*')" class="dark:text-gray-300 dark:hover:text-ellas-cyan dark:hover:bg-ellas-nav">
                Eventos
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('admin.mentoras.pendentes') }}" :active="request()->routeIs('admin.mentoras.pendentes')" class="text-ellas-pink font-bold dark:hover:bg-ellas-nav">
                Aprovar Mentoras
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200 font-orbitron">{{ Auth::guard('admin')->user()->nome }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::guard('admin')->user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('admin.perfil') }}" class="dark:text-gray-300 dark:hover:text-ellas-cyan dark:hover:bg-ellas-nav">
                    Perfil / Configurações
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin.sobre.editar') }}" class="dark:text-gray-300 dark:hover:text-ellas-cyan dark:hover:bg-ellas-nav">
                    Editar Sobre
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400 dark:hover:bg-ellas-nav">
                        Sair
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>