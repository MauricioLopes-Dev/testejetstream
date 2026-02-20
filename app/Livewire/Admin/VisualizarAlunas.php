<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VisualizarAlunas extends Component
{
    public $alunas;
    public $alunaDetalhes = null;
    public $showModal = false;

    public function mount()
    {
        if (Auth::guard('admin')->guest()) {
            abort(403, 'Acesso não autorizado.');
        }

        $this->carregarAlunas();
    }

    public function carregarAlunas()
    {
        $this->alunas = User::withCount(['cursos', 'events'])->latest()->get();
    }

    public function verDetalhes($alunaId)
    {
        $this->alunaDetalhes = User::with(['cursos', 'events'])->find($alunaId);
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->alunaDetalhes = null;
    }

    public function excluir($alunaId)
    {
        User::find($alunaId)->delete();
        session()->flash('message', 'Aluna excluída com sucesso!');
        $this->carregarAlunas();
    }

    public function render()
    {
        return view('livewire.admin.visualizar-alunas')->layout('layouts.admin');
    }
}
