<x-admin-layout>
    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Estatísticas Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-cyan transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Alunas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalAlunas ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-pink transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-crown text-6xl text-ellas-pink"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Mentoras</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalMentoras ?? 0 }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-purple transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-graduation-cap text-6xl text-ellas-purple"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Cursos</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ \App\Models\Curso::count() }}</div>
                </div>
            </div>

            <!-- Ações Rápidas Admin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <!-- Gestão de Cursos -->
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
                    </div>
                </div>

                <!-- Gestão de Conteúdo -->
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 shadow-2xl">
                    <h3 class="font-orbitron text-lg text-white font-bold mb-6 flex items-center">
                        <i class="fas fa-newspaper text-ellas-cyan mr-3"></i>
                        CONTEÚDO
                    </h3>
                    <div class="space-y-4">
                        <a href="/" class="block p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-cyan transition-all group">
                            <div class="text-ellas-cyan font-bold text-sm group-hover:scale-105 transition-all">Gerenciar Conteúdo</div>
                            <p class="text-[10px] text-gray-400 mt-1">Editar Sobre, Histórias e Depoimentos</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Gestão de Alunas e Mentoras -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Alunas -->
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan mr-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h4 class="font-orbitron text-lg text-white font-bold">Alunas</h4>
                                <p class="text-xs text-gray-400">Total: {{ $totalAlunas ?? 0 }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.alunas.index') }}" class="px-4 py-2 bg-ellas-cyan/20 text-ellas-cyan hover:bg-ellas-cyan hover:text-white rounded-lg text-xs font-bold transition-all">
                            VER TODAS
                        </a>
                    </div>
                    <div class="p-6 space-y-3 max-h-[400px] overflow-y-auto">
                        @php
                            $alunas = \App\Models\User::latest()->take(5)->get();
                        @endphp
                        @forelse($alunas as $aluna)
                            <div class="flex items-center justify-between p-3 bg-ellas-dark/30 rounded-lg border border-ellas-nav hover:border-ellas-cyan/50 transition-all">
                                <div class="flex items-center flex-1">
                                    <img src="{{ $aluna->profile_photo_url }}" class="w-8 h-8 rounded-full mr-3 object-cover border border-ellas-cyan/30">
                                    <div>
                                        <div class="text-white font-bold text-sm">{{ $aluna->name }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $aluna->cursos()->count() }} curso(s)</div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.alunas.index') }}" class="text-ellas-cyan hover:text-ellas-purple transition-all">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 italic text-xs py-8">Nenhuma aluna cadastrada.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Mentoras -->
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-ellas-pink/20 flex items-center justify-center text-ellas-pink mr-3">
                                <i class="fas fa-crown"></i>
                            </div>
                            <div>
                                <h4 class="font-orbitron text-lg text-white font-bold">Mentoras</h4>
                                <p class="text-xs text-gray-400">Total: {{ $totalMentoras ?? 0 }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.mentoras.index') }}" class="px-4 py-2 bg-ellas-pink/20 text-ellas-pink hover:bg-ellas-pink hover:text-white rounded-lg text-xs font-bold transition-all">
                            VER TODAS
                        </a>
                    </div>
                    <div class="p-6 space-y-3 max-h-[400px] overflow-y-auto">
                        @php
                            $mentoras = \App\Models\Mentora::where('status_aprovacao', 'aprovado')->latest()->take(5)->get();
                        @endphp
                        @forelse($mentoras as $mentora)
                            <div class="flex items-center justify-between p-3 bg-ellas-dark/30 rounded-lg border border-ellas-nav hover:border-ellas-pink/50 transition-all">
                                <div class="flex items-center flex-1">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-ellas-purple to-ellas-pink flex items-center justify-center text-white text-xs font-bold mr-3">
                                        {{ substr($mentora->nome, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-white font-bold text-sm">{{ $mentora->nome }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $mentora->cursos()->count() }} curso(s)</div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.mentoras.index') }}" class="text-ellas-pink hover:text-ellas-purple transition-all">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 italic text-xs py-8">Nenhuma mentora aprovada.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Mentoras Pendentes de Aprovação -->
            @if($mentorasPendentes && $mentorasPendentes->count() > 0)
                <div class="mt-10 bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-ellas-nav bg-gradient-to-r from-ellas-purple/20 to-ellas-pink/20 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-400 mr-3">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div>
                                <h4 class="font-orbitron text-lg text-white font-bold">Mentoras Pendentes de Aprovação</h4>
                                <p class="text-xs text-gray-400">{{ $mentorasPendentes->count() }} aguardando revisão</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.mentoras.pendentes') }}" class="px-4 py-2 bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500 hover:text-white rounded-lg text-xs font-bold transition-all">
                            REVISAR
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="mt-12 text-center">
            <p class="text-gray-600 text-xs font-mono">
                &copy; {{ date('Y') }} Projeto ELLAS.<br>Acesso restrito a pessoal autorizado.
            </p>
            <a href="/" class="inline-block mt-4 text-ellas-cyan hover:text-white text-sm transition font-orbitron">
            </a>
        </div>
    </div>
</x-admin-layout>
