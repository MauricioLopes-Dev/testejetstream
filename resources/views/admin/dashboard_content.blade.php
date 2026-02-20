<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Painel</span> Administrativo
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Estatísticas Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Alunas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalAlunas ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-crown text-6xl text-ellas-pink"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Mentoras</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalMentoras ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-clock text-6xl text-ellas-purple"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Pendentes</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $mentorasPendentes->count() ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-graduation-cap text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Cursos</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ \App\Models\Curso::count() }}</div>
                </div>
            </div>

            <!-- Ações Rápidas Admin -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <!-- Gestão de Cursos e Mentorias -->
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 shadow-2xl">
                    <h3 class="font-orbitron text-lg text-white font-bold mb-6 flex items-center">
                        <i class="fas fa-cogs text-ellas-purple mr-3"></i>
                        ESTRUTURA
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('admin.cursos.index') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-purple transition-all group">
                            <div class="text-ellas-purple font-bold text-sm group-hover:scale-105 transition-all">Gerenciar Cursos</div>
                            <p class="text-[10px] text-gray-400 mt-1">Criar cursos e atribuir mentoras</p>
                        </a>
                        <a href="{{ route('admin.mentoras.index') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-cyan transition-all group">
                            <div class="text-ellas-cyan font-bold text-sm group-hover:scale-105 transition-all">Gerenciar Mentoras</div>
                            <p class="text-[10px] text-gray-400 mt-1">Ver informações e excluir contas</p>
                        </a>
                        <a href="{{ route('admin.alunas.index') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-pink transition-all group">
                            <div class="text-ellas-pink font-bold text-sm group-hover:scale-105 transition-all">Gerenciar Alunas</div>
                            <p class="text-[10px] text-gray-400 mt-1">Ver informações e excluir contas</p>
                        </a>
                    </div>
                </div>

                <!-- Gestão de Conteúdo -->
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 shadow-2xl">
                    <h3 class="font-orbitron text-lg text-white font-bold mb-6 flex items-center">
                        <i class="fas fa-newspaper text-ellas-cyan mr-3"></i>
                        CONTEÚDO
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('admin.historias.criar') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-cyan transition-all group">
                            <div class="text-ellas-cyan font-bold text-sm group-hover:scale-105 transition-all">Criar Histórias</div>
                            <p class="text-[10px] text-gray-400 mt-1">Publicar no blog da comunidade</p>
                        </a>
                        <a href="{{ route('admin.eventos.criar') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-pink transition-all group">
                            <div class="text-ellas-pink font-bold text-sm group-hover:scale-105 transition-all">Criar Eventos</div>
                            <p class="text-[10px] text-gray-400 mt-1">Workshops e encontros</p>
                        </a>
                        <a href="{{ route('admin.depoimentos.gerenciar') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-purple transition-all group">
                            <div class="text-ellas-purple font-bold text-sm group-hover:scale-105 transition-all">Depoimentos</div>
                            <p class="text-[10px] text-gray-400 mt-1">Gerenciar feedbacks do site</p>
                        </a>
                    </div>
                </div>

                <!-- Configurações do Site -->
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 shadow-2xl">
                    <h3 class="font-orbitron text-lg text-white font-bold mb-6 flex items-center">
                        <i class="fas fa-sliders-h text-ellas-pink mr-3"></i>
                        SITE
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('admin.sobre.editar') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-pink transition-all group">
                            <div class="text-ellas-pink font-bold text-sm group-hover:scale-105 transition-all">Editar "Sobre"</div>
                            <p class="text-[10px] text-gray-400 mt-1">Alterar textos e imagens iniciais</p>
                        </a>
                        <a href="{{ route('admin.mentoras.pendentes') }}" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-purple transition-all group">
                            <div class="text-ellas-purple font-bold text-sm group-hover:scale-105 transition-all">Aprovar Mentoras</div>
                            <p class="text-[10px] text-gray-400 mt-1">Analisar novos cadastros</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
