<x-guest-layout>
    <a href="/" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-cyan transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-cyan group-hover:bg-ellas-cyan/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar</span>
    </a>

    <div class="mb-10 mt-8"> 
        <a href="/" class="hidden lg:block font-orbitron font-bold text-4xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan mb-2">
            Conectadas com ELLAS
        </a>
        <h2 class="font-orbitron text-2xl text-white">{{ $titulo ?? 'Acesse sua conta' }}</h2>
        <p class="font-biorhyme text-gray-400 text-sm mt-2">Insira seus dados para acessar sua conta.</p>
    </div>

    <div class="flex mb-8 border-b border-ellas-nav">
        <span class="pb-2 px-4 font-orbitron text-ellas-pink border-b-2 border-ellas-pink transition-colors">
            Login
        </span>
    </div>

    <x-validation-errors class="mb-4" />

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-400">
            {{ session('status') }}
        </div>
    @endif

    @php
        $loginUrl = route('login');
        if(isset($tipo)) {
            if($tipo === 'mentora') $loginUrl = route('mentora.post_login');
            if($tipo === 'admin') $loginUrl = route('admin.post_login');
        }
    @endphp

    <form method="POST" action="{{ $loginUrl }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <x-label for="email" value="{{ __('Email') }}" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-purple">
                    <i class="fas fa-envelope"></i>
                </div>
                <x-input id="email" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-pink focus:ring focus:ring-ellas-pink/20 transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            </div>
        </div>

        <div class="space-y-2">
            <div class="flex justify-between">
                <x-label for="password" value="{{ __('Senha') }}" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-ellas-cyan hover:text-ellas-pink font-orbitron transition-colors" href="{{ route('password.request') }}">
                        {{ __('Esqueceu a senha?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-purple">
                    <i class="fas fa-lock"></i>
                </div>
                <x-input id="password" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-pink focus:ring focus:ring-ellas-pink/20 transition-all" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <x-checkbox id="remember_me" name="remember" class="bg-ellas-dark border-ellas-nav text-ellas-pink focus:ring-ellas-pink rounded" />
                <span class="ms-2 text-sm text-gray-400 group-hover:text-white transition-colors font-biorhyme">{{ __('Lembrar de mim') }}</span>
            </label>
        </div>

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(227,20,117,0.3)] hover:shadow-[0_0_30px_rgba(227,20,117,0.5)] hover:scale-[1.02] transition-all duration-300 flex justify-center items-center gap-2">
            ACESSAR CONTA <i class="fas fa-arrow-right"></i>
        </button>

        @if(!isset($tipo) || $tipo === 'aluna')
            <div class="mt-6 text-center">
                <p class="font-biorhyme text-gray-400 text-sm">
                    Ainda não possui uma conta? <a href="{{ route('register') }}" class="text-ellas-cyan hover:text-ellas-pink transition-colors">Cadastre-se</a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
