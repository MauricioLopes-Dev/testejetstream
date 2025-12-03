<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class CriarEvento extends Component
{
    public $titulo, $descricao, $data_hora, $local, $limite_vagas = 0;

    public function mount()
    {
        // Trava de Segurança
        if (!in_array(Auth::user()->role, ['admin', 'mentora'])) {
            abort(403, 'Acesso não autorizado');
        }
    }

    public function salvar()
    {
        $this->validate([
            'titulo' => 'required|min:5',
            'data_hora' => 'required|date|after:today', // Só datas futuras
            'limite_vagas' => 'integer|min:0',
        ]);

        Event::create([
            'user_id' => Auth::id(),
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_hora' => $this->data_hora,
            'local' => $this->local,
            'limite_vagas' => $this->limite_vagas,
        ]);

        session()->flash('message', 'Evento criado com sucesso!');
        return redirect()->route('eventos.index'); // Vamos criar essa rota jájá
    }

    public function render()
    {
        return view('livewire.criar-evento')->layout('layouts.app');
    }
}