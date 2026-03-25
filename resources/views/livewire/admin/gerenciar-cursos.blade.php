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
                    <i class="fas fa-check-circle mr-2"></i>{{ session('message') }}
                </div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <div class="text-sm text-gray-400 font-biorhyme">
                    <i class="fas fa-graduation-cap mr-1"></i> Total: <strong class="text-white">{{ $cursos->count() }}</strong> cursos
                </div>
                <button wire:click="abrirModal" class="px-6 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-105 transition-all">
                    <i class="fas fa-plus mr-2"></i>CRIAR NOVO CURSO
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($cursos as $curso)
                    <div class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:border-ellas-purple transition-all relative">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-orbitron text-lg text-white font-bold leading-tight pr-2">{{ $curso->nome }}</h3>
                            @if($curso->ativo)
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-full whitespace-nowrap">Ativo</span>
                            @else
                                <span class="px-2 py-1 bg-gray-500/20 text-gray-400 text-xs rounded-full whitespace-nowrap">Inativo</span>
                            @endif
                        </div>

                        <div class="space-y-2 text-sm text-gray-300 mb-4">
                            <p><i class="fas fa-tag text-ellas-pink mr-2"></i>{{ $curso->nome_area }}</p>
                            <p><i class="fas fa-calendar text-ellas-cyan mr-2"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</p>
                            
                            {{-- Mentora principal --}}
                            @if($curso->mentora)
                                <p><i class="fas fa-user text-ellas-purple mr-2"></i>{{ $curso->mentora->nome }}</p>
                            @endif

                            {{-- Mentoras atribuídas --}}
                            @if($curso->mentoras->count() > 0)
                                <p><i class="fas fa-users text-ellas-purple mr-2"></i>{{ $curso->mentoras->count() }} mentora(s) atribuída(s)</p>
                            @endif

                            {{-- Vagas --}}
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-graduate text-ellas-cyan mr-0"></i>
                                <div class="flex-1">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>{{ $curso->inscritos->count() }}/{{ $curso->max_vagas }} vagas</span>
                                        <span class="{{ $curso->inscritos->count() >= $curso->max_vagas ? 'text-red-400' : 'text-green-400' }}">
                                            {{ $curso->max_vagas - $curso->inscritos->count() }} restantes
                                        </span>
                                    </div>
                                    <div class="w-full bg-ellas-nav rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all {{ $curso->inscritos->count() >= $curso->max_vagas ? 'bg-red-500' : 'bg-gradient-to-r from-ellas-purple to-ellas-pink' }}" 
                                             style="width: {{ min(100, ($curso->inscritos->count() / max(1, $curso->max_vagas)) * 100) }}%"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Duração --}}
                            @if($curso->duracao_horas)
                                <p><i class="fas fa-clock text-yellow-400 mr-2"></i>Duração: {{ $curso->duracao_formatada }}</p>
                            @endif
                        </div>

                        <div class="flex gap-2 mb-2">
                            <a href="{{ route('admin.cursos.materias', $curso->id) }}" class="flex-1 px-4 py-2 bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500 hover:text-white rounded-lg text-xs font-bold transition-all text-center">
                                <i class="fas fa-book mr-1"></i>MATÉRIAS
                            </a>
                            <button wire:click="verDetalhes({{ $curso->id }})" class="flex-1 px-4 py-2 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg text-xs font-bold transition-all">
                                DETALHES
                            </button>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="abrirModal({{ $curso->id }})" class="flex-1 px-4 py-2 bg-ellas-purple/20 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded-lg text-xs font-bold transition-all">
                                EDITAR
                            </button>
                            <button wire:click="excluir({{ $curso->id }})" onclick="return confirm('Tem certeza que deseja excluir este curso?')" class="px-4 py-2 bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-xs font-bold transition-all">
                                <i class="fas fa-trash"></i>
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

    <!-- Modal Criar/Editar Curso -->
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">
                                <i class="fas fa-users mr-1"></i> Máximo de Vagas *
                            </label>
                            <input type="number" wire:model="max_vagas" min="1" max="500" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" required>
                            @error('max_vagas') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">
                                <i class="fas fa-clock mr-1"></i> Duração (horas)
                            </label>
                            <input type="number" wire:model="duracao_horas" min="1" placeholder="Ex: 40" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                            @error('duracao_horas') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Mentora Principal</label>
                        <select wire:model="mentora_id" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple">
                            <option value="">Nenhuma (será atribuída depois)</option>
                            @foreach($mentoras as $mentora)
                                <option value="{{ $mentora->id }}">{{ $mentora->nome }} - {{ $mentora->areaAtuacao->nome ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">
                            <i class="fas fa-chalkboard-teacher mr-1"></i> Mentoras Atribuídas ao Curso
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Selecione uma ou mais mentoras para dar aulas neste curso.</p>
                        <div class="bg-ellas-dark border border-ellas-nav rounded-lg p-3 max-h-40 overflow-y-auto space-y-2">
                            @foreach($mentoras as $mentora)
                                <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer transition-colors">
                                    <input type="checkbox" wire:model="mentoras_ids" value="{{ $mentora->id }}" class="bg-ellas-dark border-ellas-nav text-ellas-purple focus:ring-ellas-purple rounded">
                                    <div>
                                        <span class="text-sm text-white font-bold">{{ $mentora->nome }}</span>
                                        <span class="text-xs text-gray-400 ml-2">{{ $mentora->areaAtuacao->nome ?? '' }}</span>
                                    </div>
                                </label>
                            @endforeach
                            @if($mentoras->isEmpty())
                                <p class="text-xs text-gray-500 italic text-center py-2">Nenhuma mentora aprovada disponível.</p>
                            @endif
                        </div>
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

    <!-- Modal Detalhes do Curso -->
    @if($showDetalhesModal && $cursoDetalhes)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center sticky top-0 bg-ellas-card z-10">
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">{{ $cursoDetalhes->nome }}</h3>
                        <p class="text-xs text-gray-400 mt-1">Detalhes completos do curso</p>
                    </div>
                    <button wire:click="fecharDetalhes" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    {{-- Info Geral --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-ellas-dark/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-orbitron font-bold text-ellas-purple">{{ $cursoDetalhes->inscritos->count() }}</div>
                            <div class="text-xs text-gray-400 mt-1">Inscritos</div>
                        </div>
                        <div class="bg-ellas-dark/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-orbitron font-bold text-ellas-cyan">{{ $cursoDetalhes->max_vagas }}</div>
                            <div class="text-xs text-gray-400 mt-1">Vagas Totais</div>
                        </div>
                        <div class="bg-ellas-dark/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-orbitron font-bold text-ellas-pink">{{ $cursoDetalhes->mentoras->count() }}</div>
                            <div class="text-xs text-gray-400 mt-1">Mentoras</div>
                        </div>
                        <div class="bg-ellas-dark/50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-orbitron font-bold text-yellow-400">{{ $cursoDetalhes->duracao_horas ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-400 mt-1">Horas</div>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    @if($cursoDetalhes->descricao)
                        <div>
                            <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-2">Descrição</h4>
                            <p class="text-gray-300 text-sm font-biorhyme">{{ $cursoDetalhes->descricao }}</p>
                        </div>
                    @endif

                    {{-- Período --}}
                    <div>
                        <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-2">Período</h4>
                        <p class="text-white text-sm">
                            <i class="fas fa-calendar text-ellas-cyan mr-2"></i>
                            {{ $cursoDetalhes->data_inicio->format('d/m/Y') }} até {{ $cursoDetalhes->data_fim->format('d/m/Y') }}
                        </p>
                    </div>

                    {{-- Mentoras Atribuídas --}}
                    <div>
                        <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-2">Mentoras Atribuídas</h4>
                        @if($cursoDetalhes->mentoras->count() > 0)
                            <div class="space-y-2">
                                @foreach($cursoDetalhes->mentoras as $m)
                                    <div class="flex items-center gap-3 bg-ellas-dark/50 rounded-lg p-3">
                                        <div class="w-8 h-8 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple text-xs font-bold">
                                            {{ substr($m->nome, 0, 2) }}
                                        </div>
                                        <div>
                                            <span class="text-white text-sm font-bold">{{ $m->nome }}</span>
                                            <span class="text-xs text-gray-400 ml-2">{{ $m->areaAtuacao->nome ?? '' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic">Nenhuma mentora atribuída.</p>
                        @endif
                    </div>

                    {{-- Alunas Inscritas --}}
                    <div>
                        <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-2">Alunas Inscritas ({{ $cursoDetalhes->inscritos->count() }})</h4>
                        @if($cursoDetalhes->inscritos->count() > 0)
                            <div class="bg-ellas-dark/50 rounded-lg p-3 max-h-40 overflow-y-auto space-y-2">
                                @foreach($cursoDetalhes->inscritos as $aluna)
                                    <div class="flex items-center gap-3 p-2 rounded hover:bg-white/5">
                                        <div class="w-6 h-6 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan text-[10px] font-bold">
                                            {{ substr($aluna->name, 0, 2) }}
                                        </div>
                                        <span class="text-white text-sm">{{ $aluna->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $aluna->email }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic">Nenhuma aluna inscrita ainda.</p>
                        @endif
                    </div>

                    {{-- Matérias --}}
                    <div>
                        <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-2">Matérias ({{ $cursoDetalhes->materias->count() }})</h4>
                        @if($cursoDetalhes->materias->count() > 0)
                            <div class="space-y-2">
                                @foreach($cursoDetalhes->materias as $materia)
                                    <div class="bg-ellas-dark/50 rounded-lg p-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-white text-sm font-bold">{{ $materia->titulo }}</span>
                                            <span class="text-xs text-gray-400">{{ $materia->materiais->count() }} materiais</span>
                                        </div>
                                        @if($materia->descricao)
                                            <p class="text-xs text-gray-400 mt-1">{{ $materia->descricao }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic">Nenhuma matéria cadastrada.</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 border-t border-ellas-nav flex justify-end">
                    <button wire:click="fecharDetalhes" class="px-6 py-2 bg-ellas-purple hover:bg-ellas-pink text-white rounded-lg font-orbitron text-xs uppercase transition-all">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
