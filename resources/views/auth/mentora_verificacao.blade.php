<x-guest-layout>
    <div class="mb-10 mt-8 text-center">
        <h2 class="font-orbitron text-2xl text-white">Verificação de E-mail</h2>
        <p class="font-biorhyme text-gray-400 text-sm mt-2">Enviamos um código de 6 dígitos para o seu e-mail.</p>
    </div>

    <form method="POST" action="{{ route('mentora.verificar_codigo') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="email" value="{{ request('email') }}">

        <div class="space-y-4">
            <x-label for="codigo" value="Insira o código de 6 dígitos" class="text-center block w-full" />
            <div class="relative">
                <x-input id="codigo" class="block w-full bg-ellas-dark border-ellas-nav text-white text-center text-3xl tracking-[1rem] font-bold py-4 focus:ring-ellas-pink focus:border-ellas-pink" type="text" name="codigo" maxlength="6" required autofocus placeholder="000000" />
            </div>
            <x-input-error for="codigo" class="mt-2 text-center" />
        </div>

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(227,20,117,0.3)] hover:shadow-[0_0_30px_rgba(227,20,117,0.5)] hover:scale-[1.02] transition-all duration-300">
            VALIDAR CÓDIGO <i class="fas fa-check-circle ml-2"></i>
        </button>
    </form>

    <div class="mt-10 text-center">
        <p class="font-biorhyme text-gray-500 text-xs">
            Não recebeu o código? <a href="#" class="text-ellas-cyan hover:underline transition-colors">Reenviar e-mail</a>
        </p>
    </div>
</x-guest-layout>
