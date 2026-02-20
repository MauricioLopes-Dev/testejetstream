<?php

namespace App\Livewire\Mentora;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilMentora extends Component
{
    public $nome;
    public $email;
    public $telefone;
    public $area_atuacao;
    public $nivel_experiencia;

    // Alteração de senha
    public $current_password;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function mount()
    {
        $mentora = Auth::guard('mentora')->user();
        $this->nome = $mentora->nome;
        $this->email = $mentora->email;
        $this->telefone = $mentora->telefone;
        $this->area_atuacao = $mentora->areaAtuacao->nome ?? 'N/A';
        $this->nivel_experiencia = $mentora->nivel_experiencia;
    }

    public function alterarSenha()
    {
        $this->validate();

        $mentora = Auth::guard('mentora')->user();

        if (!Hash::check($this->current_password, $mentora->password)) {
            $this->addError('current_password', 'A senha atual está incorreta.');
            return;
        }

        $mentora->update([
            'password' => Hash::make($this->password)
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('message', 'Senha alterada com sucesso!');
    }

    public function render()
    {
        return view('livewire.mentora.perfil-mentora')->layout('layouts.mentora');
    }
}
