<x-app-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-semibold text-xl text-white leading-tight">
            {{ __('Tokens de API') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-app-layout>