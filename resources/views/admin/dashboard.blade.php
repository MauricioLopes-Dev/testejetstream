<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-ellas-dark bg-[url('/img/inicio.jpg')] bg-cover bg-center bg-no-repeat bg-blend-overlay bg-black/80">
        
        <!-- Logo e Título -->
        <div class="mb-8 text-center animate__animated animate__fadeInDown">
            <a href="/" class="flex justify-center mb-6">
                <div class="p-4 rounded-full bg-ellas-card border border-ellas-purple/30 shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                    <img src="{{ asset('img/2.png') }}" class="h-20 w-auto" />
                </div>
            </a>
            <h2 class="text-3xl font-bold text-white font-orbitron tracking-wider">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Portal</span> Administrativo
            </h2>
            <p class="text-gray-400 text-sm mt-3 font-biorhyme">Gerenciamento do Ecossistema Ellas</p>
        </div>

        <div class="w-full sm:max-w-md mt-4 px-8 py-10 bg-ellas-card/95 backdrop-blur-sm border border-ellas-nav shadow-[0_0_50px_rgba(0,0,0,0.5)] rounded-2xl animate__animated animate__fadeInUp">
            
            <x-validation-errors class="mb-6" />

            @if (session('status'))
                <div class="mb-6 font-medium text-sm text-green-400 bg-green-900/30 p-3 rounded border border-green-800">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div>
                    <label for="email" class="block font-orbitron text-sm text-gray-300 mb-2">Email Corporativo</label>
                    <input id="email" class="block w-full bg-ellas-dark border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20 rounded-lg shadow-inner py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@ellastech.com" />
                </div>

                <div class="mt-6">
                    <label for="password" class="block font-orbitron text-sm text-gray-300 mb-2">Chave de Segurança</label>
                    <input id="password" class="block w-full bg-ellas-dark border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-pink focus:ring focus:ring-ellas-pink/20 rounded-lg shadow-inner py-3" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="block mt-6">
                    <label for="remember_me" class="flex items-center group cursor-pointer">
                        <x-checkbox id="remember_me" name="remember" class="bg-ellas-dark border-ellas-nav text-ellas-purple focus:ring-ellas-purple rounded" />
                        <span class="ml-3 text-sm text-gray-400 group-hover:text-white transition font-biorhyme">{{ __('Manter conectado neste dispositivo') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <button class="w-full inline-flex justify-center items-center px-6 py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink border border-transparent rounded-xl font-orbitron font-bold text-white uppercase tracking-widest hover:scale-[1.02] hover:shadow-[0_0_20px_rgba(236,72,153,0.4)] active:scale-95 focus:outline-none focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/30 disabled:opacity-25 transition duration-300">
                        {{ __('Acessar Painel') }}
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-12 text-center">
            <p class="text-gray-600 text-xs font-mono">
                &copy; {{ date('Y') }} Projeto ELLAS.<br>Acesso restrito a pessoal autorizado.
            </p>
            <a href="/" class="inline-block mt-4 text-ellas-cyan hover:text-white text-sm transition font-orbitron">
                ← Voltar ao Site
            </a>
        </div>
    </div>
</x-guest-layout>