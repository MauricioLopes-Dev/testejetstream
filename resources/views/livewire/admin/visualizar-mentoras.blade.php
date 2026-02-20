<div>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Gerenciar</span> Mentoras
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('message'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-crown text-ellas-pink mr-3"></i>
                        MENTORAS APROVADAS ({{ $mentoras->total() }})
                    </h3>

                    <div class="w-full md:w-1/3 relative">
                        <input 
                            wire:model.live.debounce.300ms="search" 
                            type="text" 
                            placeholder="Buscar por nome ou email..." 
                            class="w-full bg-ellas-dark border border-ellas-nav text-white rounded-lg pl-10 pr-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple placeholder-gray-500 text-sm"
                        >
                        <i class="fas fa-search absolute left-3 top-3 text-gray-500 text-xs"></i>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-ellas-dark/50">
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Área</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Experiência</th>
                                <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ellas-nav">
                            @forelse($mentoras as $mentora)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white">{{ $mentora->nome }}</div>
                                        <div class="text-xs text-ellas-cyan">{{ $mentora->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-300">{{ $mentora->areaAtuacao->nome ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-ellas-pink/20 text-ellas-pink rounded-full text-xs font-bold uppercase">
                                            {{ $mentora->nivel_experiencia }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <button wire:click="verDetalhes({{ $mentora->id }})" class="px-4 py-2 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg text-xs font-bold transition-all">
                                                VER
                                            </button>
                                            <button wire:click="excluir({{ $mentora->id }})" onclick="return confirm('Tem certeza que deseja excluir esta mentora?')" class="px-4 py-2 bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-xs font-bold transition-all">
                                                EXCLUIR
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-20">
                                        <i class="fas fa-search text-5xl text-gray-700 mb-4"></i>
                                        <p class="text-gray-500 font-biorhyme italic">Nenhuma mentora encontrada.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($mentoras->hasPages())
                    <div class="p-4 border-t border-ellas-nav bg-ellas-dark/30">
                        {{ $mentoras->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($showModal && $mentoraDetalhes)
        <div class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-ellas-nav flex justify-between items-center sticky top-0 bg-ellas-card z-10">
                    <h3 class="font-orbitron text-lg text-white font-bold">DETALHES DA MENTORA</h3>
                    <button wire:click="fecharModal" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="font-orbitron text-sm text-ellas-pink uppercase mb-3">Informações Básicas</h4>
                        <div class="space-y-2 text-sm">
                            <p><span class="text-gray-400">Nome:</span> <span class="text-white font-bold">{{ $mentoraDetalhes->nome }}</span></p>
                            <p><span class="text-gray-400">Email:</span> <span class="text-ellas-cyan">{{ $mentoraDetalhes->email }}</span></p>
                            <p><span class="text-gray-400">Telefone:</span> <span class="text-white">{{ $mentoraDetalhes->telefone ?? 'Não informado' }}</span></p>
                            <p><span class="text-gray-400">Área:</span> <span class="text-white">{{ $mentoraDetalhes->areaAtuacao->nome ?? 'N/A' }}</span></p>
                            <p><span class="text-gray-400">Experiência:</span> <span class="text-ellas-pink font-bold uppercase">{{ $mentoraDetalhes->nivel_experiencia }}</span></p>
                            <p><span class="text-gray-400">Aprovada em:</span> <span class="text-white">{{ $mentoraDetalhes->email_verificado_at?->format('d/m/Y H:i') ?? 'N/A' }}</span></p>
                        </div>
                    </div>

                    @if($mentoraDetalhes->sobre_mim)
                        <div>
                            <h4 class="font-orbitron text-sm text-ellas-purple uppercase mb-3">Sobre</h4>
                            <p class="text-gray-300 text-sm">{{ $mentoraDetalhes->sobre_mim }}</p>
                        </div>
                    @endif

                    <div>
                        <h4 class="font-orbitron text-sm text-ellas-cyan uppercase mb-3">Links</h4>
                        <div class="space-y-2 text-sm">
                            @if($mentoraDetalhes->github_url)
                                <p><i class="fab fa-github text-gray-400 mr-2"></i><a href="{{ $mentoraDetalhes->github_url }}" target="_blank" class="text-ellas-cyan hover:underline">{{ $mentoraDetalhes->github_url }}</a></p>
                            @endif
                            @if($mentoraDetalhes->linkedin_url)
                                <p><i class="fab fa-linkedin text-gray-400 mr-2"></i><a href="{{ $mentoraDetalhes->linkedin_url }}" target="_blank" class="text-ellas-cyan hover:underline">{{ $mentoraDetalhes->linkedin_url }}</a></p>
                            @endif
                            @if(!$mentoraDetalhes->github_url && !$mentoraDetalhes->linkedin_url)
                                <p class="text-gray-500 italic">Nenhum link cadastrado</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="font-orbitron text-sm text-ellas-pink uppercase mb-3">Cursos Atribuídos ({{ $mentoraDetalhes->cursos->count() }})</h4>
                        @if($mentoraDetalhes->cursos->count() > 0)
                            <div class="space-y-2">
                                @foreach($mentoraDetalhes->cursos as $curso)
                                    <div class="bg-ellas-dark/50 border border-ellas-nav rounded-lg p-3">
                                        <p class="text-white font-bold">{{ $curso->nome }}</p>
                                        <p class="text-xs text-gray-400">{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic">Nenhum curso atribuído.</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 border-t border-ellas-nav flex justify-end">
                    <button wire:click="fecharModal" class="px-6 py-2 bg-ellas-purple hover:bg-ellas-pink text-white rounded-lg font-orbitron text-xs uppercase transition-all">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>