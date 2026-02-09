<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-ellas-dark border-2 border-ellas-cyan mb-6 shadow-[0_0_20px_rgba(4,203,239,0.3)]">
            <i class="fas fa-user-shield text-3xl text-ellas-cyan animate-pulse"></i>
        </div>
        
        <h2 class="font-orbitron text-3xl font-bold text-white mb-3 tracking-wider">
            QUASE LÁ!
        </h2>
        
        <p class="font-biorhyme text-gray-400 text-sm leading-relaxed max-w-xs mx-auto">
            Para sua segurança, enviamos um <span class="text-ellas-cyan font-bold">código de 6 dígitos</span> para o seu e-mail. Insira-o abaixo para ativar sua conta.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-xs font-biorhyme text-center animate-bounce">
            <i class="fas fa-check-circle mr-2"></i> {{ __('Um novo código foi enviado para o seu e-mail!') }}
        </div>
    @endif

    <div class="space-y-8">
        <!-- Componente Livewire de 6 dígitos -->
        @livewire('verify-email-code')

        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-800"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-ellas-card px-2 text-gray-500 font-orbitron">Problemas com o código?</span>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full text-sm text-gray-400 hover:text-ellas-cyan transition-colors font-orbitron flex items-center justify-center gap-2 group">
                    <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform duration-500"></i>
                    {{ __('Reenviar código de verificação') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-xs text-gray-600 hover:text-ellas-pink underline transition-colors font-biorhyme">
                    {{ __('Sair e entrar com outra conta') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
