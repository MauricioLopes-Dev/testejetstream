<x-app-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Portal</span> Administrativo
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Total de Alunas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalAlunas }}</div>
                    <div class="mt-4 text-ellas-cyan text-xs font-biorhyme">Usuárias ativas no sistema</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-crown text-6xl text-ellas-pink"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Mentoras Ativas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalMentoras }}</div>
                    <div class="mt-4 text-ellas-pink text-xs font-biorhyme">Especialistas aprovadas</div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav flex items-center justify-between">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-clipboard-check text-ellas-purple mr-3"></i>
                        SOLICITAÇÕES DE MENTORIA
                    </h3>
                    <span class="bg-ellas-purple/20 text-ellas-purple px-3 py-1 rounded-full text-xs font-bold">
                        {{ $mentorasPendentes->count() }} PENDENTES
                    </span>
                </div>
                
                <div class="p-0">
                    @if($mentorasPendentes->isEmpty())
                        <div class="text-center py-20">
                            <i class="fas fa-inbox text-5xl text-gray-700 mb-4"></i>
                            <p class="text-gray-500 font-biorhyme italic">Nenhuma nova solicitação para análise.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-ellas-dark/50">
                                        <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Mentora</th>
                                        <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider">Área / Experiência</th>
                                        <th class="px-6 py-4 font-orbitron text-xs text-gray-400 uppercase tracking-wider text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-ellas-nav">
                                    @foreach($mentorasPendentes as $mentora)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-white">{{ $mentora->nome }}</div>
                                                <div class="text-xs text-ellas-cyan">{{ $mentora->email }}</div>
                                                <div class="text-[10px] text-gray-500">{{ $mentora->telefone }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-300">{{ $mentora->areaAtuacao->nome }}</div>
                                                <div class="text-[10px] text-ellas-pink uppercase font-bold">{{ $mentora->nivel_experiencia }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center gap-3">
                                                    <form action="{{ route('admin.aprovar_mentora', $mentora->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-2 border border-green-500/20">
                                                            <i class="fas fa-check"></i> APROVAR
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.reprovar_mentora', $mentora->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-2 border border-red-500/20">
                                                            <i class="fas fa-times"></i> REPROVAR
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
