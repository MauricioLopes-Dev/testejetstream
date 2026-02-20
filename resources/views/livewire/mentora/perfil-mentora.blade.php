<div>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Meu</span> Perfil
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informações Básicas -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-crown text-ellas-pink mr-3"></i>
                        INFORMAÇÕES BÁSICAS
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Nome</label>
                        <input type="text" value="{{ $nome }}" disabled class="w-full bg-gray-800 border-gray-700 text-gray-500 rounded-lg px-4 py-2 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Email</label>
                        <input type="email" value="{{ $email }}" disabled class="w-full bg-gray-800 border-gray-700 text-gray-500 rounded-lg px-4 py-2 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Telefone</label>
                        <input type="text" value="{{ $telefone ?? 'Não informado' }}" disabled class="w-full bg-gray-800 border-gray-700 text-gray-500 rounded-lg px-4 py-2 cursor-not-allowed">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Área de Atuação</label>
                            <input type="text" value="{{ $area_atuacao }}" disabled class="w-full bg-gray-800 border-gray-700 text-gray-500 rounded-lg px-4 py-2 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Experiência</label>
                            <input type="text" value="{{ ucfirst($nivel_experiencia) }}" disabled class="w-full bg-gray-800 border-gray-700 text-gray-500 rounded-lg px-4 py-2 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alterar Senha -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-key text-ellas-cyan mr-3"></i>
                        ALTERAR SENHA
                    </h3>
                </div>

                <form wire:submit.prevent="alterarSenha" class="p-6 space-y-6">
                    @if(session('message'))
                        <div class="p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Senha Atual *</label>
                        <input type="password" wire:model="current_password" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-cyan focus:border-ellas-cyan" required>
                        @error('current_password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Nova Senha *</label>
                        <input type="password" wire:model="password" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-cyan focus:border-ellas-cyan" required>
                        @error('password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Confirmar Nova Senha *</label>
                        <input type="password" wire:model="password_confirmation" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-cyan focus:border-ellas-cyan" required>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-ellas-nav">
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                            ATUALIZAR SENHA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
