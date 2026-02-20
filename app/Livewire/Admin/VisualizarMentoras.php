<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Mentora;
use Illuminate\Support\Facades\Auth;

class VisualizarMentoras extends Component
{
    public $mentoras;
    public $mentoraDetalhes = null;
    public $showModal = false;

    public function mount()
    {
        if (Auth::guard('admin')->guest()) {
            abort(403, 'Acesso não autorizado.');
        }

        $this->carregarMentoras();
    }

    public function carregarMentoras()
    {
        $this->mentoras = Mentora::with('areaAtuacao')
                                 ->where('status_aprovacao', 'aprovado')
                                 ->latest()
                                 ->get();
    }

    public function verDetalhes($mentoraId)
    {
        $this->mentoraDetalhes = Mentora::with(['areaAtuacao', 'cursos'])->find($mentoraId);
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->mentoraDetalhes = null;
    }

    public function excluir($mentoraId)
    {
        Mentora::find($mentoraId)->delete();
        session()->flash('message', 'Mentora excluída com sucesso!');
        $this->carregarMentoras();
    }

    public function render()
    {
        return view('livewire.admin.visualizar-mentoras')->layout('layouts.admin');
    }
}
