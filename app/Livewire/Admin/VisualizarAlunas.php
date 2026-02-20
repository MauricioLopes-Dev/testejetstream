<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
        $query = User::query();
        
        $relations = [];
        if (Schema::hasTable('cursos')) {
            $relations[] = 'cursos';
        }
        if (Schema::hasTable('events')) {
            $relations[] = 'events';
        }

        if (!empty($relations)) {
            $this->alunas = $query->withCount($relations)->latest()->get();
        } else {
            $this->alunas = $query->latest()->get();
        }
    }

    public function verDetalhes($alunaId)
    {
        $query = User::query();
        
        $relations = [];
        if (Schema::hasTable('cursos')) {
            $relations[] = 'cursos';
        }
        if (Schema::hasTable('events')) {
            $relations[] = 'events';
        }

        if (!empty($relations)) {
            $this->alunaDetalhes = $query->with($relations)->find($alunaId);
        } else {
            $this->alunaDetalhes = $query->find($alunaId);
        }
        
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

    public function deslocarParaCurso($alunaId, $cursoId)
    {
        $aluna = User::find($alunaId);
        // Remove de todos os cursos e adiciona no novo
        $aluna->cursos()->detach();
        $aluna->cursos()->attach($cursoId);
        session()->flash('message', 'Aluna deslocada para o novo curso com sucesso!');
        $this->carregarAlunas();
    }

    public function render()
    {
        return view('livewire.admin.visualizar-alunas')->layout('layouts.admin');
    }
}
