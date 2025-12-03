<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Início') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-indigo-600 mb-2">Olá, {{ Auth::user()->name }}! 🚀</h3>
                <p class="text-gray-600">
                    Você está logada como: 
                    <span class="font-bold uppercase">{{ Auth::user()->role }}</span>
                </p>
                
                <div class="mt-6 border-t pt-4">
                    <p>O que você deseja fazer hoje?</p>
                    <div class="mt-4 flex gap-4">
                        <button class="bg-purple-100 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-200">
                            📅 Ver Mentorias
                        </button>
                        <button class="bg-pink-100 text-pink-700 px-4 py-2 rounded-lg hover:bg-pink-200">
                            ✨ Ver Inspirações
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>