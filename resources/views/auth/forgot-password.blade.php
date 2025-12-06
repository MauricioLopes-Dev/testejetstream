<x-guest-layout>
    <a href="{{ route('login') }}" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-purple transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-purple group-hover:bg-ellas-purple/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar para Login</span>
    </a>

    <div class="mb-8 mt-8">
        <h2 class="font-orbitron text-2xl text-white">Recuperar Senha</h2>
        <p class="font-biorhyme text-gray-400 text-sm mt-4 leading-relaxed">
            Esqueceu sua senha? Sem problemas. Informe seu e-mail e enviaremos um link para você escolher uma nova.
        </p>
    </div>

    @session('status')
        <div class="mb-4 font-medium text-sm text-green-400 bg-green-400/10 p-3 rounded-lg border border-green-400/20">
            {{ $value }}
        </div>
    @endsession

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <x-label for="email" value="{{ __('Email') }}" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-purple">
                    <i class="fas fa-envelope"></i>
                </div>
                <x-input id="email" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-purple focus:ring focus:ring-ellas-purple/20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(165,4,170,0.3)] hover:shadow-[0_0_30px_rgba(165,4,170,0.5)] hover:scale-[1.02] transition-all duration-300">
            {{ __('Enviar Link de Recuperação') }}
        </button>
    </form>
</x-guest-layout>