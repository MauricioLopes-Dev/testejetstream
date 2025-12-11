<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Minha Agenda</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Seus próximos compromissos e datas importantes.</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Coluna Principal: Linha do Tempo de Eventos -->
            <div class="lg:col-span-2 space-y-8">
                @if($calendario->isEmpty())
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 text-center border border-dashed border-gray-300 dark:border-gray-700">
                        <div class="text-4xl mb-4">📅</div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Agenda Vazia</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Você não tem eventos agendados nos próximos dias.</p>
                        <a href="{{ route('eventos.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Explorar Eventos</a>
                    </div>
                @else
                    @foreach($calendario as $dia => $eventosDoDia)
                        <div class="relative pl-8 border-l-2 border-indigo-200 dark:border-indigo-900">
                            <!-- Bolinha da Data -->
                            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-indigo-600 dark:bg-indigo-500 border-4 border-white dark:border-gray-900"></div>
                            
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 capitalize">
                                {{ \Carbon\Carbon::parse($dia)->isoFormat('dddd, D \d\e MMMM') }}
                            </h3>

                            <div class="space-y-4">
                                @foreach($eventosDoDia as $evento)
                                    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center hover:border-indigo-300 dark:hover:border-indigo-700 transition">
                                        <div>
                                            <span class="inline-block px-2 py-1 rounded text-xs font-bold bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 mb-2">
                                                {{ $evento->data_hora->format('H:i') }}
                                            </span>
                                            <h4 class="font-bold text-lg text-gray-900 dark:text-white">{{ $evento->titulo }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Local: {{ $evento->local ?? 'Online' }}</p>
                                        </div>
                                        <div class="mt-4 sm:mt-0">
                                            @if($evento->local && filter_var($evento->local, FILTER_VALIDATE_URL))
                                                <a href="{{ $evento->local }}" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline font-bold">
                                                    Entrar na Sala &rarr;
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Coluna Lateral: Resumo de Mentorias -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 sticky top-24">
                    <h3 class="font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <span class="mr-2">👩‍🏫</span> Mentorias Ativas
                    </h3>
                    
                    @if($mentorias->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma mentoria ativa.</p>
                        <a href="{{ route('mentoras.index') }}" class="text-xs text-pink-600 dark:text-pink-400 hover:underline mt-2 block">Buscar Mentora</a>
                    @else
                        <ul class="space-y-4">
                            @foreach($mentorias as $solicitacao)
                                <li class="flex items-center gap-3 pb-3 border-b border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                                    <img src="{{ $solicitacao->mentora->profile_photo_url }}" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $solicitacao->mentora->name }}</p>
                                        <a href="mailto:{{ $solicitacao->mentora->email }}" class="text-xs text-indigo-500 hover:underline">Entrar em contato</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>