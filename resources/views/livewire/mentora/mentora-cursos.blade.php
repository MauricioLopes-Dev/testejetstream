<div class="py-12 bg-ellas-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple mr-3">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">Meus Cursos Atribuídos</h3>
                        <p class="text-xs text-gray-400">Gerencie suas aulas, matérias, presenças e materiais</p>
                    </div>
                </div>
            </div>

            @if(session('message'))
                <div class="mx-6 mt-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('message') }}
                </div>
            @endif

            <!-- Lista de Cursos -->
            <div class="p-6 space-y-8">
                @forelse($cursos as $curso)
                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-purple/30 transition-all">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <h4 class="font-orbitron text-xl text-white font-bold">{{ $curso->nome }}</h4>
                                <p class="text-sm text-gray-400 font-biorhyme">{{ $curso->descricao }}</p>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <span class="text-[10px] text-ellas-cyan uppercase font-bold"><i class="fas fa-calendar mr-1"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-ellas-pink uppercase font-bold"><i class="fas fa-users mr-1"></i>{{ count($curso->inscritos) }}/{{ $curso->max_vagas }} Alunas</span>
                                    @if($curso->duracao_horas)
                                        <span class="text-[10px] text-yellow-400 uppercase font-bold"><i class="fas fa-clock mr-1"></i>{{ $curso->duracao_formatada }}</span>
                                    @endif
                                    <span class="text-[10px] text-green-400 uppercase font-bold"><i class="fas fa-book mr-1"></i>{{ $curso->materias->count() }} Matérias</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="verMaterias({{ $curso->id }})" class="px-4 py-2 bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500 hover:text-white rounded-lg text-xs font-bold hover:scale-105 transition-all">
                                    <i class="fas fa-book mr-2"></i>MATÉRIAS
                                </button>
                                <button wire:click="abrirModalAula({{ $curso->id }})" class="px-4 py-2 bg-ellas-purple text-white rounded-lg text-xs font-bold hover:scale-105 transition-all">
                                    <i class="fas fa-plus mr-2"></i>NOVA AULA
                                </button>
                            </div>
                        </div>

                        <!-- Tabela de Aulas do Curso -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-ellas-dark/50">
                                        <th class="px-4 py-3 font-orbitron text-[10px] text-gray-400 uppercase tracking-wider">Aula</th>
                                        <th class="px-4 py-3 font-orbitron text-[10px] text-gray-400 uppercase tracking-wider">Tipo</th>
                                        <th class="px-4 py-3 font-orbitron text-[10px] text-gray-400 uppercase tracking-wider">Data</th>
                                        <th class="px-4 py-3 font-orbitron text-[10px] text-gray-400 uppercase tracking-wider text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-ellas-nav">
                                    @forelse($curso->aulas as $aula)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-4 py-3">
                                                <div class="text-sm font-bold text-white">{{ $aula->titulo }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 bg-ellas-nav text-ellas-cyan rounded text-[10px] font-bold uppercase">{{ $aula->tipo }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-xs text-gray-400">{{ $aula->data_aula ? $aula->data_aula->format('d/m/Y H:i') : 'N/A' }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('mentora.presenca', $aula->id) }}" class="p-2 bg-ellas-cyan/10 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded transition-all" title="Presença">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </a>
                                                    <button wire:click="abrirModalAula({{ $curso->id }}, {{ $aula->id }})" class="p-2 bg-ellas-purple/10 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded transition-all" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="excluirAula({{ $aula->id }})" onclick="return confirm('Excluir esta aula?')" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded transition-all" title="Excluir">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic text-xs">Nenhuma aula cadastrada para este curso.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-graduation-cap text-5xl text-gray-700 mb-4"></i>
                        <p class="text-gray-500 font-biorhyme italic">Nenhum curso atribuído ainda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal de Aula -->
    @if($showModalAula)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center">
                    <h3 class="font-orbitron text-lg text-white font-bold">{{ $aula_id ? 'Editar Aula' : 'Nova Aula' }}</h3>
                    <button wire:click="$set('showModalAula', false)" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    <div>
                        <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Título da Aula</label>
                        <input type="text" wire:model.defer="titulo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:border-ellas-cyan focus:ring-0">
                    </div>
                    <div>
                        <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Descrição</label>
                        <textarea wire:model.defer="descricao" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:border-ellas-cyan focus:ring-0" rows="3"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Tipo de Conteúdo</label>
                            <select wire:model="tipo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:border-ellas-cyan focus:ring-0">
                                <option value="video">Vídeo (URL)</option>
                                <option value="pdf">PDF (Upload)</option>
                                <option value="link_meet">Link do Meet</option>
                                <option value="texto">Texto</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Data/Hora (Opcional)</label>
                            <input type="datetime-local" wire:model.defer="data_aula" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:border-ellas-cyan focus:ring-0">
                        </div>
                    </div>
                    <div>
                        <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Conteúdo / Link</label>
                        @if($tipo === 'pdf')
                            <input type="file" wire:model="arquivo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:border-ellas-cyan focus:ring-0">
                            @if($conteudo) <p class="text-[10px] text-ellas-cyan mt-1">Arquivo atual: {{ $conteudo }}</p> @endif
                        @else
                            <input type="text" wire:model.defer="conteudo" placeholder="URL ou Link" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 focus:border-ellas-cyan focus:ring-0">
                        @endif
                    </div>
                </div>
                <div class="p-6 border-t border-ellas-nav flex justify-end gap-4">
                    <button wire:click="$set('showModalAula', false)" class="px-6 py-2 text-gray-400 hover:text-white font-bold text-xs uppercase">Cancelar</button>
                    <button wire:click="salvarAula" class="px-6 py-2 bg-gradient-to-r from-ellas-purple to-ellas-pink text-white rounded-lg font-bold text-xs uppercase hover:scale-105 transition-all">
                        {{ $aula_id ? 'ATUALIZAR' : 'CRIAR AULA' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Matérias do Curso -->
    @if($showMateriasModal && $cursoMaterias)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center sticky top-0 bg-ellas-card z-10">
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">Matérias - {{ $cursoMaterias->nome }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Adicione materiais didáticos (vídeos, PDFs, textos) às matérias</p>
                    </div>
                    <button wire:click="fecharMaterias" class="text-gray-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="p-6 space-y-6">
                    @forelse($cursoMaterias->materias->sortBy('ordem') as $materia)
                        <div class="bg-ellas-dark/40 border border-ellas-nav rounded-xl overflow-hidden">
                            <div class="p-4 border-b border-ellas-nav flex justify-between items-center bg-ellas-dark/30">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple font-orbitron text-sm font-bold">
                                        {{ $materia->ordem + 1 }}
                                    </div>
                                    <div>
                                        <h4 class="font-orbitron text-white font-bold">{{ $materia->titulo }}</h4>
                                        @if($materia->descricao)
                                            <p class="text-xs text-gray-400">{{ $materia->descricao }}</p>
                                        @endif
                                    </div>
                                </div>
                                <button wire:click="abrirMaterialModal({{ $materia->id }})" class="px-3 py-1.5 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg text-xs font-bold transition-all">
                                    <i class="fas fa-plus mr-1"></i>MATERIAL
                                </button>
                            </div>

                            <div class="p-4">
                                @if($materia->materiais->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($materia->materiais->sortBy('ordem') as $material)
                                            <div class="flex items-center justify-between bg-ellas-dark/50 rounded-lg p-3">
                                                <div class="flex items-center gap-3">
                                                    <i class="{{ $material->icone }} {{ $material->cor_tipo }}"></i>
                                                    <div>
                                                        <span class="text-white text-sm font-bold">{{ $material->titulo }}</span>
                                                        <span class="text-xs text-gray-500 ml-2 uppercase">{{ $material->tipo }}</span>
                                                        @if($material->mentora)
                                                            <span class="text-xs text-gray-600 ml-2">por {{ $material->mentora->nome }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex gap-1">
                                                    @if($material->conteudo)
                                                        <a href="{{ $material->conteudo }}" target="_blank" class="p-1.5 text-ellas-cyan hover:bg-ellas-cyan/20 rounded transition-all text-xs">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @endif
                                                    <button wire:click="abrirMaterialModal({{ $materia->id }}, {{ $material->id }})" class="p-1.5 text-ellas-purple hover:bg-ellas-purple/20 rounded transition-all text-xs">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="excluirMaterial({{ $material->id }})" onclick="return confirm('Excluir?')" class="p-1.5 text-red-500 hover:bg-red-500/20 rounded transition-all text-xs">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-center text-gray-500 text-xs italic py-4">Nenhum material nesta matéria. Clique em "+ Material" para adicionar.</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-book text-4xl text-gray-700 mb-3"></i>
                            <p class="text-gray-500 italic">Nenhuma matéria cadastrada neste curso.</p>
                            <p class="text-gray-600 text-xs mt-1">O administrador precisa criar as matérias primeiro.</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-6 border-t border-ellas-nav flex justify-end">
                    <button wire:click="fecharMaterias" class="px-6 py-2 bg-ellas-purple hover:bg-ellas-pink text-white rounded-lg font-orbitron text-xs uppercase transition-all">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Material Didático (Mentora) -->
    @if($showMaterialModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center">
                    <h3 class="font-orbitron text-lg text-white font-bold">
                        {{ $material_id ? 'Editar Material' : 'Novo Material Didático' }}
                    </h3>
                    <button wire:click="$set('showMaterialModal', false)" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Título *</label>
                        <input type="text" wire:model="material_titulo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Ex: Aula 1 - Variáveis">
                        @error('material_titulo') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Descrição</label>
                        <textarea wire:model="material_descricao" rows="2" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Tipo *</label>
                            <select wire:model.live="material_tipo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                                <option value="video">Vídeo (URL)</option>
                                <option value="pdf">PDF (Upload)</option>
                                <option value="documento">Documento (Upload)</option>
                                <option value="link">Link Externo</option>
                                <option value="texto">Texto</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Ordem</label>
                            <input type="number" wire:model="material_ordem" min="0" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                        </div>
                    </div>

                    @if(in_array($material_tipo, ['pdf', 'documento']))
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Upload de Arquivo</label>
                            <input type="file" wire:model="material_arquivo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-2 px-4 file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:bg-ellas-purple file:text-white file:font-bold file:text-xs">
                        </div>
                    @elseif($material_tipo === 'video')
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">URL do Vídeo</label>
                            <input type="url" wire:model="material_conteudo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="https://youtube.com/...">
                        </div>
                    @elseif($material_tipo === 'link')
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">URL do Link</label>
                            <input type="url" wire:model="material_conteudo" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="https://...">
                        </div>
                    @elseif($material_tipo === 'texto')
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Conteúdo</label>
                            <textarea wire:model="material_conteudo" rows="6" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple"></textarea>
                        </div>
                    @endif
                </div>
                <div class="p-6 border-t border-ellas-nav flex justify-end gap-4">
                    <button wire:click="$set('showMaterialModal', false)" class="px-6 py-2 text-gray-400 hover:text-white font-bold text-xs uppercase">Cancelar</button>
                    <button wire:click="salvarMaterial" class="px-6 py-2 bg-gradient-to-r from-ellas-purple to-ellas-pink text-white rounded-lg font-bold text-xs uppercase hover:scale-105 transition-all">
                        {{ $material_id ? 'ATUALIZAR' : 'ADICIONAR' }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
