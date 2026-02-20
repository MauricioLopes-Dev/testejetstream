<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class SubmeterDepoimento extends Component
{
    public $nome;
    public $profissao;
    public $depoimento;
    public $foto_url;
    public $showForm = false;
    public $depoimentoEnviado = false;

    public function mount()
    {
        if (Auth::check()) {
            $this->nome = Auth::user()->name;
        }
    }

    public function enviarDepoimento()
    {
        $this->validate([
            'nome' => 'required|min:3|max:255',
            'profissao' => 'required|min:3|max:255',
            'depoimento' => 'required|min:20|max:500',
            'foto_url' => 'nullable|url',
        ]);

        Testimonial::create([
            'name' => $this->nome,
            'role' => $this->profissao,
            'content' => $this->depoimento,
            'photo_url' => $this->foto_url,
            'is_active' => false, // Aguardando aprovação do admin
        ]);

        $this->reset(['nome', 'profissao', 'depoimento', 'foto_url', 'showForm']);
        $this->depoimentoEnviado = true;
        
        session()->flash('message', 'Depoimento enviado com sucesso! Aguardando aprovação do administrador.');
    }

    public function render()
    {
        return view('livewire.submeter-depoimento');
    }
}
