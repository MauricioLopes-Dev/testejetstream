<div>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.cursos.index') }}" class="text-gray-400 hover:text-ellas-cyan transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Matérias</span> - {{ $curso->nome }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('message'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('message') }}
                </div>
            @endif

            {{-- Info do Curso --}}
            <div class="bg-ellas-card border border-ellas-nav rounded-xl p-6 mb-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <div class="text-xl font-orbitron font-bold text-ellas-purple">{{ $curso->materias->count() }}</div>
                        <div class="text-xs text-gray-400">Matérias</div>
                    </div>
                    <div>
                        <div class="text-xl font-orbitron font-bold text-ellas-cyan">{{ $curso->max_vagas }}</div>
                        <div class="text-xs text-gray-400">Vagas</div>
                    </div>
                    <div>
                        <div class="text-xl font-orbitron font-bold text-ellas-pink">{{ $curso->duracao_horas ?? 'N/A' }}h</div>
                        <div class="text-xs text-gray-400">Duração</div>
                    </div>
                    <div>
                        <div class="text-xl font-orbitron font-bold text-yellow-400">{{ $curso->mentoras->count() }}</div>
                        <div class="text-xs text-gray-400">Mentoras</div>
                    </div>
                </div>
            </div>

            {{-- Botão Adicionar Matéria --}}
            <div class="mb-6 flex justify-end">
                <button wire:click="abrirMateriaModal" class="px-6 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                    <i class="fas fa-plus mr-2"></i>NOVA MATÉRIA
                </button>
            </div>

            {{-- Lista de Matérias --}}
            <div class="space-y-6">
                @forelse($curso->materias->sortBy('ordem') as $materia)
                    <div class="bg-ellas-card border border-ellas-nav rounded-2xl overflow-hidden">
                        {{-- Header da Matéria --}}
                        <div class="p-6 border-b border-ellas-nav bg-ellas-dark/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple font-orbitron font-bold">
                                    {{ $materia->ordem + 1 }}
                                </div>
                                <div>
                                    <h3 class="font-orbitron text-lg text-white font-bold">{{ $materia->titulo }}</h3>
                                    @if($materia->descricao)
                                        <p class="text-sm text-gray-400 mt-1">{{ $materia->descricao }}</p>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ $materia->materiais->count() }} materiais didáticos</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="abrirMaterialModal({{ $materia->id }})" class="px-4 py-2 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg text-xs font-bold transition-all">
                                    <i class="fas fa-plus mr-1"></i>MATERIAL
                                </button>
                                <button wire:click="abrirMateriaModal({{ $materia->id }})" class="px-4 py-2 bg-ellas-purple/20 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded-lg text-xs font-bold transition-all">
                                    <i class="fas fa-edit mr-1"></i>EDITAR
                                </button>
                                <button wire:click="excluirMateria({{ $materia->id }})" onclick="return confirm('Excluir esta matéria e todos os seus materiais?')" class="px-4 py-2 bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-xs font-bold transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Materiais da Matéria --}}
                        <div class="p-6">
                            @if($materia->materiais->count() > 0)
                                <div class="space-y-3">
                                    @foreach($materia->materiais->sortBy('ordem') as $material)
                                        <div class="flex items-center justify-between bg-ellas-dark/40 border border-ellas-nav rounded-lg p-4 hover:border-ellas-purple/30 transition-all">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-lg bg-ellas-nav flex items-center justify-center {{ $material->cor_tipo }}">
                                                    <i class="{{ $material->icone }}"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-white text-sm font-bold">{{ $material->titulo }}</h4>
                                                    <div class="flex items-center gap-3 mt-1">
                                                        <span class="px-2 py-0.5 bg-ellas-nav text-xs rounded uppercase font-bold {{ $material->cor_tipo }}">{{ $material->tipo }}</span>
                                                        @if($material->mentora)
                                                            <span class="text-xs text-gray-500">por {{ $material->mentora->nome }}</span>
                                                        @endif
                                                        @if($material->arquivo_nome)
                                                            <span class="text-xs text-gray-500"><i class="fas fa-paperclip mr-1"></i>{{ $material->arquivo_nome }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                @if($material->conteudo)
                                                    <a href="{{ $material->conteudo }}" target="_blank" class="p-2 bg-ellas-cyan/10 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded transition-all" title="Abrir">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @endif
                                                <button wire:click="abrirMaterialModal({{ $materia->id }}, {{ $material->id }})" class="p-2 bg-ellas-purple/10 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded transition-all" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="excluirMaterial({{ $material->id }})" onclick="return confirm('Excluir este material?')" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded transition-all" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-folder-open text-3xl text-gray-700 mb-2"></i>
                                    <p class="text-gray-500 text-sm italic">Nenhum material didático nesta matéria.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <i class="fas fa-book text-5xl text-gray-700 mb-4"></i>
                        <p class="text-gray-500 font-biorhyme italic">Nenhuma matéria cadastrada neste curso.</p>
                        <p class="text-gray-600 text-xs mt-2">Clique em "Nova Matéria" para começar a organizar o conteúdo.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal Criar/Editar Matéria --}}
    @if($showMateriaModal)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl max-w-lg w-full">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center">
                    <h3 class="font-orbitron text-lg text-white font-bold">
                        {{ $materia_id ? 'Editar Matéria' : 'Nova Matéria' }}
                    </h3>
                    <button wire:click="$set('showMateriaModal', false)" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Título da Matéria *</label>
                        <input type="text" wire:model="materia_titulo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Ex: Introdução ao Python">
                        @error('materia_titulo') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Descrição</label>
                        <textarea wire:model="materia_descricao" rows="3" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Descreva o conteúdo desta matéria..."></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Ordem</label>
                        <input type="number" wire:model="materia_ordem" min="0" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                    </div>
                </div>
                <div class="p-6 border-t border-ellas-nav flex justify-end gap-4">
                    <button wire:click="$set('showMateriaModal', false)" class="px-6 py-2 text-gray-400 hover:text-white font-orbitron text-xs uppercase">Cancelar</button>
                    <button wire:click="salvarMateria" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                        {{ $materia_id ? 'ATUALIZAR' : 'CRIAR' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Criar/Editar Material Didático --}}
    @if($showMaterialModal)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center sticky top-0 bg-ellas-card z-10">
                    <h3 class="font-orbitron text-lg text-white font-bold">
                        {{ $material_id ? 'Editar Material' : 'Novo Material Didático' }}
                    </h3>
                    <button wire:click="$set('showMaterialModal', false)" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Título *</label>
                        <input type="text" wire:model="material_titulo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Ex: Aula 1 - Variáveis">
                        @error('material_titulo') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Descrição</label>
                        <textarea wire:model="material_descricao" rows="2" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Descrição do material..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Tipo de Conteúdo *</label>
                            <select wire:model.live="material_tipo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                                <option value="video">Vídeo (URL)</option>
                                <option value="pdf">PDF (Upload)</option>
                                <option value="documento">Documento (Upload)</option>
                                <option value="link">Link Externo</option>
                                <option value="texto">Texto / Conteúdo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Ordem</label>
                            <input type="number" wire:model="material_ordem" min="0" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                        </div>
                    </div>

                    {{-- Campo dinâmico baseado no tipo --}}
                    @if(in_array($material_tipo, ['pdf', 'documento']))
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Upload de Arquivo</label>
                            <input type="file" wire:model="material_arquivo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:ring-ellas-purple focus:border-ellas-purple file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:bg-ellas-purple file:text-white file:font-bold file:text-xs">
                            <p class="text-xs text-gray-500 mt-1">Tamanho máximo: 50MB</p>
                            @if($material_conteudo && !$material_arquivo)
                                <p class="text-xs text-ellas-cyan mt-1"><i class="fas fa-paperclip mr-1"></i>Arquivo atual mantido</p>
                            @endif
                        </div>
                    @elseif($material_tipo === 'video')
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">URL do Vídeo</label>
                            <input type="url" wire:model="material_conteudo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="https://youtube.com/watch?v=...">
                        </div>
                    @elseif($material_tipo === 'link')
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">URL do Link</label>
                            <input type="url" wire:model="material_conteudo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="https://...">
                        </div>
                    @elseif($material_tipo === 'texto')
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Conteúdo de Texto</label>
                            <textarea wire:model="material_conteudo" rows="6" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Digite o conteúdo aqui..."></textarea>
                        </div>
                    @endif
                </div>
                <div class="p-6 border-t border-ellas-nav flex justify-end gap-4">
                    <button wire:click="$set('showMaterialModal', false)" class="px-6 py-2 text-gray-400 hover:text-white font-orbitron text-xs uppercase">Cancelar</button>
                    <button wire:click="salvarMaterial" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                        {{ $material_id ? 'ATUALIZAR' : 'ADICIONAR' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
