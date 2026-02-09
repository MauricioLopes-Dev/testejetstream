<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white leading-tight">Central do Aluno</h2>
            <p class="text-gray-600 dark:text-gray-400">Gerencie seus estudos e conexões em um só lugar.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-8 gap-12 items-start">
            
            <div class="lg:col-span-8 space-y-8">
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                            <span class="mr-2">🎓</span> Meus Cursos e Aulas
                        </h3>
                    </div>

                    @if($proximasAulas->isEmpty() && $aulasPassadas->isEmpty())
                        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 shadow-sm">
                            <div class="text-4xl mb-3">📚</div>
                            <p class="text-gray-500 dark:text-gray-400 mb-5">Você ainda não possui cursos inscritos.</p>
                            <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                                Explorar Eventos
                            </a>
                        </div>
                    @else
                        @if($proximasAulas->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
                                @foreach($proximasAulas as $curso)
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                                        <div class="h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                                        <div class="p-5 flex-1 flex flex-col">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-500">
                                                    {{ $curso->data_hora->format('d/m • H:i') }}
                                                </span>
                                                @if($curso->data_hora <= now())
                                                    <span class="flex items-center bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold animate-pulse">
                                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> AO VIVO
                                                    </span>
                                                @endif
                                            </div>
                                            <h4 class="font-bold text-gray-900 dark:text-white text-base mb-2 leading-tight">{{ $curso->titulo }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-5 flex-1">{{ $curso->descricao }}</p>
                                            
                                            <div class="grid grid-cols-2 gap-3">
                                                @if($curso->local && filter_var($curso->local, FILTER_VALIDATE_URL))
                                                    <a href="{{ $curso->local }}" target="_blank" class="text-center py-2 text-xs font-bold border border-indigo-200 text-indigo-600 rounded-lg hover:bg-indigo-50 transition dark:border-gray-600 dark:text-indigo-400">Aula</a>
                                                @endif
                                                @if($curso->material_link)
                                                    <button wire:click="baixarMaterial({{ $curso->id }})" class="py-2 text-xs font-bold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">Material</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($aulasPassadas->isNotEmpty())
                            <div class="bg-gray-50/50 dark:bg-gray-800/40 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                                <h4 class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-widest">Histórico e Gravações</h4>
                                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($aulasPassadas->take(4) as $curso)
                                        <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0">
                                            <div class="min-w-0 pr-4">
                                                <p class="text-sm font-bold text-gray-700 dark:text-gray-300 truncate">{{ $curso->titulo }}</p>
                                                <p class="text-[10px] text-gray-500">{{ $curso->data_hora->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="flex gap-3">
                                                @if($curso->material_link)
                                                    <button wire:click="baixarMaterial({{ $curso->id }})" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 text-xs font-bold">Material</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </section>
            </div>

            <div class="lg:col-span-4">
                <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 sticky top-6">
                    <div class="p-6 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Mentorias</h3>
                        <span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-md font-bold">{{ $candidaturas->count() }}</span>
                    </div>

                    <div class="p-5">
                        @if($candidaturas->isEmpty())
                            <div class="text-center py-6">
                                <p class="text-xs text-gray-400 mb-4">Sem solicitações no momento.</p>
                                <a href="{{ route('mentoras.index') }}" class="inline-block w-full text-center py-2 text-xs bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg font-bold hover:bg-gray-100 transition">Buscar Mentora</a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($candidaturas as $item)
                                    <div class="group p-4 rounded-xl border border-gray-50 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/20 hover:border-indigo-100 transition-colors">
                                        <div class="flex items-center mb-4">
                                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white dark:ring-gray-800 shadow-sm" src="{{ $item->mentora->profile_photo_url }}" alt="" />
                                            <div class="ml-3 min-w-0">
                                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate leading-tight">{{ $item->mentora->name }}</p>
                                                <p class="text-[10px] text-gray-500 truncate mt-0.5">{{ $item->mentora->area_atuacao }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            @if($item->status === 'pendente')
                                                <span class="text-[10px] font-bold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-md">Aguardando</span>
                                            @elseif($item->status === 'aceito')
                                                <a href="mailto:{{ $item->mentora->email }}" class="text-[10px] font-bold text-white bg-green-500 px-3 py-1 rounded-md hover:bg-green-600 transition flex items-center">
                                                    📧 Contatar
                                                </a>
                                            @else
                                                <span class="text-[10px] font-bold text-red-400 bg-red-50 px-2 py-0.5 rounded-md">Finalizada</span>
                                            @endif
                                            <span class="text-[10px] text-gray-400 font-medium">{{ $item->created_at->format('d/m/y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            </div>

        </div> </div>
</div>