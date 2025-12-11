<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col h-full hover:border-indigo-300 dark:hover:border-indigo-700 transition">
    
    <!-- Topo Colorido -->
    <div class="h-2 {{ $status == 'future' ? 'bg-gradient-to-r from-indigo-500 to-purple-500' : 'bg-gray-300 dark:bg-gray-600' }}"></div>

    <div class="p-6 flex-1 flex flex-col">
        <div class="flex justify-between items-start mb-4">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                {{ $curso->data_hora->format('d/m/Y') }}
            </span>
            @if($status == 'past')
                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs px-2 py-1 rounded-full font-bold">Encerrado</span>
            @else
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Em breve</span>
            @endif
        </div>

        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $curso->titulo }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">{{ $curso->descricao }}</p>

        <div class="mt-auto space-y-3">
            <!-- Botão de Link da Aula (Só aparece se for URL válida e aula futura) -->
            @if($status == 'future' && $curso->local && filter_var($curso->local, FILTER_VALIDATE_URL))
                <a href="{{ $curso->local }}" target="_blank" class="flex items-center justify-center w-full py-2 px-4 border border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 font-bold transition">
                    Acessar Sala
                </a>
            @endif

            <!-- Botão de Material (Sempre aparece se tiver) -->
            @if($curso->material_link)
                <a href="{{ $curso->material_link }}" target="_blank" class="flex items-center justify-center w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Baixar Material
                </a>
            @else
                 @if($status == 'past')
                    <div class="text-center text-xs text-gray-400 italic mt-2">Sem material disponível</div>
                 @endif
            @endif
        </div>
    </div>
</div>