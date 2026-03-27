<div>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Meus</span> Cursos
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            @if(session('message'))
                <div class="p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('message') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-500/20 border border-red-500/50 text-red-400 rounded-lg font-biorhyme text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Meus Cursos -->
            <div>
                <h3 class="font-orbitron text-xl text-white font-bold mb-6 flex items-center">
                    <i class="fas fa-graduation-cap text-ellas-purple mr-3"></i>
                    CURSOS INSCRITOS
                </h3>

                @if($meusCursos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($meusCursos as $curso)
                            <div class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:border-ellas-purple transition-all">
                                <h4 class="font-orbitron text-lg text-white font-bold mb-3">{{ $curso->nome }}</h4>
                                
                                <div class="space-y-2 text-sm text-gray-300 mb-4">
                                    <p><i class="fas fa-tag text-ellas-pink mr-2"></i>{{ $curso->nome_area }}</p>
                                    <p><i class="fas fa-calendar text-ellas-cyan mr-2"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</p>
                                    @if($curso->mentora)
                                        <p><i class="fas fa-user text-ellas-purple mr-2"></i>{{ $curso->mentora->nome }}</p>
                                    @endif
                                    @if($curso->duracao_horas)
                                        <p><i class="fas fa-clock text-yellow-400 mr-2"></i>{{ $curso->duracao_formatada }}</p>
                                    @endif
                                    <p><i class="fas fa-book text-ellas-cyan mr-2"></i>{{ $curso->aulas->count() }} aulas | {{ $curso->materias->count() }} matérias</p>
                                </div>

                                <button wire:click="verCurso({{ $curso->id }})" class="w-full px-4 py-2 bg-gradient-to-r from-ellas-purple to-ellas-pink text-white rounded-lg font-orbitron text-xs font-bold hover:scale-105 transition-all">
                                    VER CONTEÚDO
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-ellas-card border border-ellas-nav rounded-xl p-12 text-center">
                        <i class="fas fa-graduation-cap text-5xl text-gray-700 mb-4"></i>
                        <p class="text-gray-500 font-biorhyme italic">Você ainda não está inscrita em nenhum curso.</p>
                    </div>
                @endif
            </div>

            <!-- Cursos Disponíveis -->
            <div>
                <h3 class="font-orbitron text-xl text-white font-bold mb-6 flex items-center">
                    <i class="fas fa-plus-circle text-ellas-cyan mr-3"></i>
                    CURSOS DISPONÍVEIS
                </h3>

                @if($cursosDisponiveis->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($cursosDisponiveis as $curso)
                            <div class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:border-ellas-cyan transition-all">
                                <h4 class="font-orbitron text-lg text-white font-bold mb-3">{{ $curso->nome }}</h4>
                                
                                <div class="space-y-2 text-sm text-gray-300 mb-4">
                                    <p><i class="fas fa-tag text-ellas-pink mr-2"></i>{{ $curso->nome_area }}</p>
                                    <p><i class="fas fa-calendar text-ellas-cyan mr-2"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</p>
                                    @if($curso->mentora)
                                        <p><i class="fas fa-user text-ellas-purple mr-2"></i>{{ $curso->mentora->nome }}</p>
                                    @endif
                                    @if($curso->duracao_horas)
                                        <p><i class="fas fa-clock text-yellow-400 mr-2"></i>{{ $curso->duracao_formatada }}</p>
                                    @endif
                                    @if($curso->descricao)
                                        <p class="text-xs text-gray-400 mt-2">{{ Str::limit($curso->descricao, 100) }}</p>
                                    @endif

                                    {{-- Indicador de Vagas --}}
                                    <div class="pt-2">
                                        @php
                                            $inscritos = $curso->inscritos->count();
                                            $vagas = $curso->max_vagas;
                                            $restantes = $vagas - $inscritos;
                                        @endphp
                                        <div class="flex justify-between text-xs mb-1">
                                            <span>{{ $inscritos }}/{{ $vagas }} vagas</span>
                                            <span class="{{ $restantes <= 0 ? 'text-red-400' : ($restantes <= 5 ? 'text-yellow-400' : 'text-green-400') }}">
                                                {{ $restantes > 0 ? $restantes . ' restantes' : 'Esgotado' }}
                                            </span>
                                        </div>
                                        <div class="w-full bg-ellas-nav rounded-full h-2">
                                            <div class="h-2 rounded-full transition-all {{ $restantes <= 0 ? 'bg-red-500' : 'bg-gradient-to-r from-ellas-purple to-ellas-pink' }}" 
                                                 style="width: {{ min(100, ($inscritos / max(1, $vagas)) * 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>

                                @if($restantes > 0)
                                    <button wire:click="inscrever({{ $curso->id }})" class="w-full px-4 py-2 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg font-orbitron text-xs font-bold transition-all">
                                        INSCREVER-SE
                                    </button>
                                @else
                                    <div class="w-full px-4 py-2 bg-red-500/10 text-red-400 rounded-lg font-orbitron text-xs font-bold text-center cursor-not-allowed">
                                        <i class="fas fa-lock mr-1"></i> VAGAS ESGOTADAS
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-ellas-card border border-ellas-nav rounded-xl p-12 text-center">
                        <i class="fas fa-check-circle text-5xl text-green-600 mb-4"></i>
                        <p class="text-gray-500 font-biorhyme italic">Você já está inscrita em todos os cursos disponíveis!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Conteúdo do Curso -->
    @if($showModal && $cursoSelecionado)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center sticky top-0 bg-ellas-card z-10">
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">{{ $cursoSelecionado->nome }}</h3>
                        <div class="flex gap-4 mt-1">
                            <span class="text-xs text-gray-400">{{ $cursoSelecionado->aulas->count() }} aulas</span>
                            <span class="text-xs text-gray-400">{{ $cursoSelecionado->materias->count() }} matérias</span>
                            @if($cursoSelecionado->duracao_horas)
                                <span class="text-xs text-yellow-400">{{ $cursoSelecionado->duracao_formatada }}</span>
                            @endif
                        </div>
                    </div>
                    <button wire:click="fecharModal" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6 space-y-8">
                    {{-- Mentoras do Curso --}}
                    @if($cursoSelecionado->mentoras->count() > 0)
                        <div>
                            <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-3">Mentoras</h4>
                            <div class="flex flex-wrap gap-3">
                                @foreach($cursoSelecionado->mentoras as $m)
                                    <div class="flex items-center gap-2 bg-ellas-dark/50 rounded-lg px-3 py-2">
                                        <div class="w-6 h-6 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple text-[10px] font-bold">
                                            {{ substr($m->nome, 0, 2) }}
                                        </div>
                                        <span class="text-white text-sm">{{ $m->nome }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Matérias e Materiais --}}
                    @if($cursoSelecionado->materias->count() > 0)
                        <div>
                            <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-3">Matérias e Materiais Didáticos</h4>
                            <div class="space-y-4">
                                @foreach($cursoSelecionado->materias->sortBy('ordem') as $materia)
                                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-xl overflow-hidden">
                                        <div class="p-4 border-b border-ellas-nav bg-ellas-dark/30">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple font-orbitron text-sm font-bold">
                                                    {{ $materia->ordem + 1 }}
                                                </div>
                                                <div>
                                                    <h5 class="font-orbitron text-white font-bold">{{ $materia->titulo }}</h5>
                                                    @if($materia->descricao)
                                                        <p class="text-xs text-gray-400">{{ $materia->descricao }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 space-y-2">
                                            @forelse($materia->materiais->sortBy('ordem') as $material)
                                                <div class="flex items-center justify-between bg-ellas-dark/50 rounded-lg p-3">
                                                    <div class="flex items-center gap-3">
                                                        <i class="{{ $material->icone }} {{ $material->cor_tipo }}"></i>
                                                        <div>
                                                            <span class="text-white text-sm font-bold">{{ $material->titulo }}</span>
                                                            <span class="text-xs text-gray-500 ml-2 uppercase">{{ $material->tipo }}</span>
                                                        </div>
                                                    </div>
                                                    @if($material->conteudo)
                                                        <a href="{{ $material->conteudo }}" target="_blank" class="px-3 py-1.5 bg-ellas-purple/20 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded-lg text-xs font-bold transition-all">
                                                            <i class="fas fa-external-link-alt mr-1"></i>ACESSAR
                                                        </a>
                                                    @endif
                                                </div>
                                            @empty
                                                <p class="text-center text-gray-500 text-xs italic py-2">Nenhum material disponível ainda.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Aulas --}}
                    @if($cursoSelecionado->aulas->count() > 0)
                        <div>
                            <h4 class="font-orbitron text-sm text-gray-400 uppercase mb-3">Aulas</h4>
                            <div class="space-y-3">
                                @foreach($cursoSelecionado->aulas as $aula)
                                    <div class="bg-ellas-dark/50 border border-ellas-nav rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <h5 class="font-orbitron text-white font-bold">{{ $aula->titulo }}</h5>
                                            @if($aula->tipo === 'video')
                                                <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs rounded-full"><i class="fas fa-video mr-1"></i>Vídeo</span>
                                            @elseif($aula->tipo === 'pdf')
                                                <span class="px-2 py-1 bg-blue-500/20 text-blue-400 text-xs rounded-full"><i class="fas fa-file-pdf mr-1"></i>PDF</span>
                                            @elseif($aula->tipo === 'link_meet')
                                                <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-full"><i class="fas fa-video mr-1"></i>Ao Vivo</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-500/20 text-gray-400 text-xs rounded-full"><i class="fas fa-file-alt mr-1"></i>Texto</span>
                                            @endif
                                        </div>

                                        @if($aula->descricao)
                                            <p class="text-sm text-gray-400 mb-3">{{ $aula->descricao }}</p>
                                        @endif

                                        @if($aula->data_aula)
                                            <p class="text-xs text-ellas-cyan mb-2"><i class="fas fa-clock mr-1"></i>{{ $aula->data_aula->format('d/m/Y H:i') }}</p>
                                        @endif

                                        @if($aula->conteudo)
                                            <a href="{{ $aula->conteudo }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-ellas-purple/20 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded-lg text-xs font-bold transition-all">
                                                <i class="fas fa-external-link-alt mr-2"></i>ACESSAR CONTEÚDO
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($cursoSelecionado->aulas->count() == 0 && $cursoSelecionado->materias->count() == 0)
                        <div class="text-center py-12">
                            <i class="fas fa-book-open text-5xl text-gray-700 mb-4"></i>
                            <p class="text-gray-500 font-biorhyme italic">Nenhum conteúdo disponível ainda.</p>
                        </div>
                    @endif
                </div>

                <div class="p-6 border-t border-ellas-nav flex justify-between">
                    <button wire:click="cancelarInscricao({{ $cursoSelecionado->id }})" onclick="return confirm('Tem certeza que deseja cancelar sua inscrição?')" class="px-6 py-2 bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white rounded-lg font-orbitron text-xs uppercase transition-all">
                        CANCELAR INSCRIÇÃO
                    </button>
                    <button wire:click="fecharModal" class="px-6 py-2 bg-ellas-purple hover:bg-ellas-pink text-white rounded-lg font-orbitron text-xs uppercase transition-all">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
