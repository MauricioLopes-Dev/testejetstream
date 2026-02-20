<div>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Meu</span> Perfil
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Perfil -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-user text-ellas-cyan mr-3"></i>
                        INFORMAÇÕES DO PERFIL
                    </h3>
                </div>

                <form wire:submit.prevent="atualizarPerfil" class="p-6 space-y-6">
                    @if(session('message'))
                        <div class="p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Foto de Perfil -->
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            @if($foto)
                                <img src="{{ $foto->temporaryUrl() }}" class="w-24 h-24 rounded-full object-cover border-4 border-ellas-purple">
                            @else
                                <img src="{{ $foto_url }}" class="w-24 h-24 rounded-full object-cover border-4 border-ellas-purple">
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Foto de Perfil</label>
                            <input type="file" wire:model="foto" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-ellas-purple file:text-white hover:file:bg-ellas-pink transition-all">
                            @error('foto') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Nome Completo *</label>
                        <input type="text" wire:model="name" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" required>
                        @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Email</label>
                        <input type="email" value="{{ $email }}" disabled class="w-full bg-gray-800 border-gray-700 text-gray-500 rounded-lg px-4 py-2 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">O email não pode ser alterado</p>
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Telefone</label>
                        <input type="text" wire:model="telefone" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="(00) 00000-0000">
                        @error('telefone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-ellas-nav">
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                            SALVAR ALTERAÇÕES
                        </button>
                    </div>
                </form>
            </div>

            <!-- Alterar Senha -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-key text-ellas-pink mr-3"></i>
                        ALTERAR SENHA
                    </h3>
                </div>

                <form wire:submit.prevent="alterarSenha" class="p-6 space-y-6">
                    @if(session('senha_message'))
                        <div class="p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                            {{ session('senha_message') }}
                        </div>
                    @endif

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Senha Atual *</label>
                        <input type="password" wire:model="current_password" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-pink focus:border-ellas-pink" required>
                        @error('current_password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Nova Senha *</label>
                        <input type="password" wire:model="password" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-pink focus:border-ellas-pink" required>
                        @error('password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Confirmar Nova Senha *</label>
                        <input type="password" wire:model="password_confirmation" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-pink focus:border-ellas-pink" required>
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
