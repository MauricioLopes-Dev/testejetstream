<div class="py-12 bg-ellas-dark min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden flex flex-col h-[600px]">
            <!-- Header do Chat -->
            <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-ellas-purple to-ellas-pink flex items-center justify-center text-white mr-4 shadow-lg">
                        <i class="fas fa-comments text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-orbitron text-lg text-white font-bold">Chat com {{ $interlocutor }}</h3>
                        <p class="text-xs text-gray-400">Tire suas dúvidas e troque conhecimentos</p>
                    </div>
                </div>
                <a href="{{ $tipoUsuario === 'mentora' ? route('mentora.dashboard') : route('dashboard') }}" class="px-4 py-2 bg-ellas-nav hover:bg-ellas-purple text-white rounded-lg text-xs font-bold transition-all">
                    <i class="fas fa-arrow-left mr-2"></i>VOLTAR
                </a>
            </div>

            <!-- Corpo do Chat -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-ellas-dark/20" id="chat-container">
                @forelse($mensagens as $msg)
                    <div class="flex {{ ($msg->remetente === $tipoUsuario) ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%] rounded-2xl px-4 py-3 {{ ($msg->remetente === $tipoUsuario) ? 'bg-gradient-to-r from-ellas-purple to-ellas-pink text-white rounded-tr-none shadow-lg' : 'bg-ellas-nav text-gray-200 rounded-tl-none border border-ellas-nav' }}">
                            <p class="text-sm font-biorhyme break-words">{{ $msg->mensagem }}</p>
                            <span class="text-[10px] opacity-70 mt-2 block text-right">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 flex flex-col items-center justify-center h-full">
                        <i class="fas fa-comments text-6xl text-gray-700/30 mb-4"></i>
                        <p class="text-gray-500 italic font-biorhyme">Nenhuma mensagem ainda. Comece a conversa!</p>
                    </div>
                @endforelse
            </div>

            <!-- Input de Mensagem -->
            <div class="p-6 border-t border-ellas-nav bg-ellas-dark/50">
                <form wire:submit.prevent="enviarMensagem" class="flex gap-3">
                    <input 
                        type="text" 
                        wire:model.defer="mensagem" 
                        placeholder="Digite sua dúvida aqui..." 
                        class="flex-1 bg-ellas-dark border border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-cyan focus:ring-2 focus:ring-ellas-cyan/30 rounded-xl py-3 px-4 transition-all"
                    >
                    <button type="submit" class="bg-gradient-to-r from-ellas-purple to-ellas-pink text-white px-6 py-3 rounded-xl font-orbitron font-bold hover:scale-105 transition-all shadow-lg hover:shadow-xl">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        const container = document.getElementById('chat-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });

    window.addEventListener('livewire:updated', function () {
        const container = document.getElementById('chat-container');
        if (container) {
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        }
    });
</script>
