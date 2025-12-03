<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CompletarPerfil extends Component
{
    // Variáveis que estarão ligadas aos campos do formulário
    public $role = 'aluna'; // Valor padrão
    public $area_atuacao;
    public $linkedin_url;
    public $bio;

    public function mount()
    {
        // Quando a página carrega, preenchemos os campos com o que já existe no banco (se houver)
        $user = Auth::user();
        $this->role = $user->role ?? 'aluna';
        $this->area_atuacao = $user->area_atuacao;
        $this->linkedin_url = $user->linkedin_url;
        $this->bio = $user->bio;
    }

    public function salvar()
    {
        // 1. Validação básica
        $this->validate([
            'role' => 'required|in:mentora,aluna',
            'area_atuacao' => 'required|min:3',
            'bio' => 'nullable|max:500',
        ]);

        // 2. Salvar no Banco de Dados
        // O user() pega o usuário logado atual
        Auth::user()->update([
            'area_atuacao' => $this->area_atuacao,
            'linkedin_url' => $this->linkedin_url,
            'bio' => $this->bio,
        ]);

        // 3. Avisar e Redirecionar
        session()->flash('message', 'Perfil atualizado com sucesso!');
        return redirect()->route('dashboard');
    }

    public function render()
{
    return view('livewire.completar-perfil')->layout('layouts.app');
}
}
