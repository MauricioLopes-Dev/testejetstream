<div>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Aprovações</span> Pendentes
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @if(session('message'))
                <div class="p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav bg-gradient-to-r from-ellas-purple/10 to-transparent">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-user-plus text-ellas-pink mr-3"></i>
                        NOVOS CADASTROS DE MENTORAS ({{ $mentorasPendentes->count() }})
                    </h3>
                    <p class="text-xs text-gray-400 mt-1 ml-8">Mentoras que se cadastraram externamente e aguardam liberação.</p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-ellas-dark/50 text-gray-400 font-orbitron text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4">Mentora</th>
                                <th class="px-6 py-4">Área de Atuação</th>
                                <th class="px-6 py-4">Experiência</th>
                                <th class="px-6 py-4 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ellas-nav text-gray-300 text-sm">
                            @forelse($mentorasPendentes as $mentora)
                                <tr class="hover:bg-white/5 transition duration-200">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $mentora->nome }}</div>
                                        <div class="text-xs text-ellas-cyan">{{ $mentora->email }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            <i class="fab fa-whatsapp mr-1"></i> {{ $mentora->telefone }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-ellas-nav rounded text-xs text-gray-200">
                                            {{ $mentora->areaAtuacao->nome ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-ellas-purple/20 text-ellas-purple rounded-full text-xs font-bold uppercase border border-ellas-purple/30">
                                            {{ $mentora->nivel_experiencia }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-3">
                                            <button 
                                                wire:click="aprovarMentora({{ $mentora->id }})" 
                                                onclick="return confirm('Deseja aprovar esta mentora? Ela receberá um e-mail de confirmação.')"
                                                class="px-4 py-2 bg-green-500/20 text-green-400 hover:bg-green-500 hover:text-white rounded-lg transition font-bold text-xs flex items-center gap-2 border border-green-500/30">
                                                <i class="fas fa-check"></i> APROVAR
                                            </button>
                                            
                                            <button 
                                                wire:click="reprovarMentora({{ $mentora->id }})" 
                                                onclick="return confirm('Deseja reprovar este cadastro?')"
                                                class="px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition font-bold text-xs flex items-center gap-2 border border-red-500/30">
                                                <i class="fas fa-times"></i> REPROVAR
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-clipboard-check text-4xl mb-3 opacity-50"></i>
                                            <p class="font-biorhyme italic">Nenhuma mentora aguardando aprovação no momento.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-xl overflow-hidden opacity-90 hover:opacity-100 transition-opacity">
                <div class="p-6 border-b border-ellas-nav bg-gradient-to-r from-ellas-cyan/10 to-transparent">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-hand-holding-heart text-ellas-cyan mr-3"></i>
                        ALUNAS SOLICITANDO MENTORIA ({{ $alunasCandidatas->count() }})
                    </h3>
                    <p class="text-xs text-gray-400 mt-1 ml-8">Alunas já cadastradas que solicitaram tornar-se mentoras pelo perfil.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-ellas-dark/50 text-gray-400 font-orbitron text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4">Aluna</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Solicitado em</th>
                                <th class="px-6 py-4 text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ellas-nav text-gray-300 text-sm">
                            @forelse($alunasCandidatas as $aluna)
                                <tr class="hover:bg-white/5 transition duration-200">
                                    <td class="px-6 py-4 font-bold text-white flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan text-xs">
                                            {{ substr($aluna->name, 0, 2) }}
                                        </div>
                                        {{ $aluna->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">{{ $aluna->email }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">
                                        {{ $aluna->updated_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button 
                                            wire:click="aprovarAluna({{ $aluna->id }})" 
                                            class="px-4 py-2 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg transition font-bold text-xs border border-ellas-cyan/30">
                                            <i class="fas fa-tasks mr-2"></i> PROCESSAR PEDIDO
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-500 italic">
                                        Nenhuma solicitação de upgrade de aluna.
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