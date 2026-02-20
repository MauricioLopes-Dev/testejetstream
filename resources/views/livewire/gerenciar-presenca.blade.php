<div class="py-12 bg-ellas-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan mr-3">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">Gerenciar Presença</h3>
                        <p class="text-xs text-gray-400">Aula: {{ $aula->titulo }} | Curso: {{ $aula->curso->nome }}</p>
                    </div>
                </div>
                <a href="{{ route('mentora.cursos') }}" class="px-4 py-2 bg-ellas-nav text-white rounded-lg text-xs font-bold hover:bg-ellas-purple transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>VOLTAR
                </a>
            </div>

            <!-- Tabela de Alunas -->
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-ellas-dark/50">
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Aluna</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider text-center">Status</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ellas-nav">
                            @forelse($alunas as $aluna)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $aluna->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-ellas-cyan">{{ $aluna->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($presencas[$aluna->id] ?? false)
                                            <span class="px-3 py-1 bg-green-500/20 text-green-500 rounded-full text-[10px] font-bold uppercase">Presente</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-500/20 text-red-500 rounded-full text-[10px] font-bold uppercase">Falta</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button 
                                            wire:click="togglePresenca({{ $aluna->id }})" 
                                            class="px-4 py-2 rounded-lg text-xs font-bold transition-all border {{ ($presencas[$aluna->id] ?? false) ? 'bg-red-500/10 text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white' : 'bg-green-500/10 text-green-500 border-green-500/20 hover:bg-green-500 hover:text-white' }}"
                                        >
                                            {{ ($presencas[$aluna->id] ?? false) ? 'DAR FALTA' : 'DAR PRESENÇA' }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <p class="text-gray-500 italic font-biorhyme">Nenhuma aluna inscrita neste curso.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
