<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informações do Perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
    </x-slot>

    <x-slot name="form">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Foto de Perfil') }}" class="text-gray-300 font-orbitron" />

                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full size-24 object-cover border-4 border-ellas-purple shadow-lg">
                </div>

                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-24 bg-cover bg-no-repeat bg-center border-4 border-ellas-pink"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="button" class="px-4 py-2 bg-ellas-purple text-white text-xs font-bold rounded-lg hover:bg-ellas-pink transition-all" x-on:click.prevent="$refs.photo.click()">
                        SELECIONAR FOTO
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button" class="px-4 py-2 bg-red-600/20 text-red-400 text-xs font-bold rounded-lg border border-red-600/50" wire:click="deleteProfilePhoto">
                            REMOVER
                        </button>
                    @endif
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-label for="name" value="{{ __('Nome') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full bg-ellas-dark border-ellas-nav text-white focus:ring-ellas-purple" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-label for="telefone" value="{{ __('Telefone') }}" />
            <x-input id="telefone" type="text" class="mt-1 block w-full bg-ellas-dark border-ellas-nav text-white focus:ring-ellas-purple" wire:model="state.telefone" />
            <x-input-error for="telefone" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4 mt-4">
            <x-label for="email" value="{{ __('E-mail') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full bg-ellas-dark border-ellas-nav text-white focus:ring-ellas-purple" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 text-white">
                    {{ __('Seu endereço de e-mail não foi verificado.') }}

                    <button type="button" class="underline text-sm text-gray-400 hover:text-white" wire:click.prevent="sendEmailVerification">
                        {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Salvo.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Salvar') }}
        </x-button>
    </x-slot>
</x-form-section>