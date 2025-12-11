<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Meus Cursos e Aulas</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Acesse os materiais e conteúdos das aulas que você participa.</p>

        @if($proximasAulas->isEmpty() && $aulasPassadas->isEmpty())
             <!-- ESTADO VAZIO -->
             <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-dashed border-gray-300 dark:border-gray-700">
                <div class="text-5xl mb-4 text-gray-300 dark:text-gray-600">🎓</div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Nenhum curso encontrado</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Inscreva-se em workshops para ver o conteúdo aqui.</p>
                <a href="{{ route('eventos.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition">
                    Ver Eventos Disponíveis
                </a>
            </div>
        @else

            <!-- 1. PRÓXIMAS AULAS -->
            @if($proximasAulas->isNotEmpty())
                <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-4 flex items-center">
                    <span class="mr-2">📅</span> Próximas Aulas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($proximasAulas as $curso)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col h-full hover:border-indigo-300 dark:hover:border-indigo-700 transition">
                            <!-- Topo Colorido (Futuro) -->
                            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        {{ $curso->data_hora->format('d/m/Y') }}
                                    </span>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">Em breve</span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $curso->titulo }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">{{ $curso->descricao }}</p>

                                <div class="mt-auto space-y-3">
                                    <!-- Link da Aula -->
                                    @if($curso->local && filter_var($curso->local, FILTER_VALIDATE_URL))
                                        <a href="{{ $curso->local }}" target="_blank" class="flex items-center justify-center w-full py-2 px-4 border border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 font-bold transition">
                                            Acessar Sala
                                        </a>
                                    @endif

                                    <!-- Material -->
                                    @if($curso->material_link)
                                        <a href="{{ $curso->material_link }}" target="_blank" class="flex items-center justify-center w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition shadow-md">
                                            Baixar Material
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 2. HISTÓRICO / PASSADOS -->
            @if($aulasPassadas->isNotEmpty())
                <h3 class="text-xl font-bold text-gray-600 dark:text-gray-400 mb-4 flex items-center border-t border-gray-200 dark:border-gray-700 pt-8">
                    <span class="mr-2">📚</span> Histórico e Materiais
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($aulasPassadas as $curso)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col h-full opacity-90 hover:opacity-100 transition">
                            <!-- Topo Cinza (Passado) -->
                            <div class="h-2 bg-gray-300 dark:bg-gray-600"></div>

                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        {{ $curso->data_hora->format('d/m/Y') }}
                                    </span>
                                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs px-2 py-1 rounded-full font-bold">Encerrado</span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $curso->titulo }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-3">{{ $curso->descricao }}</p>

                                <div class="mt-auto space-y-3">
                                    <!-- Material (Foco Principal no Histórico) -->
                                    @if($curso->material_link)
                                        <a href="{{ $curso->material_link }}" target="_blank" class="flex items-center justify-center w-full py-2 px-4 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-lg font-bold transition shadow-md">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Acessar Material
                                        </a>
                                    @else
                                        <div class="text-center text-xs text-gray-400 italic py-2">Sem material disponível</div>
                                    @endif
                                    
                                    <!-- Link da gravação se disponível no campo local -->
                                    @if($curso->local && filter_var($curso->local, FILTER_VALIDATE_URL))
                                         <a href="{{ $curso->local }}" target="_blank" class="text-xs text-center block text-indigo-500 hover:underline">Ver Link/Gravação</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @endif
    </div>
</div>