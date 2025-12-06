<x-guest-layout>
    <div class="mb-6 text-center">
        <i class="fas fa-paper-plane text-4xl text-ellas-cyan mb-4 drop-shadow-[0_0_10px_rgba(4,203,239,0.5)]"></i>
        <h2 class="font-orbitron text-2xl text-white mb-2">Verifique seu E-mail</h2>
        <p class="font-biorhyme text-gray-400 text-sm leading-relaxed">
            Antes de começar, poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar? Se não recebeu, podemos enviar outro.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-400 bg-green-400/10 p-4 rounded-xl border border-green-400/20 text-center">
            {{ __('Um novo link de verificação foi enviado para o endereço fornecido.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col gap-4 items-center">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full py-3 bg-ellas-card border border-ellas-cyan text-ellas-cyan hover:bg-ellas-cyan hover:text-ellas-dark rounded-xl font-orbitron font-bold transition-all duration-300">
                {{ __('Reenviar E-mail de Verificação') }}
            </button>
        </form>

        <div class="flex justify-between w-full mt-4">
            <a href="{{ route('profile.show') }}" class="underline text-sm text-gray-400 hover:text-ellas-purple font-orbitron">
                {{ __('Editar Perfil') }}
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="underline text-sm text-gray-400 hover:text-ellas-pink font-orbitron ml-2">
                    {{ __('Sair') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>