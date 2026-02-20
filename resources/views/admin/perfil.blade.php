<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Perfil</span> Administrativo
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-key text-ellas-pink mr-3"></i>
                        ALTERAR SENHA
                    </h3>
                    <p class="font-biorhyme text-gray-400 text-sm mt-2">Mantenha sua conta segura atualizando sua senha regularmente.</p>
                </div>

                <div class="p-8">
                    @if(session('status'))
                        <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <x-validation-errors class="mb-6" />

                    <form method="POST" action="{{ route('admin.perfil.senha') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <x-label for="current_password" value="Senha Atual" class="text-gray-300 font-orbitron text-xs uppercase" />
                            <x-input id="current_password" type="password" name="current_password" class="block w-full bg-ellas-dark border-ellas-nav text-white focus:ring-ellas-pink focus:border-ellas-pink" required />
                        </div>

                        <div class="space-y-2">
                            <x-label for="password" value="Nova Senha" class="text-gray-300 font-orbitron text-xs uppercase" />
                            <x-input id="password" type="password" name="password" class="block w-full bg-ellas-dark border-ellas-nav text-white focus:ring-ellas-pink focus:border-ellas-pink" required />
                        </div>

                        <div class="space-y-2">
                            <x-label for="password_confirmation" value="Confirmar Nova Senha" class="text-gray-300 font-orbitron text-xs uppercase" />
                            <x-input id="password_confirmation" type="password" name="password_confirmation" class="block w-full bg-ellas-dark border-ellas-nav text-white focus:ring-ellas-pink focus:border-ellas-pink" required />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white mr-6 font-orbitron text-xs uppercase transition-colors">
                                Cancelar
                            </a>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-[1.02] transition-all">
                                ATUALIZAR SENHA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
