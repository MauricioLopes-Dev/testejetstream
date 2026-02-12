<x-guest-layout>
    <a href="/" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-cyan transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-cyan group-hover:bg-ellas-cyan/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar</span>
    </a>

    <div class="mb-8 mt-4">
        <h2 class="font-orbitron text-2xl text-white">Crie sua conta</h2>
        <p class="font-biorhyme text-gray-400 text-sm mt-2">Escolha seu perfil e junte-se a nós.</p>
    </div>

    <div x-data="{ tab: 'aluna' }">
        <div class="flex mb-8 border-b border-ellas-nav">
            <button @click="tab = 'aluna'" :class="{ 'text-ellas-pink border-b-2 border-ellas-pink': tab === 'aluna', 'text-gray-500 hover:text-white': tab !== 'aluna' }" class="pb-2 px-4 font-orbitron transition-colors focus:outline-none">
                Aluna
            </button>
            <button @click="tab = 'mentora'" :class="{ 'text-ellas-pink border-b-2 border-ellas-pink': tab === 'mentora', 'text-gray-500 hover:text-white': tab !== 'mentora' }" class="pb-2 px-4 font-orbitron transition-colors focus:outline-none">
                Mentora
            </button>
        </div>

        <x-validation-errors class="mb-4" />

        <!-- Cadastro Aluna -->
        <div x-show="tab === 'aluna'" class="space-y-6">
            <form method="POST" action="{{ route('cadastro.aluna') }}" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <x-label for="name" value="Nome Completo" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                            <i class="fas fa-user"></i>
                        </div>
                        <x-input id="name" class="block w-full pl-10 bg-ellas-dark border-ellas-nav text-white" type="text" name="nome" :value="old('nome')" required autofocus placeholder="Seu nome completo" />
                    </div>
                </div>
                <div class="space-y-2">
                    <x-label for="email" value="Email" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ellas-cyan">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <x-input id="email" class="block w-full pl-10 bg-ellas-dark border-ellas-nav text-white" type="email" name="email" :value="old('email')" required placeholder="seu@email.com" />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <x-label for="password" value="Senha" />
                        <x-input id="password" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="password" name="password" required placeholder="••••" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="password_confirmation" value="Confirmar" />
                        <x-input id="password_confirmation" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="password" name="password_confirmation" required placeholder="••••" />
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-[1.02] transition-all">
                    CADASTRAR COMO ALUNA <i class="fas fa-rocket ml-2"></i>
                </button>
            </form>
        </div>

        <!-- Cadastro Mentora -->
        <div x-show="tab === 'mentora'" class="space-y-6">
            <form method="POST" action="{{ route('cadastro.mentora') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <x-label for="m_name" value="Nome Completo *" />
                        <x-input id="m_name" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="text" name="nome" :value="old('nome')" required placeholder="Nome completo" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="m_email" value="Email *" />
                        <x-input id="m_email" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="email" name="email" :value="old('email')" required placeholder="email@mentora.com" />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <x-label for="m_pass" value="Senha (mín. 8) *" />
                        <x-input id="m_pass" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="password" name="password" required placeholder="••••" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="m_conf" value="Confirmar Senha *" />
                        <x-input id="m_conf" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="password" name="password_confirmation" required placeholder="••••" />
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <x-label for="m_tel" value="Telefone *" />
                        <x-input id="m_tel" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="text" name="telefone" :value="old('telefone')" required placeholder="(00) 00000-0000" />
                    </div>
                    <div class="space-y-2">
                        <x-label for="m_area" value="Área de Atuação *" />
                        <select name="area_atuacao_id" id="m_area" class="block w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-3 font-biorhyme focus:ring-ellas-pink focus:border-ellas-pink">
                            @foreach(\App\Models\AreaAtuacao::all() as $area)
                                <option value="{{ $area->id }}" {{ old('area_atuacao_id') == $area->id ? 'selected' : '' }}>{{ $area->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-2">
                    <x-label for="m_exp" value="Nível de Experiência *" />
                    <select name="nivel_experiencia" id="m_exp" class="block w-full bg-ellas-dark border-ellas-nav text-white rounded-lg py-3 font-biorhyme focus:ring-ellas-pink focus:border-ellas-pink">
                        <option value="estudante" {{ old('nivel_experiencia') == 'estudante' ? 'selected' : '' }}>Iniciante / Estudante</option>
                        <option value="junior" {{ old('nivel_experiencia') == 'junior' ? 'selected' : '' }}>Júnior</option>
                        <option value="pleno" {{ old('nivel_experiencia') == 'pleno' ? 'selected' : '' }}>Pleno</option>
                        <option value="senior" {{ old('nivel_experiencia') == 'senior' ? 'selected' : '' }}>Sênior</option>
                        <option value="lideranca" {{ old('nivel_experiencia') == 'lideranca' ? 'selected' : '' }}>Liderança / Gestão</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <x-label for="m_github" value="GitHub URL" />
                        <x-input id="m_github" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="url" name="github_url" :value="old('github_url')" placeholder="https://github.com/..." />
                    </div>
                    <div class="space-y-2">
                        <x-label for="m_linkedin" value="LinkedIn URL" />
                        <x-input id="m_linkedin" class="block w-full bg-ellas-dark border-ellas-nav text-white" type="url" name="linkedin_url" :value="old('linkedin_url')" placeholder="https://linkedin.com/in/..." />
                    </div>
                </div>
                <div class="space-y-2">
                    <x-label for="m_sobre" value="Sobre Mim" />
                    <textarea id="m_sobre" name="sobre_mim" class="block w-full bg-ellas-dark border-ellas-nav text-white rounded-lg p-3 focus:ring-ellas-pink focus:border-ellas-pink" rows="3" placeholder="Fale um pouco sobre suas capacitações...">{{ old('sobre_mim') }}</textarea>
                </div>
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-[1.02] transition-all">
                    SOLICITAR PERFIL DE MENTORA <i class="fas fa-crown ml-2"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="mt-8 text-center">
        <p class="font-biorhyme text-gray-400 text-sm">
            Já tem uma conta? <a href="{{ route('login') }}" class="text-ellas-cyan hover:text-ellas-pink transition-colors">Faça login</a>
        </p>
    </div>
</x-guest-layout>
