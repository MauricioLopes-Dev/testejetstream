<x-guest-layout>
    <a href="{{ route('register') }}" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-cyan transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-cyan group-hover:bg-ellas-cyan/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar para Cadastro</span>
    </a>

    <div class="w-full max-w-md mx-auto mt-20 mb-10">
            
            <div class="mb-8 text-center sm:text-left">
                <a href="/" class="hidden lg:block font-orbitron font-bold text-4xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan mb-2 py-2 leading-normal">
                    Conectada com ELLAS
                </a>
                <h2 class="font-orbitron text-2xl text-white leading-relaxed">Seja uma Mentora</h2>
                <p class="font-biorhyme text-gray-400 text-sm mt-2">Compartilhe conhecimento e inspire outras mulheres.</p>
            </div>

            <x-validation-errors class="mb-4" />

            <div class="pb-20">
                <form method="POST" action="{{ route('register.mentor') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <x-label for="name" value="{{ __('Nome Completo') }}" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                <i class="fas fa-user"></i>
                            </div>
                            <x-input id="name" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Como devemos te chamar?" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="email" value="{{ __('Email Profissional') }}" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <x-input id="email" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="area_atuacao" value="{{ __('Área de Atuação') }}" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <x-input id="area_atuacao" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="text" name="area_atuacao" :value="old('area_atuacao')" required placeholder="Ex: Engenharia de Software, UX Design, Data Science" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="linkedin_url" value="{{ __('Perfil do LinkedIn (Opcional)') }}" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                <i class="fab fa-linkedin"></i>
                            </div>
                            <x-input id="linkedin_url" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="url" name="linkedin_url" :value="old('linkedin_url')" placeholder="https://linkedin.com/in/voce" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="bio" value="{{ __('Breve Resumo (Bio)') }}" />
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                <i class="fas fa-align-left"></i>
                            </div>
                            <textarea id="bio" name="bio" rows="3" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20 rounded-md shadow-sm text-white placeholder-gray-500" placeholder="Conte um pouco sobre sua experiência...">{{ old('bio') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <x-label for="password" value="{{ __('Senha') }}" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <x-input id="password" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="password" name="password" required autocomplete="new-password" placeholder="••••" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <x-label for="password_confirmation" value="{{ __('Confirmar') }}" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <x-input id="password_confirmation" class="block w-full pl-10 bg-ellas-dark border-ellas-nav focus:border-ellas-cyan focus:ring focus:ring-ellas-cyan/20" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••" />
                            </div>
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required class="bg-ellas-dark border-ellas-nav text-ellas-cyan focus:ring-ellas-cyan" />
                                    <div class="ms-2 text-gray-400 text-xs font-biorhyme">
                                        {!! __('Concordo com os :terms_of_service e :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-ellas-cyan hover:text-white">'.__('Termos').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-ellas-cyan hover:text-white">'.__('Privacidade').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-cyan to-ellas-purple rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(4,203,239,0.3)] hover:shadow-[0_0_30px_rgba(4,203,239,0.5)] hover:scale-[1.02] transition-all duration-300 flex justify-center items-center gap-2 mt-8 mb-8">
                        REGISTRAR COMO MENTORA <i class="fas fa-rocket"></i>
                    </button>
                </form>
            </div>
        </div>
</x-guest-layout>