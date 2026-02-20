<div class="py-12 bg-ellas-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan mr-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">Minhas Alunas</h3>
                        <p class="text-xs text-gray-400">Acompanhe o progresso das alunas inscritas em seus cursos</p>
                    </div>
                </div>
            </div>

            <!-- Tabela de Alunas -->
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-ellas-dark/50">
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Aluna</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Cursos Matriculados</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ellas-nav">
                            @forelse($alunas as $aluna)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $aluna->profile_photo_url }}" class="w-8 h-8 rounded-full mr-3 object-cover border border-ellas-purple/30">
                                            <div>
                                                <div class="font-bold text-white">{{ $aluna->name }}</div>
                                                <div class="text-xs text-ellas-cyan">{{ $aluna->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($aluna->cursos as $curso)
                                                <span class="px-2 py-1 bg-ellas-nav text-ellas-pink rounded text-[10px] font-bold uppercase">{{ $curso->nome }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('chat.duvidas', ['alunaId' => $aluna->id]) }}" class="p-2 bg-ellas-purple/10 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded transition-all" title="Chat">
                                                <i class="fas fa-comments"></i>
                                            </a>
                                            <button wire:click="verDetalhes({{ $aluna->id }})" class="p-2 bg-ellas-cyan/10 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded transition-all" title="Detalhes">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <p class="text-gray-500 italic font-biorhyme">Nenhuma aluna matriculada em seus cursos ainda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center">
                    <h3 class="font-orbitron text-lg text-white font-bold">Detalhes da Aluna</h3>
                    <button wire:click="fecharModal" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex flex-col items-center">
                        <img src="{{ $alunaDetalhes->profile_photo_url }}" class="w-24 h-24 rounded-full mb-4 object-cover border-2 border-ellas-purple">
                        <h4 class="font-orbitron text-xl text-white font-bold">{{ $alunaDetalhes->name }}</h4>
                        <p class="text-ellas-cyan font-biorhyme">{{ $alunaDetalhes->email }}</p>
                        <p class="text-gray-400 text-sm mt-1">{{ $alunaDetalhes->telefone ?? 'Telefone não informado' }}</p>
                    </div>
                    
                    <div>
                        <h5 class="font-orbitron text-xs text-gray-400 uppercase mb-3 border-b border-ellas-nav pb-2">Cursos Matriculados</h5>
                        <ul class="space-y-2">
                            @foreach($alunaDetalhes->cursos as $curso)
                                <li class="flex justify-between items-center bg-ellas-dark/50 p-3 rounded-lg border border-ellas-nav">
                                    <span class="text-white text-sm font-bold">{{ $curso->nome }}</span>
                                    <span class="text-[10px] text-ellas-pink uppercase font-bold">Inscrita em {{ $curso->pivot->inscrito_em->format('d/m/Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="p-6 border-t border-ellas-nav flex justify-end">
                    <button wire:click="fecharModal" class="px-6 py-2 bg-ellas-nav text-white rounded-lg font-bold text-xs uppercase hover:bg-ellas-purple transition-all">Fechar</button>
                </div>
            </div>
        </div>
    @endif
</div>
