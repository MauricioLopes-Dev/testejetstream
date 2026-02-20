<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 transition duration-300">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Criar Novo Evento</h2>

            <form wire:submit.prevent="salvar">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Título do Evento</label>
                        <input type="text" wire:model="titulo" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded p-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Datas na mesma linha para melhor visualização -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Início</label>
                            <input type="datetime-local" wire:model="data_hora" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('data_hora') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Término</label>
                            <input type="datetime-local" wire:model="data_fim" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded p-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('data_fim') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Descrição</label>
                    <textarea wire:model="descricao" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('descricao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Local / Link</label>
                        <input type="text" wire:model="local" placeholder="Ex: Google Meet" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded p-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('local') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2 text-gray-700 dark:text-gray-300">Limite de Vagas (0 = Ilimitado)</label>
                        <input type="number" wire:model="limite_vagas" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 rounded p-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('limite_vagas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                    Agendar Evento
                </button>
            </form>
        </div>
    </div>
</div>