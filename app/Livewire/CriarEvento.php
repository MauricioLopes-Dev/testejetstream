<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class CriarEvento extends Component
{
    public $titulo, $descricao, $data_hora, $data_fim, $local, $limite_vagas = 0;

    public function mount()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado');
        }
    }

    public function salvar()
    {
        $this->validate([
            'titulo' => 'required|min:5',
            'data_hora' => 'required|date|after:today',
            'data_fim' => 'required|date|after:data_hora',
            'limite_vagas' => 'integer|min:0',
        ]);

        Event::create([
            'user_id' => Auth::id(),
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_hora' => $this->data_hora,
            'data_fim' => $this->data_fim,
            'local' => $this->local,
            'limite_vagas' => $this->limite_vagas,
        ]);

        session()->flash('message', 'Aula criada com sucesso! Agora você pode anexar o material.');
        
        // MUDANÇA AQUI: Redireciona para 'minhas-aulas' em vez de 'eventos'
        return redirect()->route('aulas.index');
    }

    public function render()
    {
        return view('livewire.admin.criar-evento')->layout('layouts.admin');
    }
}