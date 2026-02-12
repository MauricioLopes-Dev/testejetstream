<x-app-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Painel</span> Administrativo
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Estatísticas Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 transition-transform">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Alunas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalAlunas ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 transition-transform">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-crown text-6xl text-ellas-pink"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Mentoras</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalMentoras ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 transition-transform">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-clock text-6xl text-ellas-purple"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Pendentes</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $mentorasPendentes->count() ?? 0 }}</div>
                </div>
            </div>

            <!-- Grid de Funcionalidades -->
            <div class="mb-10">
                <h3 class="font-orbitron text-ellas-pink text-sm uppercase tracking-widest mb-6">Gerenciamento de Conteúdo</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <!-- Aprovar Mentoras -->
                    <a href="{{ route('admin.mentoras.pendentes') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-purple/20 hover:border-ellas-purple transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-cyan/10 rounded-full flex items-center justify-center group-hover:bg-ellas-cyan/20 transition-colors">
                                <i class="fas fa-user-check text-2xl text-ellas-cyan"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Aprovar Mentoras</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Gerenciar solicitações</span>
                        </div>
                    </a>

                    <!-- Criar Eventos -->
                    <a href="{{ route('admin.eventos.criar') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-pink/20 hover:border-ellas-pink transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-pink/10 rounded-full flex items-center justify-center group-hover:bg-ellas-pink/20 transition-colors">
                                <i class="fas fa-calendar-plus text-2xl text-ellas-pink"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Criar Eventos</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Adicionar novos eventos</span>
                        </div>
                    </a>

                    <!-- Gerenciar Cursos -->
                    <a href="{{ route('admin.aulas.gerenciar') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-cyan/20 hover:border-ellas-cyan transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-cyan/10 rounded-full flex items-center justify-center group-hover:bg-ellas-cyan/20 transition-colors">
                                <i class="fas fa-graduation-cap text-2xl text-ellas-cyan"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Gerenciar Cursos</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Administrar aulas</span>
                        </div>
                    </a>

                    <!-- Criar Histórias -->
                    <a href="{{ route('admin.historias.criar') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-pink/20 hover:border-ellas-pink transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-pink/10 rounded-full flex items-center justify-center group-hover:bg-ellas-pink/20 transition-colors">
                                <i class="fas fa-book-open text-2xl text-ellas-pink"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Criar Histórias</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Publicar no blog</span>
                        </div>
                    </a>

                    <!-- Gerenciar Depoimentos -->
                    <a href="{{ route('admin.depoimentos.gerenciar') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-purple/20 hover:border-ellas-purple transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-purple/10 rounded-full flex items-center justify-center group-hover:bg-ellas-purple/20 transition-colors">
                                <i class="fas fa-quote-left text-2xl text-ellas-purple"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Depoimentos</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Adicionar testemunhos</span>
                        </div>
                    </a>

                    <!-- Editar Sobre -->
                    <a href="{{ route('admin.sobre.editar') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-cyan/20 hover:border-ellas-cyan transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-cyan/10 rounded-full flex items-center justify-center group-hover:bg-ellas-cyan/20 transition-colors">
                                <i class="fas fa-edit text-2xl text-ellas-cyan"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Editar Sobre</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Modificar seção sobre</span>
                        </div>
                    </a>

                    <!-- Perfil/Configurações -->
                    <a href="{{ route('admin.perfil') }}" class="bg-ellas-card border border-ellas-nav rounded-xl p-6 hover:bg-ellas-pink/20 hover:border-ellas-pink transition-all group">
                        <div class="flex flex-col items-center text-center space-y-3">
                            <div class="w-16 h-16 bg-ellas-pink/10 rounded-full flex items-center justify-center group-hover:bg-ellas-pink/20 transition-colors">
                                <i class="fas fa-user-cog text-2xl text-ellas-pink"></i>
                            </div>
                            <span class="font-orbitron text-sm text-white font-bold">Configurações</span>
                            <span class="text-xs text-gray-400 font-biorhyme">Alterar senha</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Seção de Mentoras Pendentes -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav flex items-center justify-between">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-clipboard-check text-ellas-purple mr-3"></i>
                        SOLICITAÇÕES DE MENTORIA
                    </h3>
                    @if($mentorasPendentes->count() > 0)
                        <span class="px-3 py-1 bg-ellas-purple/20 text-ellas-purple rounded-full text-xs font-bold">
                            {{ $mentorasPendentes->count() }} pendente(s)
                        </span>
                    @endif
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
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-300">{{ $mentora->areaAtuacao->nome ?? 'N/A' }}</div>
                                                <div class="text-[10px] text-ellas-pink uppercase font-bold">{{ $mentora->nivel_experiencia }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center gap-3">
                                                    <form action="{{ route('admin.aprovar_mentora', $mentora->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500/10 text-green-500 hover:bg-green-500 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition-all border border-green-500/20">
                                                            APROVAR
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.reprovar_mentora', $mentora->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-xs font-bold transition-all border border-red-500/20">
                                                            REPROVAR
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
