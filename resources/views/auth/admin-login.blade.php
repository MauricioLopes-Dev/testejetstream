<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        
        <!-- Logo e Título -->
        <div class="mb-6 text-center">
            <a href="/" class="flex justify-center mb-4">
                <img src="{{ asset('IMG/2.png') }}" class="h-20 w-auto bg-white rounded-full p-2" />
            </a>
            <h2 class="text-2xl font-bold text-white font-orbitron tracking-wider">
                Área Administrativa
            </h2>
            <p class="text-gray-400 text-sm mt-2">Acesso restrito à gestão do Projeto ELLAS</p>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gray-800 shadow-2xl border border-gray-700 overflow-hidden sm:rounded-lg">
            
            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div>
                    <label for="email" class="block font-medium text-sm text-gray-300">Email Administrativo</label>
                    <input id="email" class="block mt-1 w-full bg-gray-900 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-300">Senha</label>
                    <input id="password" class="block mt-1 w-full bg-gray-900 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="bg-gray-900 border-gray-600 text-indigo-500" />
                        <span class="ml-2 text-sm text-gray-400">{{ __('Lembrar-me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('Acessar Painel') }}
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} Projeto ELLAS. Todos os direitos reservados.
        </div>
    </div>
</x-guest-layout>