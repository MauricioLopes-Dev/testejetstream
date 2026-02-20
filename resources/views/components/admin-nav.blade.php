<nav x-data="{ open: false }" class="bg-white dark:bg-ellas-card border-b border-gray-100 dark:border-ellas-nav shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <!-- LADO ESQUERDO: Logo + Links -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-orbitron font-bold text-xl tracking-wider hover:scale-105 transition-transform">
                        <img src="{{ asset('img/3.png') }}" alt="Logo" class="h-10 w-auto" />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink hidden lg:block">ADMIN</span>
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

                    <x-nav-link href="{{ route('admin.cursos.index') }}" :active="request()->routeIs('admin.cursos.*')" class="font-orbitron text-xs lg:text-sm text-slate-600 dark:text-white hover:text-ellas-purple dark:hover:text-ellas-cyan">
                        Cursos
                    </x-nav-link>
                </div>
            </div>

            <!-- LADO DIREITO: User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
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
                            <x-dropdown-link href="{{ route('admin.perfil') }}" class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav">
                                Perfil / Configurações
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.sobre.editar') }}" class="text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-ellas-nav">
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

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link href="{{ route('admin.cursos.index') }}" :active="request()->routeIs('admin.cursos.*')">
                Cursos
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 bg-white dark:bg-ellas-card">
            <div class="flex items-center px-4">
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200 font-orbitron">{{ Auth::guard('admin')->user()->nome }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::guard('admin')->user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('admin.perfil') }}">
                    Perfil / Configurações
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin.sobre.editar') }}">
                    Editar Sobre
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                        Sair
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
