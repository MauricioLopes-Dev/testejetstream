<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Cabeçalho com Botão de Criar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Gestão de Aulas e Presença</h2>
            
            <a href="{{ route('eventos.criar') }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold transition shadow-md group">
                <svg class="w-5 h-5 mr-2 -ml-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Agendar Nova Aula
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-6">
                {{ session('message') }}
            </div>
        @endif

        <div class="space-y-8">
            @forelse($aulas as $aula)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-100 dark:border-gray-700 transition duration-300">
                    
                    <!-- Cabeçalho da Aula -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <div class="text-sm text-indigo-600 dark:text-indigo-400 font-bold uppercase tracking-wide">
                                {{ $aula->data_hora->format('d/m/Y \à\s H:i') }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $aula->titulo }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Local: {{ $aula->local }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex items-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $aula->participantes->count() > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-300' }}">
                                {{ $aula->participantes->count() }} Alunas Inscritas
                            </span>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Coluna 1: Material de Apoio (COM UPLOAD) -->
                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-800 dark:text-gray-200 flex items-center">
                                <span class="text-xl mr-2">📚</span> Material da Aula
                            </h4>
                            
                            <!-- Opção A: Link Externo -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Link Externo (Drive/Youtube)</label>
                                <input 
                                    type="text" 
                                    wire:model="materialLinks.{{ $aula->id }}" 
                                    placeholder="https://..." 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                                >
                            </div>

                            <!-- Opção B: Upload de Arquivo -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">OU Anexar Arquivo (PDF/Slide)</label>
                                <div class="flex items-center gap-2">
                                    <input 
                                        type="file" 
                                        wire:model="arquivos.{{ $aula->id }}" 
                                        class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300 transition"
                                    >
                                    
                                    <!-- Spinner de Carregamento -->
                                    <div wire:loading wire:target="arquivos.{{ $aula->id }}">
                                        <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>
                                @error("arquivos.{$aula->id}") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <button 
                                wire:click="salvarMaterial({{ $aula->id }})"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold transition shadow-md mt-2"
                            >
                                Salvar Material
                            </button>

                            @if($aula->material_link)
                                <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-700 rounded text-sm break-all">
                                    <span class="font-bold text-gray-600 dark:text-gray-300">Material Atual:</span>
                                    <a href="{{ $aula->material_link }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline block mt-1">
                                        {{ Str::limit($aula->material_link, 50) }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Coluna 2: Lista de Presença -->
                        <div>
                            <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                                <span class="text-xl mr-2">📋</span> Lista de Inscritas
                            </h4>
                            
                            @if($aula->participantes->isEmpty())
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/30 rounded-lg text-center border border-dashed border-gray-300 dark:border-gray-600">
                                    <p class="text-gray-500 dark:text-gray-400 text-sm italic">Nenhuma inscrição ainda.</p>
                                </div>
                            @else
                                <div class="max-h-60 overflow-y-auto pr-2 space-y-2 custom-scrollbar">
                                    @foreach($aula->participantes as $aluna)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                                            <div class="flex items-center">
                                                <img class="h-8 w-8 rounded-full object-cover mr-3 border border-gray-200 dark:border-gray-500" src="{{ $aluna->profile_photo_url }}" alt="">
                                                <div>
                                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ $aluna->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $aluna->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-dashed border-gray-300 dark:border-gray-700">
                    <p class="text-gray-500 dark:text-gray-400 text-lg mb-2">Você ainda não criou nenhuma aula.</p>
                    <a href="{{ route('eventos.criar') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">
                        Criar meu primeiro evento agora
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</div>