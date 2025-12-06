<x-guest-layout>
    <a href="{{ route('login') }}" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-cyan transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-cyan group-hover:bg-ellas-cyan/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar ao Login</span>
    </a>

    <div class="mb-8 mt-8">
        <h2 class="font-orbitron text-2xl text-white">Nova Senha</h2>
        <p class="font-biorhyme text-gray-400 text-sm mt-2">Defina sua nova credencial de acesso.</p>
    </div>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-2">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
        </div>

        <div class="space-y-2">
            <x-label for="password" value="{{ __('Nova Senha') }}" />
            <x-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
        </div>

        <div class="space-y-2">
            <x-label for="password_confirmation" value="{{ __('Confirmar Senha') }}" />
            <x-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
        </div>

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-cyan to-ellas-purple rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(4,203,239,0.3)] hover:shadow-[0_0_30px_rgba(4,203,239,0.5)] hover:scale-[1.02] transition-all duration-300">
            {{ __('Atualizar Senha') }}
        </button>
    </form>
</x-guest-layout>