<x-guest-layout>
    <div class="mb-6 text-center">
        <i class="fas fa-lock text-4xl text-ellas-pink mb-4"></i>
        <h2 class="font-orbitron text-2xl text-white mb-2">Ação Protegida</h2>
        <p class="font-biorhyme text-gray-400 text-sm">
            Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.
        </p>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <x-label for="password" value="{{ __('Senha') }}" />
            <x-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" autofocus placeholder="••••••••" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-pink to-ellas-purple rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(227,20,117,0.3)] hover:shadow-[0_0_30px_rgba(227,20,117,0.5)] hover:scale-[1.02] transition-all duration-300">
                {{ __('Confirmar') }}
            </button>
        </div>
    </form>
</x-guest-layout>