<div>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Gerenciar</span> Cursos
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('message'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <div class="mb-6 flex justify-end">
                <button wire:click="abrirModal" class="px-6 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                    <i class="fas fa-plus mr-2"></i>CRIAR NOVO CURSO
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($cursos as $curso)
                    <div class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:border-ellas-purple transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-orbitron text-lg text-white font-bold">{{ $curso->nome }}</h3>
                            @if($curso->ativo)
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-full">Ativo</span>
                            @else
                                <span class="px-2 py-1 bg-gray-500/20 text-gray-400 text-xs rounded-full">Inativo</span>
                            @endif
                        </div>

                        <div class="space-y-2 text-sm text-gray-300 mb-4">
                            <p><i class="fas fa-tag text-ellas-pink mr-2"></i>{{ $curso->nome_area }}</p>
                            <p><i class="fas fa-calendar text-ellas-cyan mr-2"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</p>
                            @if($curso->mentora)
                                <p><i class="fas fa-user text-ellas-purple mr-2"></i>{{ $curso->mentora->nome }}</p>
                            @else
                                <p><i class="fas fa-user-slash text-gray-500 mr-2"></i>Sem mentora atribuída</p>
                            @endif
                            <p><i class="fas fa-users text-ellas-cyan mr-2"></i>{{ $curso->inscritos->count() }} inscritos</p>
                        </div>

                        <div class="flex gap-2">
                            <button wire:click="abrirModal({{ $curso->id }})" class="flex-1 px-4 py-2 bg-ellas-purple/20 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded-lg text-xs font-bold transition-all">
                                EDITAR
                            </button>
                            <button wire:click="excluir({{ $curso->id }})" onclick="return confirm('Tem certeza que deseja excluir este curso?')" class="flex-1 px-4 py-2 bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-xs font-bold transition-all">
                                EXCLUIR
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <i class="fas fa-graduation-cap text-5xl text-gray-700 mb-4"></i>
                        <p class="text-gray-500 font-biorhyme italic">Nenhum curso cadastrado ainda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center sticky top-0 bg-ellas-card z-10">
                    <h3 class="font-orbitron text-lg text-white font-bold">
                        {{ $curso_id ? 'EDITAR CURSO' : 'CRIAR NOVO CURSO' }}
                    </h3>
                    <button wire:click="fecharModal" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form wire:submit.prevent="salvar" class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Nome do Curso *</label>
                        <input type="text" wire:model="nome" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" required>
                        @error('nome') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Descrição</label>
                        <textarea wire:model="descricao" rows="3" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Área de Atuação</label>
                        <select wire:model.live="area_atuacao_id" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                            <option value="">Selecione uma área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($mostrarAreaPersonalizada)
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Nome da Área Personalizada *</label>
                            <input type="text" wire:model="area_personalizada" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" required>
                            @error('area_personalizada') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Data de Início *</label>
                            <input type="date" wire:model="data_inicio" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" required>
                            @error('data_inicio') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Data de Fim *</label>
                            <input type="date" wire:model="data_fim" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" required>
                            @error('data_fim') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Atribuir Mentora</label>
                        <select wire:model="mentora_id" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                            <option value="">Nenhuma (será atribuída depois)</option>
                            @foreach($mentoras as $mentora)
                                <option value="{{ $mentora->id }}">{{ $mentora->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="ativo" id="ativo" class="mr-2 bg-ellas-dark border-ellas-nav text-ellas-purple focus:ring-ellas-purple rounded">
                        <label for="ativo" class="text-gray-300 font-biorhyme text-sm">Curso ativo</label>
                    </div>

                    <div class="flex justify-end gap-4 pt-6 border-t border-ellas-nav">
                        <button type="button" wire:click="fecharModal" class="px-6 py-2 text-gray-400 hover:text-white font-orbitron text-xs uppercase transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                            {{ $curso_id ? 'ATUALIZAR' : 'CRIAR' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
