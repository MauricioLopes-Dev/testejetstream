<x-guest-layout>
    <a href="/" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-cyan transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-cyan group-hover:bg-ellas-cyan/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar</span>
    </a>

    <div class="mb-8 mt-8">
        <a href="/" class="hidden lg:block font-orbitron font-bold text-4xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan mb-2">
            Conectada com ELLAS
        </a>
        <h2 class="font-orbitron text-2xl text-white">Crie sua conta</h2>
        <p class="font-biorhyme text-gray-400 text-sm mt-2">Junte-se à nossa comunidade tecnológica.</p>
    </div>

    <div class="flex mb-6 border-b border-ellas-nav">
        <a href="{{ route('login') }}" class="pb-2 px-4 font-orbitron text-gray-500 hover:text-white transition-colors">
            Login
        </a>
        <a href="#" class="pb-2 px-4 font-orbitron text-ellas-cyan border-b-2 border-ellas-cyan transition-colors">
            Cadastro
        </a>
    </div>

    <div class="mb-8 relative group">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl opacity-60 group-hover:opacity-100 blur transition duration-200"></div>
        
        <a href="{{ route('register.mentor') }}" class="relative block bg-ellas-dark rounded-xl p-4 flex items-center justify-between border border-ellas-purple/30 hover:border-ellas-pink/50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-lg shrink-0">
                    <i class="fas fa-crown"></i>
                </div>
                <div>
                    <h3 class="font-orbitron text-white text-sm font-bold uppercase tracking-wide">Sou Especialista</h3>
                    <p class="font-biorhyme text-gray-300 text-xs">Quero me cadastrar como Mentora</p>
                </div>
            </div>
            <div class="text-pink-500 group-hover:translate-x-1 transition-transform">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <x-label for="name" value="{{ __('Nome Completo') }}" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                    <i class="fas fa-user"></i>
                </div>
                <x-input id="name" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Como devemos te chamar?" />
            </div>
        </div>

        <div class="space-y-2">
            <x-label for="email" value="{{ __('Email') }}" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                    <i class="fas fa-envelope"></i>
                </div>
                <x-input id="email" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-label for="password" value="{{ __('Senha') }}" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                        <i class="fas fa-lock"></i>
                    </div>
                    <x-input id="password" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="password" name="password" required autocomplete="new-password" placeholder="••••" />
                </div>
            </div>
            <div class="space-y-2">
                <x-label for="password_confirmation" value="{{ __('Confirmar') }}" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <x-input id="password_confirmation" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••" />
                </div>
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-label for="terms">
                    <div class="flex items-center">
                        <x-checkbox name="terms" id="terms" required class="bg-ellas-dark border-ellas-nav text-ellas-cyan focus:ring-ellas-cyan" />
                        <div class="ms-2 text-gray-400 text-xs font-biorhyme">
                            {!! __('Concordo com os :terms_of_service e :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-ellas-cyan hover:text-white">'.__('Termos').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-ellas-cyan hover:text-white">'.__('Privacidade').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-label>
            </div>
        @endif

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-cyan to-ellas-purple rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(4,203,239,0.3)] hover:shadow-[0_0_30px_rgba(4,203,239,0.5)] hover:scale-[1.02] transition-all duration-300 flex justify-center items-center gap-2">
            CRIAR CONTA <i class="fas fa-rocket"></i>
        </button>
    </form>
</x-guest-layout>