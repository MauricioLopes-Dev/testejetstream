<x-action-section>
    <x-slot name="title">
        {{ __('Excluir Time') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Excluir permanentemente este time.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Uma vez que um time for excluído, todos os seus recursos e dados serão permanentemente deletados. Antes de excluir este time, por favor, baixe quaisquer dados ou informações referentes a este time que você queira reter.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('Excluir Time') }}
            </x-danger-button>
        </div>

        <x-confirmation-modal wire:model.live="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('Excluir Time') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Tem certeza de que deseja excluir este time? Uma vez que um time é excluído, todos os seus recursos e dados serão permanentemente deletados.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ __('Excluir Time') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>