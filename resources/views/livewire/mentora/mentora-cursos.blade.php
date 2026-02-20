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
                        <p class="text-xs text-gray-400">Gerencie suas aulas, presenças e materiais</p>
                    </div>
                </div>
            </div>

            <!-- Lista de Cursos -->
            <div class="p-6 space-y-8">
                @forelse($cursos as $curso)
                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-purple/30 transition-all">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div>
                                <h4 class="font-orbitron text-xl text-white font-bold">{{ $curso->nome }}</h4>
                                <p class="text-sm text-gray-400 font-biorhyme">{{ $curso->descricao }}</p>
                                <div class="flex gap-4 mt-2">
                                    <span class="text-[10px] text-ellas-cyan uppercase font-bold"><i class="fas fa-calendar mr-1"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-ellas-pink uppercase font-bold"><i class="fas fa-users mr-1"></i>{{ count($curso->inscritos) }} Alunas</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
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
                                                    <button wire:click="excluirAula({{ $aula->id }})" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded transition-all" title="Excluir">
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
</div>
