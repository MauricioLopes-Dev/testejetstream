<?php

namespace App\Livewire\Aluna;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilAluna extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $telefone;
    public $foto;
    public $foto_url;

    // Alteração de senha
    public $current_password;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'telefone' => 'nullable|string|max:20',
        'foto' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->telefone = $user->telefone;
        $this->foto_url = $user->profile_photo_url;
    }

    public function atualizarPerfil()
    {
        $this->validate();

        $user = Auth::user();
        
        $dados = [
            'name' => $this->name,
            'telefone' => $this->telefone,
        ];

        // Upload de foto
        if ($this->foto) {
            // Remove foto antiga se existir
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $path = $this->foto->store('profile-photos', 'public');
            $dados['profile_photo_path'] = $path;
        }

        $user->update($dados);

        session()->flash('message', 'Perfil atualizado com sucesso!');
        $this->foto = null;
        $this->foto_url = $user->fresh()->profile_photo_url;
    }

    public function alterarSenha()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'A senha atual está incorreta.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->password)
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('senha_message', 'Senha alterada com sucesso!');
    }

    public function render()
    {
        return view('livewire.aluna.perfil-aluna')->layout('layouts.app');
    }
}
