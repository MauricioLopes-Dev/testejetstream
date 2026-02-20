<div class="py-12 bg-ellas-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('message'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                {{ session('message') }}
            </div>
        @endif

        <!-- Depoimentos Pendentes de Aprovação -->
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden mb-10">
            <div class="p-6 border-b border-ellas-nav bg-gradient-to-r from-yellow-500/20 to-orange-500/20">
                <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                    <i class="fas fa-hourglass-half text-yellow-400 mr-3"></i>
                    DEPOIMENTOS PENDENTES DE APROVAÇÃO
                </h3>
                <p class="text-xs text-gray-400 mt-2">{{ $depoimentosPendentes->count() }} depoimento(s) aguardando revisão</p>
            </div>

            <div class="p-6">
                @forelse($depoimentosPendentes as $depoimento)
                    <div class="mb-6 p-6 bg-ellas-dark/50 border border-yellow-500/30 rounded-xl hover:border-yellow-500/60 transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start flex-1">
                                @if($depoimento->photo_url)
                                    <img src="{{ $depoimento->photo_url }}" class="w-12 h-12 rounded-full mr-4 object-cover border border-yellow-500/30">
                                @else
                                    <div class="w-12 h-12 rounded-full mr-4 bg-gradient-to-r from-ellas-purple to-ellas-pink flex items-center justify-center text-white font-bold">
                                        {{ substr($depoimento->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-orbitron text-white font-bold">{{ $depoimento->name }}</h4>
                                    <p class="text-xs text-ellas-cyan">{{ $depoimento->role }}</p>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-500">{{ $depoimento->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        <p class="text-gray-300 text-sm font-biorhyme mb-4 italic">{{ $depoimento->content }}</p>

                        <div class="flex gap-3">
                            <button 
                                wire:click="aprovar({{ $depoimento->id }})" 
                                class="flex-1 px-4 py-2 bg-green-500/20 text-green-400 hover:bg-green-500 hover:text-white border border-green-500/30 rounded-lg text-xs font-bold transition-all"
                            >
                                <i class="fas fa-check mr-2"></i>APROVAR
                            </button>
                            <button 
                                wire:click="rejeitar({{ $depoimento->id }})" 
                                onclick="return confirm('Tem certeza que deseja rejeitar este depoimento?')"
                                class="flex-1 px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white border border-red-500/30 rounded-lg text-xs font-bold transition-all"
                            >
                                <i class="fas fa-times mr-2"></i>REJEITAR
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-check-circle text-5xl text-green-500/30 mb-4"></i>
                        <p class="text-gray-500 italic font-biorhyme">Nenhum depoimento pendente de aprovação.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Depoimentos Aprovados -->
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-ellas-nav bg-gradient-to-r from-green-500/20 to-ellas-cyan/20">
                <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                    <i class="fas fa-star text-green-400 mr-3"></i>
                    DEPOIMENTOS APROVADOS
                </h3>
                <p class="text-xs text-gray-400 mt-2">{{ $depoimentosAprovados->count() }} depoimento(s) publicado(s)</p>
            </div>

            <div class="p-6">
                @forelse($depoimentosAprovados as $depoimento)
                    <div class="mb-6 p-6 bg-ellas-dark/50 border border-green-500/30 rounded-xl hover:border-green-500/60 transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start flex-1">
                                @if($depoimento->photo_url)
                                    <img src="{{ $depoimento->photo_url }}" class="w-12 h-12 rounded-full mr-4 object-cover border border-green-500/30">
                                @else
                                    <div class="w-12 h-12 rounded-full mr-4 bg-gradient-to-r from-ellas-purple to-ellas-pink flex items-center justify-center text-white font-bold">
                                        {{ substr($depoimento->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-orbitron text-white font-bold">{{ $depoimento->name }}</h4>
                                    <p class="text-xs text-ellas-cyan">{{ $depoimento->role }}</p>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-500">{{ $depoimento->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        <p class="text-gray-300 text-sm font-biorhyme mb-4 italic">{{ $depoimento->content }}</p>

                        <button 
                            wire:click="rejeitar({{ $depoimento->id }})" 
                            onclick="return confirm('Tem certeza que deseja remover este depoimento?')"
                            class="px-4 py-2 bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white border border-red-500/30 rounded-lg text-xs font-bold transition-all"
                        >
                            <i class="fas fa-trash mr-2"></i>REMOVER
                        </button>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-5xl text-gray-700/30 mb-4"></i>
                        <p class="text-gray-500 italic font-biorhyme">Nenhum depoimento aprovado ainda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
