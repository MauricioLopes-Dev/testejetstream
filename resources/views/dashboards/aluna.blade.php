<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Painel da Aluna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Bloco Principal -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-8 transition duration-300">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
                    Olá, {{ Auth::user()->name }}! 🚀
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    Bem-vinda de volta. Organize seus estudos e conecte-se.
                </p>

                <!-- Grid de Ações -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <a href="{{ route('agenda.index') }}" class="block p-6 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-xl hover:shadow-md hover:scale-[1.02] transition transform group">
                        <div class="text-indigo-600 dark:text-indigo-400 mb-3 text-3xl group-hover:scale-110 transition-transform">🗓️</div>
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Minha Agenda</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Veja suas aulas e mentorias confirmadas.</p>
                    </a>

                    <a href="{{ route('mentoras.index') }}" class="block p-6 bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800 rounded-xl hover:shadow-md hover:scale-[1.02] transition transform group">
                        <div class="text-purple-600 dark:text-purple-400 mb-3 text-3xl group-hover:scale-110 transition-transform">👩‍🏫</div>
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Buscar Mentora</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Encontre profissionais para te orientar.</p>
                    </a>

                    <a href="{{ route('eventos.index') }}" class="block p-6 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-xl hover:shadow-md hover:scale-[1.02] transition transform group">
                        <div class="text-green-600 dark:text-green-400 mb-3 text-3xl group-hover:scale-110 transition-transform">🚀</div>
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Workshops</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Inscreva-se em eventos ao vivo.</p>
                    </a>

                    <a href="{{ route('blog.index') }}" class="block p-6 bg-pink-50 dark:bg-pink-900/20 border border-pink-100 dark:border-pink-800 rounded-xl hover:shadow-md hover:scale-[1.02] transition transform group">
                        <div class="text-pink-600 dark:text-pink-400 mb-3 text-3xl group-hover:scale-110 transition-transform">✨</div>
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">Ler Histórias</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Inspire-se com trajetórias reais.</p>
                    </a>

                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row gap-6">
                    <a href="{{ route('candidaturas.index') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-sm font-medium transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Histórico de Solicitações
                    </a>
                    
                    <a href="{{ route('completar-perfil') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-sm font-medium transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Atualizar meu Perfil
                    </a>
                </div>
            </div>

            <!-- NOVA SEÇÃO: Minhas Mentoras Ativas -->
            @php
                $mentoriasAtivas = \App\Models\Solicitacao::with('mentora')
                    ->where('aluna_id', Auth::id())
                    ->where('status', 'aceito')
                    ->take(3)
                    ->get();
            @endphp

            @if($mentoriasAtivas->isNotEmpty())
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <span class="mr-2">👩‍🏫</span> Minhas Mentoras
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($mentoriasAtivas as $solicitacao)
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 hover:border-indigo-300 dark:hover:border-indigo-600 transition">
                            <img class="h-12 w-12 rounded-full object-cover border border-gray-200 dark:border-gray-600" src="{{ $solicitacao->mentora->profile_photo_url }}" alt="{{ $solicitacao->mentora->name }}">
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 dark:text-white truncate">{{ $solicitacao->mentora->name }}</h4>
                                <p class="text-xs text-indigo-500 truncate">{{ $solicitacao->mentora->area_atuacao }}</p>
                            </div>
                            <a href="{{ route('mentoras.show', $solicitacao->mentora->id) }}" class="text-xs bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-300 px-3 py-1.5 rounded-full hover:bg-indigo-100 dark:hover:bg-indigo-800 transition font-bold">
                                Ver
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>