<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Criar Novo Evento</h2>

            <form wire:submit.prevent="salvar">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Título do Evento</label>
                        <input type="text" wire:model="titulo" class="w-full border rounded p-2">
                        @error('titulo') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Data e Hora</label>
                        <input type="datetime-local" wire:model="data_hora" class="w-full border rounded p-2">
                        @error('data_hora') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2">Descrição</label>
                    <textarea wire:model="descricao" rows="3" class="w-full border rounded p-2"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Local / Link</label>
                        <input type="text" wire:model="local" placeholder="Ex: Google Meet" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Limite de Vagas (0 = Ilimitado)</label>
                        <input type="number" wire:model="limite_vagas" class="w-full border rounded p-2">
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                    Agendar Evento
                </button>
            </form>
        </div>
    </div>
</div>