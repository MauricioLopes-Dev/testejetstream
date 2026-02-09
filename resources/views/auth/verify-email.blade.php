<x-guest-layout>
    <div class="mb-6 text-center">
        <i class="fas fa-shield-alt text-4xl text-ellas-cyan mb-4 drop-shadow-[0_0_10px_rgba(4,203,239,0.5)]"></i>
        <h2 class="font-orbitron text-2xl text-white mb-2">Validação de Cadastro</h2>
        <p class="font-biorhyme text-gray-400 text-sm leading-relaxed">
            Enviamos um código de 6 dígitos para o seu e-mail. Digite-o abaixo para validar seu cadastro e liberar seu acesso.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-400 bg-green-400/10 p-4 rounded-xl border border-green-400/20 text-center">
            {{ __('Um novo código foi enviado para o seu e-mail.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col gap-4 items-center">
        <!-- Componente Livewire para validar o código -->
        @livewire('verify-email-code')

        <div class="w-full border-t border-gray-700 my-2"></div>

        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full py-2 text-sm text-gray-400 hover:text-ellas-cyan transition-colors font-orbitron">
                {{ __('Não recebeu? Reenviar código') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="underline text-xs text-gray-500 hover:text-ellas-pink font-orbitron">
                {{ __('Sair e tentar depois') }}
            </button>
        </form>
    </div>
</x-guest-layout>
